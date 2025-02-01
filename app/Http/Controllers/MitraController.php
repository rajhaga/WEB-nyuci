<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Support\Facades\Hash;

class MitraController extends Controller
{
    // Menampilkan form register mitra
    public function registerMitra(Request $request)
{
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Validasi input
    $request->validate([
        'nama_pemilik' => 'required',
        'nomor_hp' => 'required|regex:/[0-9]{10,15}/',
        'nama_laundry' => 'required',
        'alamat' => 'required',
        'jam_operasional' => 'required',
        'layanan' => 'required',
        'harga' => 'required|numeric|min:1000',
        'metode_pembayaran' => 'required',
        'deskripsi' => 'required',
        'foto_tempat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = auth()->user();
    $user->update(['role' => 'mitra']);

    // Simpan file jika ada
    $fotoTempat = $request->file('foto_tempat') ? $request->file('foto_tempat')->store('mitra') : null;
    $fotoBukti = $request->file('foto_bukti') ? $request->file('foto_bukti')->store('mitra') : null;

    // Simpan data mitra
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
        'foto_tempat' => $fotoTempat,
        'foto_bukti' => $fotoBukti,
    ]);

    return redirect('/profile')->with('success', 'Registrasi mitra berhasil.');
}


}