<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Use Pengguna model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JenisPakaian;
use App\Models\PaketPakaian;
use Illuminate\Support\Facades\Log;


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
            'nama' => 'required|unique:pengguna', // Ensure unique 'nama' in 'pengguna' table
            'email' => 'required|email|unique:pengguna', // Ensure unique email
            'password' => 'required|confirmed|min:6', // Password must be confirmed
            'phone' => 'required|unique:pengguna', // Ensure unique phone number
        ]);

        $user = User::create([  // Use Pengguna model instead of User
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli', // Default role as 'pembeli'
            'phone' => $request->phone,
        ]);

        Auth::login($user);  // Automatically log in the new user

        return redirect('/login')->with('success', 'Registrasi berhasil!');  // Redirect to profile page
    }


    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string',  // Ensure 'nama' is required
            'password' => 'required|string',  // Ensure 'password' is required
        ]);

        // Attempt to authenticate the user using 'nama' and 'password'
        if (Auth::attempt(['nama' => $request->nama, 'password' => $request->password])) {
            $user = Auth::user();  // Get the authenticated user

            // Check the user's role and redirect accordingly
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');  // Redirect to admin dashboard
            } elseif ($user->role === 'mitra') {
                return redirect()->route('mitra.dashboard');  // Redirect to Mitra dashboard
            } else {
                return redirect()->route('profile');  // Default redirect for regular users
            }
        }

        // If authentication fails, return back with error
        return back()->withErrors([
            'nama' => 'Nama atau password salah.',  // Error message in Indonesian
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
