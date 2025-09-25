<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('pages.kelolauser.kelola_user', compact('users'));
    }

     public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('pages.kelolauser.edit_kelola_user', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);


        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Role berhasil diperbarui');
    }
}
