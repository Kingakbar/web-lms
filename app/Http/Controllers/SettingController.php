<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function settingPage()
    {
        return view('pages.settings.setting_page');
    }

    public function updateProfile(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'profile_picture.max'   => 'Ukuran foto tidak boleh lebih dari 2MB.',
            'profile_picture.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'profile_picture.image' => 'File yang diunggah harus berupa gambar.',
        ]);


        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_picture')) {

            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
