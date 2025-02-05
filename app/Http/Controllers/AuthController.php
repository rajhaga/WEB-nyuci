<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JenisPakaian;

class AuthController extends Controller
{
    // Menampilkan form register pembeli
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function pakaian(){
        $jenis_pakaian = JenisPakaian::all(); // Ambil semua jenis pakaian dari database
        return view('home',compact('jenis_pakaian'));
    }

    // Proses register pembeli
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:users',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli',
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return redirect('/profile')->with('success', 'Registrasi berhasil!');
    }
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
