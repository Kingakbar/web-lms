<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotApiPasswordController extends Controller
{

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // TODO: Kirim OTP ke email
        // Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json([
            'status' => true,
            'message' => 'Kode OTP berhasil dikirim ke email',
            'otp_debug' => $otp // <- nanti hapus, hanya untuk testing
        ]);
    }

    // Step 2: Submit OTP + password baru
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$reset) {
            return response()->json([
                'status' => false,
                'message' => 'Kode OTP tidak valid'
            ], 400);
        }

        // Expired OTP (misalnya 15 menit)
        if (Carbon::parse($reset->created_at)->addMinutes(15)->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Kode OTP sudah kadaluarsa'
            ], 400);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP setelah digunakan
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil direset'
        ]);
    }
}
