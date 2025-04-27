<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\JenisPakaian;
use App\Models\Pesanan;
use App\Models\PaketPakaian;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananItem;
use App\Models\Ulasan;
use Carbon\Carbon;


class MitraController extends Controller
{

    public function dashboard()
    {
        // Ambil data mitra yang login (misalnya berdasarkan user yang sedang login)
        $mitra = Mitra::where('user_id', auth()->id())->first();

        // Total saldo bulan ini
        $totalSaldoBulanIni = Pesanan::where('mitra_id', 3)
            ->whereIn('status', ['Diproses', 'Selesai'])  // Memastikan status adalah Diproses atau Selesai
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)  // Memastikan tahun sama dengan tahun sekarang
            ->sum('total_harga');

        // Total saldo bulan lalu
        $totalSaldoBulanLalu = Pesanan::where('mitra_id', $mitra->id)
            ->whereIn('status', ['Diproses', 'Selesai'])  // Status untuk pesanan yang sudah dibayar atau diterima
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_harga');

        // Menghitung persentase perubahan
        $persenPerubahan = 0;
        if ($totalSaldoBulanLalu > 0) {
            $persenPerubahan = (($totalSaldoBulanIni - $totalSaldoBulanLalu) / $totalSaldoBulanLalu) * 100;
        }

        // Grafik Pesanan Berdasarkan Bulan
        $pesananBulan = Pesanan::where('mitra_id', $mitra->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', ['Diproses', 'Selesai'])  // Mengambil hanya status 'Diproses' dan 'Selesai'
            ->selectRaw('MONTH(created_at) as bulan, SUM(total_harga) as total_pendapatan')
            ->groupBy('bulan')
            ->pluck('total_pendapatan', 'bulan')
            ->sortKeys()  // Menambahkan pengurutan berdasarkan bulan
            ->mapWithKeys(function ($item, $key) {
                return [Carbon::createFromFormat('m', $key)->format('F') => $item];
            });

        // Cari pendapatan terbesar
        $pendapatanTerbesar = $pesananBulan->max();
        $bulanPendapatanTerbesar = $pesananBulan->search($pendapatanTerbesar);

        // Cari pendapatan terkecil
        $pendapatanTerkecil = $pesananBulan->min();
        $bulanPendapatanTerkecil = $pesananBulan->search($pendapatanTerkecil);

        // Cari bulan terbaik
        $bulanTerbaik = $bulanPendapatanTerbesar;  // Bulan dengan pendapatan terbesar dianggap bulan terbaik

        // Ambil data jumlah pakaian yang dipesan per jenis pakaian
        $jenisPakaian = PesananItem::whereHas('pesanan', function ($query) use ($mitra) {
            $query->where('mitra_id', $mitra->id)
                ->whereIn('status', ['Diproses', 'Selesai']); // Mengambil pesanan yang sudah diproses atau selesai
        })
        ->selectRaw('item_id, SUM(jumlah) as total')
        ->groupBy('item_id')
        ->orderByDesc('total')
        ->take(5) // Mengambil 5 jenis pakaian teratas yang paling banyak dipesan
        ->get();

        // Ambil nama jenis pakaian berdasarkan item_id
        $jenisPakaianLabels = $jenisPakaian->map(function ($item) {
            return $item->jenisPakaian->nama; // Mengambil nama jenis pakaian dari relasi
        });

        $jenisPakaianData = $jenisPakaian->map(function ($item) {
            return $item->total; // Mengambil total jumlah yang dipesan
        });

        // Total Pesanan per Status
        $totalPesananMenunggu = Pesanan::where('mitra_id', $mitra->id)->where('status', 'Menunggu')->count();
        $totalPesananDiterima = Pesanan::where('mitra_id', $mitra->id)->where('status', 'Diterima')->count();
        $totalPesananDiproses = Pesanan::where('mitra_id', $mitra->id)->where('status', 'Diproses')->count();
        $totalPesananSelesai = Pesanan::where('mitra_id', $mitra->id)->where('status', 'Selesai')->count();
        $totalPesananDibatalkan = Pesanan::where('mitra_id', $mitra->id)->where('status', 'Dibatalkan')->count();

        // Review Mitra
        $ulasan = Ulasan::where('mitra_id', $mitra->id)
            ->avg('rating');

        // Render View Dashboard
        return view('mitra.dashboard', compact(
            'mitra', 'totalSaldoBulanIni', 'totalSaldoBulanLalu', 'persenPerubahan', 'pesananBulan', 'jenisPakaian', 
            'totalPesananMenunggu', 'totalPesananDiterima', 'totalPesananDiproses', 
            'totalPesananSelesai', 'totalPesananDibatalkan', 'ulasan', 
            'bulanTerbaik', 'pendapatanTerbesar', 'bulanPendapatanTerbesar', 'pendapatanTerkecil', 'bulanPendapatanTerkecil',
            'jenisPakaianLabels', 'jenisPakaianData'

        ));
    }

    

public function kelolaPesanan(Request $request)
{
    // Ambil data mitra berdasarkan ID pengguna yang login
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // Jika mitra tidak ditemukan, arahkan ke halaman utama
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Filter berdasarkan status jika ada
    $status = $request->status;

    // Ambil pesanan berdasarkan mitra dan status
    $orders = Pesanan::where('mitra_id', $mitra->id)
                     ->whereNotIn('status', ['Menunggu', 'Diterima']) // Filter pesanan yang tidak "Menunggu" atau "Diterima"
                     ->when($status, function($query) use ($status) {
                         return $query->where('status', $status); // Filter pesanan berdasarkan status jika ada
                     })
                     ->orderBy('created_at', 'desc')
                     ->paginate(12); // Sesuaikan jumlah item per halaman

    return view('mitra.kelola-pesanan', compact('orders','mitra'));
}

public function registerMitra(Request $request)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Validasi input
    $validatedData = $request->validate([
        'nama_pemilik' => 'required|string|max:255',
        'nomor_hp' => 'required|string|regex:/^\d{10,15}$/',
        'nama_laundry' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'jam_operasional' => 'required|string|max:255',
        'harga' => 'required|numeric|min:1000',
        'nomor_rekening' => 'required|numeric',
        'deskripsi' => 'required|string',
        'foto_tempat' => 'required|image|max:2048',
        'foto_bukti' => 'required|image|max:2048',
        'kategori_layanan' => 'required|in:cuci,setrika,cuci dan setrika',
        'paket_pakaian' => 'required|array',
        'paket_pakaian.*' => 'exists:paket_pakaians,id',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
    ]);

    try {
        // Ambil user yang sedang login
        $user = auth()->user();
        $user->update(['status' => 'pending']);

        // Simpan file foto (dengan pengecekan error)
        try {
            $fotoTempat = $request->file('foto_tempat')->store('mitra', 'public');
            $fotoBukti = $request->file('foto_bukti')->store('mitra', 'public');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto, coba lagi.');
        }

        // Simpan data mitra ke database
        $mitra = Mitra::create([
            'user_id' => $user->id,
            'nama_pemilik' => $validatedData['nama_pemilik'],
            'nomor_hp' => $validatedData['nomor_hp'],
            'nama_laundry' => $validatedData['nama_laundry'],
            'alamat' => $validatedData['alamat'],
            'jam_operasional' => $validatedData['jam_operasional'],
            'harga' => $validatedData['harga'],
            'nomor_rekening' => $validatedData['nomor_rekening'],
            'deskripsi' => $validatedData['deskripsi'],
            'foto_tempat' => $fotoTempat,
            'foto_bukti' => $fotoBukti,
            'kategori_layanan' => $validatedData['kategori_layanan'],
            'rating' => 0,
            'jumlah_ulasan' => 0,
            'latitude' => $validatedData['latitude'] ?? null,
            'longitude' => $validatedData['longitude'] ?? null,
        ]);

        // Sinkronisasi paket pakaian
        if (!empty($validatedData['paket_pakaian'])) {
            $mitra->paketPakaian()->sync($validatedData['paket_pakaian']);
        }

        return redirect()->route('profile')->with('success', 'Pendaftaran mitra berhasil, menunggu verifikasi.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan, coba lagi. ' . $e->getMessage());
    }
}
public function showRegisterMitraForm()
    {
       // Ambil semua paket pakaian dari database
    $paket_pakaian = PaketPakaian::with('jenisPakaian')->get(); // Mengambil semua paket pakaian beserta jenis pakaian yang terhubung

    // Kirim data ke view
    return view('auth.register_mitra', compact('paket_pakaian'));
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
     // Pastikan pengguna sudah login
     if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    // Query untuk mengambil data mitra dengan relasi
    $query = Mitra::query()->with(['paketPakaian', 'jenisPakaian']);

    // Filter berdasarkan kategori layanan jika ada
    if ($request->filled('kategori_layanan') && $request->kategori_layanan !== 'semua') {
        $query->where('kategori_layanan', $request->kategori_layanan);
    }

    // Filter berdasarkan paket layanan jika ada
    if ($request->filled('paket_layanan') && $request->paket_layanan !== 'semua') {
        $query->whereHas('paketPakaian', function ($q) use ($request) {
            $q->where('nama', $request->paket_layanan);
        });
    }

    // Ambil mitra yang sudah difilter dan dipaginasi
    $mitras = $query->orderBy('kategori_layanan', 'asc')
                    ->paginate(10)
                    ->withQueryString();  // Menyertakan query string pada link pagination

    // Mengembalikan view dengan data mitra dan filter yang dipilih
    return view('katalog.catalog', [
        'mitras' => $mitras,
        'kategori_layanan_selected' => $request->kategori_layanan ?? 'semua',  // Menyimpan nilai kategori_layanan yang dipilih
        'paket_layanan_selected' => $request->paket_layanan ?? 'semua',        // Menyimpan nilai paket_layanan yang dipilih
    ]);
}





public function updatePrice(Request $request, $mitraId)
{
    $request->validate([
        'jenis_pakaian' => 'required|array',
        'jenis_pakaian.*.id' => 'required|exists:jenis_pakaian,id',  // Pastikan ID jenis pakaian valid
        'jenis_pakaian.*.price' => 'required|numeric|min:0',  // Validasi harga
    ]);

    $mitra = Mitra::findOrFail($mitraId);

    // Update harga untuk setiap jenis pakaian yang terkait dengan mitra
    foreach ($request->jenis_pakaian as $item) {
        $mitra->jenisPakaian()->updateExistingPivot($item['id'], [
            'price' => $item['price']
        ]);
    }

    return redirect()->route('mitra.pengaturan', $mitra->id)->with('success', 'Harga jenis pakaian berhasil diperbarui');
}

public function pembayaran()
{
    // Ambil data mitra berdasarkan ID pengguna yang login
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // Periksa jika data mitra tidak ditemukan
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Ambil pesanan dengan status "Menunggu" dan "Diterima" untuk mitra terkait
    $pesananBelumDiterima = Pesanan::where('mitra_id', $mitra->id)
                                  ->whereIn('status', ['Menunggu', 'Diterima'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();

    return view('mitra.pembayaran', compact('pesananBelumDiterima','mitra'));
}

public function showKonfirmasiPembayaran($id)
{
    $pesanan = Pesanan::with('items')->findOrFail($id);

    return view('mitra.konfirmasi-pembayaran', compact('pesanan'));
}


public function konfirmasiPembayaran(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);
    
    // Ubah status pesanan menjadi "Diterima"
    $pesanan->status = 'Diterima';
    $pesanan->save();

    // Redirect ke halaman konfirmasi pembayaran
    return redirect()->route('mitra.showKonfirmasiPembayaran', $pesanan->id);
}

public function editStatus($id)
{
    $order = Pesanan::with('pesananItems.jenisPakaian')->findOrFail($id);
    return view('mitra.update-status', compact('order'));
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Menunggu,Diproses,Selesai',
    ]);

    $order = Pesanan::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->route('mitra.kelolaPesanan')->with('success', 'Status pesanan diperbarui!');
}

public function edit($id)
{
    $mitra = Mitra::findOrFail($id);
    return view('mitra.pengaturan', compact('mitra'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_pemilik' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:15',
        'nama_laundry' => 'required|string|max:255',
        'alamat' => 'required|string',
        'foto_tempat' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        'metode_pembayaran' => 'required|string',
        'paket' => 'required|array',
        'paket.*.nama' => 'required|string|max:255',
        'paket.*.harga' => 'required|numeric|min:0',
    ]);

    $mitra = Mitra::findOrFail($id);

    // Update mitra data
    $mitra->nama_pemilik = $request->nama_pemilik;
    $mitra->nomor_hp = $request->nomor_hp;
    $mitra->nama_laundry = $request->nama_laundry;
    $mitra->alamat = $request->alamat;
    $mitra->metode_pembayaran = $request->metode_pembayaran;

    // Handle foto tempat upload
    if ($request->hasFile('foto_tempat')) {
        // Delete old photo
        if ($mitra->foto_tempat) {
            Storage::delete($mitra->foto_tempat);
        }
        $mitra->foto_tempat = $request->file('foto_tempat')->store('foto_mitra');
    }

    $mitra->save();

    // Update harga dan nama paket pakaian (Sync paket_pakaian)
    foreach ($request->paket as $paketId => $paketData) {
        $paket = PaketPakaian::find($paketId);
        if ($paket) {
            // Update paket data
            $paket->update([
                'nama' => $paketData['nama'],
                'harga' => $paketData['harga']
            ]);
        }
    }

    // Sync paket pakaian jika ada perubahan
    if ($request->has('paket_pakaian')) {
        $mitra->paketPakaian()->sync($request->paket_pakaian);
    }

    return redirect()->route('mitra.pengaturan', $mitra->id)->with('success', 'Pengaturan Mitra berhasil diperbarui');
}

}

