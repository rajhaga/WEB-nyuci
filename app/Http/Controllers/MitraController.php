<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Support\Facades\Hash;

class MitraController extends Controller
{
    // Menampilkan form register mitra
    public function showRegisterMitraForm()
    {
        return view('auth.register_mitra');
    }

    // Proses register mitra
    public function registerMitra(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'nama_pemilik' => 'required',
            'nomor_hp' => 'required',
            'nama_laundry' => 'required',
            'alamat' => 'required',
            'jam_operasional' => 'required',
            'layanan' => 'required',
            'harga' => 'required',
            'metode_pembayaran' => 'required',
            'deskripsi' => 'required',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mitra',
        ]);

        Mitra::create([
            'user_id' => $user->id,
            'nama_pemilik' => $request->nama_pemilik,
            'nomor_hp' => $request->nomor_hp,
            'nama_laundry' => $request->nama_laundry,
            'alamat' => $request->alamat,
            'jam_operasional' => $request->jam_operasional,
            'layanan' => $request->layanan,
            'harga' => $request->harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'deskripsi' => $request->deskripsi,
            'foto_tempat' => $request->file('foto_tempat') ? $request->file('foto_tempat')->store('mitra') : null,
            'foto_bukti' => $request->file('foto_bukti') ? $request->file('foto_bukti')->store('mitra') : null,
            'lokasi' => $request->lokasi,
        ]);

        return redirect('/login')->with('success', 'Registrasi mitra berhasil! Silakan login.');
    }
}