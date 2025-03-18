<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil status dari request jika ada
        $status = $request->get('status');

        // Query hanya pesanan milik pengguna yang sedang login
        $query = Pesanan::with(['mitra', 'pesananItems.jenisPakaian'])
                        ->where('pembeli_id', $userId);

        // Jika ada filter status, tambahkan ke query
        if ($status) {
            $query->where('status', $status);
        }

        // Eksekusi query dan ambil hasilnya
        $pesanan = $query->get();

        return view('pesanan.index', compact('pesanan'));
    }

    // Menampilkan halaman pembayaran QRIS
    public function showQRIS(Pesanan $pesanan)
    {
        return view('pesanan.qris', compact('pesanan'));
    }

    // Konfirmasi pembayaran dan ubah status ke "Diproses"
    public function konfirmasiPembayaran(Pesanan $pesanan)
    {
        if ($pesanan->status === 'Pending') {
            $pesanan->update(['status' => 'Diproses']);
            return redirect()->route('pesanan.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
        }

        return redirect()->route('mitra.pembayaran')->with('error', 'Pesanan tidak dalam status yang bisa dikonfirmasi.');
    }
}
