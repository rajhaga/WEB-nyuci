<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $user = Auth::user();
        $mitra = auth()->user()->mitra;
        $jenisPakaian = $mitra ? $mitra->jenisPakaian : [];
        return view('profile', compact('user'));
        return view('profile', compact('jenisPakaian'));

    }

    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    // Memperbarui profil pengguna
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',  // Changed from 'name' to 'nama'
            'email' => 'required|email|unique:pengguna,email,' . $user->id,  // Changed table name to 'pengguna'
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|confirmed|min:6',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data dasar
        $user->nama = $request->nama;  // Changed from 'name' to 'nama'
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Ganti password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
    public function history()
    {
        $user = Auth::user();
        $pesanans = Pesanan::where('pembeli_id', $user->id)->with('items')->get();

        return view('order_history', compact('pesanans'));
    }
}
