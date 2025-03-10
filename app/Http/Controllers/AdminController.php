<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra; // Model untuk mitra
use App\Models\User;  // Model untuk user

class AdminController extends Controller
{
    // Menampilkan dashboard admin dengan pengguna yang statusnya 'pending'
    public function index()
    {
        // Ambil pengguna yang statusnya 'pending' (pengguna yang mendaftar sebagai mitra)
        $users = User::where('status', 'pending')->get();
        
        // Mengirim data pengguna yang belum diverifikasi ke view
        return view('admin.dashboard', compact('users'));
    }

    // Approve the user (verifikasi pengguna)
    public function approveUser($id)
{
    // Cari pengguna berdasarkan ID
    $user = User::findOrFail($id);

    // Set status menjadi 'verified'
    $user->status = 'verified'; // Set status jadi 'verified'

    // // Set role menjadi 'user' dulu
    // $user->role = 'user'; // Set role awal menjadi 'user'
    // $user->save();

    // Setelah status jadi verified dan role 'user', ubah role menjadi 'mitra'
    $user->role = 'mitra'; // Update role menjadi 'mitra'
    $user->save();

    return redirect()->back()->with('success', 'Pengguna berhasil diverifikasi dan role telah diperbarui menjadi Mitra.');
}


    // Menolak pengguna (menyatakan pendaftaran mitra ditolak)
    public function rejectUser($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Update status pengguna menjadi 'ditolak'
        $user->status = 'ditolak'; // Set status jadi 'ditolak'
        $user->save();

        return redirect()->back()->with('error', 'Pendaftaran mitra ditolak.');
    }
}
