<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('profile', compact('user'));
    }

    public function edit()
{
    $user = Auth::user();
    return view('profile_edit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'username' => 'required|string|unique:users,username,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update([
        'username' => $request->username,
        'email' => $request->email,
    ]);

    return redirect('/profile')->with('success', 'Profile updated successfully!');
}
}