<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
        }
        $users = User::get();
        return view('users')->with('userss', $users);
        
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return redirect('users')->with('error', 'User not found');
        }

        return view('edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return redirect('users')->with('error', 'User not found');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'photo' => 'image|nullable|max:1999'
        ]);

        // Update nama dan email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Simpan foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($user->photo) {
                $oldFile = public_path('storage/' . $user->photo);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
            // Simpan foto baru
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images', $filename, 'public');
            $user->photo = 'images/' . $filename;
        }

        $user->save();

        return redirect('users')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $file = public_path() . '/storage' . $user->photo;
        try {
            if (File::exists($file)) {
                File::delete($file);
                $user->delete();
            }
        } catch (\Throwable $th) {
            return redirect('users')->with('success', 'Gagal hapus data');
        }
        return redirect('users')->with('success', 'Berhasil hapus data');
    }
}
