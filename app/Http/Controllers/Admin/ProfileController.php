<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'old_password' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        // Periksa password lama jika ada
        if ($request->filled('password')) {
            if (!$request->filled('old_password')) {
                return redirect()->back()->with('error', 'Harap masukkan password saat ini untuk mengubah password.');
            }

            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'Password saat ini tidak cocok.');
            }
        }

        // Update data user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Gunakan update() daripada save()
        \App\Models\User::where('id', $user->id)->update($userData);

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
