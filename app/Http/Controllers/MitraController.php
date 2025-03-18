<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\JenisPakaian;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;


class MitraController extends Controller
{
//     public function dashboard()
// {
//     // Ambil data mitra berdasarkan ID pengguna yang login
//     $mitra = Mitra::where('user_id', Auth::id())->first();

//     // Periksa jika data mitra tidak ditemukan
//     if (!$mitra) {
//         return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
//     }

//     return view('mitra.dashboard', compact('mitra'));
// }
public function dashboard()
{
    // Ambil data mitra berdasarkan ID pengguna yang login
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // Periksa jika data mitra tidak ditemukan
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Total Saldo: Sum of 'total_harga' for orders with 'status' = 'Dibayar'
    $totalSaldo = Pesanan::where('mitra_id', $mitra->id)
                         ->where('status', 'Dibayar')
                         ->sum('total_harga');

    // Pendapatan Bulanan: Sum of 'total_harga' grouped by month and year for 'Dibayar' orders
    $pendapatanBulanan = Pesanan::where('mitra_id', $mitra->id)
                                ->where('status', 'Dibayar')
                                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_harga) as total')
                                ->groupBy('year', 'month')
                                ->orderBy('year', 'desc')
                                ->orderBy('month', 'desc')
                                ->get();

    // Status Pesanan: Count orders by each status
    $statusPesanan = [
        'pending' => Pesanan::where('mitra_id', $mitra->id)->where('status', 'Pending')->count(),
        'dibayar' => Pesanan::where('mitra_id', $mitra->id)->where('status', 'Dibayar')->count(),
        'diproses' => Pesanan::where('mitra_id', $mitra->id)->where('status', 'Diproses')->count(),
        'selesai' => Pesanan::where('mitra_id', $mitra->id)->where('status', 'Selesai')->count(),
    ];

    // Grafik Pesanan per Tahun: Count of orders per year
    $grafikPesanan = Pesanan::where('mitra_id', $mitra->id)
                            ->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                            ->groupBy('year')
                            ->orderBy('year', 'asc')
                            ->get();

    return view('mitra.dashboard', compact('mitra', 'totalSaldo', 'pendapatanBulanan', 'statusPesanan', 'grafikPesanan'));
}
public function kelolaPesanan()
{
    // Fetch orders related to the logged-in partner (mitra)
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // If mitra not found, redirect to the home page
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Fetch orders with their status and paginate them
    $orders = Pesanan::where('mitra_id', $mitra->id)
                     ->orderBy('created_at', 'desc')
                     ->paginate(12); // Adjust pagination as needed

    return view('mitra.kelola-pesanan', compact('orders'));
}


    public function registerMitra(Request $request)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_hp' => 'required|string|regex:/^\d{10,15}$/',
            'nama_laundry' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jam_operasional' => 'required|string|max:255',
            'layanan' => 'required|string',
            'harga' => 'required|numeric|min:1000',
            // 'metode_pembayaran' => 'required|string',
            'nomor_rekening' => 'required|numeric',
            'deskripsi' => 'required|string',
            'foto_tempat' => 'required|image|max:2048',
            'foto_bukti' => 'required|image|max:2048',
            'kategori_layanan' => 'required|in:cuci,setrika,cuci dan setrika',
            'paket_pakaian' => 'required|array',  // Menjamin bahwa paket yang dipilih adalah array
            'paket_pakaian.*' => 'exists:paket_pakaians,id', // Memastikan ID paket yang dipilih valid
        ]);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Set status user menjadi 'pending'
        $user->update(['status' => 'pending']);

        // Simpan file foto
        $fotoTempat = $request->file('foto_tempat') ? $request->file('foto_tempat')->store('mitra', 'public') : null;
        $fotoBukti = $request->file('foto_bukti') ? $request->file('foto_bukti')->store('mitra', 'public') : null;

        // Simpan data mitra
        $mitra = Mitra::create([
            'user_id' => $user->id, 
            'nama_pemilik' => $request->nama_pemilik,
            'nomor_hp' => $request->nomor_hp,
            'nama_laundry' => $request->nama_laundry,
            'alamat' => $request->alamat,
            'jam_operasional' => $request->jam_operasional,
            'layanan' => $request->layanan,
            'harga' => $request->harga,
            // 'metode_pembayaran' => $request->metode_pembayaran,
            'nomor_rekening' => $request->nomor_rekening,
            'deskripsi' => $request->deskripsi,
            'foto_tempat' => $fotoTempat,
            'foto_bukti' => $fotoBukti,
            'kategori_layanan' => $request->kategori_layanan,
            'rating' => 0, // Default
            'jumlah_ulasan' => 0, // Default
            'latitude' => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
        ]);

        // Sinkronisasi jenis pakaian yang dipilih
        // $mitra->jenisPakaian()->sync($request->jenis_pakaian);
        $mitra->paketPakaian()->sync($request->paket_pakaian);

        return redirect()->route('profile')->with('success', 'Pendaftaran mitra berhasil, menunggu verifikasi.');
    }

    // Fungsi untuk verifikasi mitra oleh admin
    public function verifikasi($id)
    {
        $mitra = Mitra::find($id);
        if ($mitra) {
            // Ubah status pendaftaran menjadi 'approved'
            $mitra->user->update(['status' => 'approved']);
            return redirect()->route('admin.dashboard')->with('success', 'Mitra berhasil diverifikasi.');
        }
        
        return redirect()->route('admin.dashboard')->with('error', 'Mitra tidak ditemukan.');
    }
    public function catalog(Request $request)
{
    // Start the query for Mitra
    $query = Mitra::query();

    // Filter by 'kategori_layanan' if provided
    if ($request->has('kategori_layanan') && $request->kategori_layanan != 'semua') {
        $query->where('kategori_layanan', $request->kategori_layanan);
    }

    // Filter by 'paket_layanan' if provided
    if ($request->has('paket_layanan') && $request->paket_layanan != 'semua') {
        $query->whereHas('paketPakaian', function ($q) use ($request) {
            // Filter by paket_pakaian id from request
            $q->where('paket_pakaians.id', $request->paket_layanan);
        });
    }
    $mitras = $query->with('jenisPakaian')->get();

    // Get the filtered and sorted Mitra results

    // Send the data to the view
    return view('katalog.catalog', compact('mitras'));
}
public function updatePrice(Request $request, $jenisPakaianId)
{
    // Validate the price input
    $request->validate([
        'price' => 'required|numeric|min:0',
    ]);

    // Find the clothing item (jenis pakaian) and the associated mitra
    $jenisPakaian = JenisPakaian::findOrFail($jenisPakaianId);

    // Get the authenticated user's mitra
    $mitra = auth()->user()->mitra;

    // Update the price in the pivot table
    $mitra->jenisPakaian()->updateExistingPivot($jenisPakaianId, [
        'price' => $request->price
    ]);

    // Redirect back to the profile page with a success message
    return redirect()->route('profile')->with('success', 'Price updated successfully!');
}
public function pembayaran()
{
    // Ambil data mitra berdasarkan ID pengguna yang login
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // Periksa jika data mitra tidak ditemukan
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Ambil pesanan dengan status "Belum" untuk mitra terkait
    $pesananBelumDibayar = Pesanan::where('mitra_id', $mitra->id)
                                  ->where('status', 'Pending')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

    return view('mitra.pembayaran', compact('pesananBelumDibayar'));
}

public function showKonfirmasiPembayaran($id)
{
    $pesanan = Pesanan::with('items')->findOrFail($id);

    return view('mitra.konfirmasi-pembayaran', compact('pesanan'));
}


public function konfirmasiPembayaran(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);
    
    // Ubah status pesanan menjadi "Dibayar"
    $pesanan->status = 'Dibayar';
    $pesanan->save();

    // Redirect ke halaman konfirmasi pembayaran
    return redirect()->route('mitra.showKonfirmasiPembayaran', $pesanan->id);
}
}

