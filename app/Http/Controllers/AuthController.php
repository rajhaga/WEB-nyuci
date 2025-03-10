<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Use Pengguna model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JenisPakaian;
use App\Models\PaketPakaian;

class AuthController extends Controller
{
    // Menampilkan form register pembeli
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function home()
    {
        $jenis_pakaian = JenisPakaian::all();
        $paket_pakaian = PaketPakaian::all();
        
        return view('home', compact('jenis_pakaian', 'paket_pakaian'));
    }

    // Proses register pembeli
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:pengguna', // Change users to pengguna
            'email' => 'required|email|unique:pengguna', // Change users to pengguna
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:pengguna', // Change users to pengguna
        ]);

        $user = User::create([  // Use Pengguna model instead of User
            'nama' => $request->nama, // Using 'nama' instead of 'nama'
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
            'nama' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['nama' => $request->nama, 'password' => $request->password])) { // Use 'nama' instead of 'nama'
            $user = Auth::user(); // Ambil data user yang login

            // Cek role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Redirect ke dashboard admin
            }

            return redirect()->intended('/profile'); // Redirect untuk user biasa
        }

        return back()->withErrors([
            'nama' => 'nama atau password salah.',
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
