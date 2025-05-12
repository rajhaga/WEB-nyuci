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
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;  // Import Storage jika menggunakan Storage untuk menyimpan file
use Illuminate\Support\Facades\Log; // Import Log untuk debugging

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
    // Retrieve mitra based on logged-in user
    $mitra = Mitra::where('user_id', Auth::id())->first();

    // If mitra not found, redirect to home page
    if (!$mitra) {
        return redirect()->route('home')->with('error', 'Mitra tidak ditemukan.');
    }

    // Capture the search and status from the request
    $search = $request->get('search');
    $status = $request->status;

    // Retrieve orders based on mitra, status, and search query
    $orders = Pesanan::where('mitra_id', $mitra->id)
                     ->whereNotIn('status', ['Menunggu', 'Diterima']) // Exclude "Menunggu" and "Diterima"
                     ->when($status, function($query) use ($status) {
                         return $query->where('status', $status); // Filter by status if provided
                     })
                     ->when($search, function($query) use ($search) {
                         // Search by order reference code or by customer name
                         return $query->where('kode_referral', 'like', '%' . $search . '%')
                                      ->orWhereHas('pembeli', function($query) use ($search) {  // Filter by user (customer) name
                                          $query->where('nama', 'like', '%' . $search . '%');
                                      });
                     })
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

    // Pass orders and mitra to the view
    return view('mitra.kelola-pesanan', compact('orders', 'mitra'));
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
        $query = Mitra::query()
                      ->with(['paketPakaian', 'jenisPakaian', 'user']); // pastikan relasi user ditambahkan
    
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
    
        // Filter berdasarkan status pengguna, kecuali status pending
        $query->whereHas('user', function ($q) {
            $q->where('status', '!=', 'pending');
        });
    
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
        'jenis_pakaian.*.id' => 'required|exists:jenis_pakaian,id',
        'jenis_pakaian.*.price' => 'required|numeric|min:0',
    ]);

    $mitra = Mitra::findOrFail($mitraId);

    foreach ($request->jenis_pakaian as $item) {
        $mitra->jenisPakaian()->updateExistingPivot($item['id'], [
            'price' => $item['price']
        ]);
    }

    return redirect()->route('mitra.pengaturan', $mitraId)
        ->with('success', 'Harga Jenis Pakaian berhasil diperbarui.');
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
    // Load mitra dengan relasi yang diperlukan
    $mitra = Mitra::with([
        'paketPakaian.jenisPakaian',
        'jenisPakaian' => function($query) use ($id) {
            $query->withPivot('price', 'paket_pakaian_id');
        }
    ])->findOrFail($id);

    $paketPakaianOptions = PaketPakaian::all();

    return view('mitra.pengaturan', compact('mitra', 'paketPakaianOptions'));
}

public function updateIdentitas(Request $request, $id)
{
    // Validasi data yang diterima
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email',
        'nomor_telepon' => 'required|string|max:15',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Mencari data mitra berdasarkan ID
    $mitra = Mitra::findOrFail($id);

    // Update data identitas mitra
    $mitra->update([
        'nama_pemilik' => $request->nama_lengkap,
        'nomor_hp' => $request->nomor_telepon,
    ]);

    // Update email dan password jika ada perubahan
    $user = $mitra->user;
    if ($request->email) {
        $user->email = $request->email;
    }
    if ($request->password) {
        $user->password = bcrypt($request->password); // Pastikan password dienkripsi
    }
    $user->save(); // Simpan perubahan

    return redirect()->route('mitra.pengaturan', $mitra->id)
        ->with('success', 'Identitas Mitra berhasil diperbarui.');
}

public function updateInformasiToko(Request $request, $id)
{
    // Validasi data yang diterima
    $request->validate([
        'nama_laundry' => 'required|string|max:255',
        'alamat_laundry' => 'required|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'deskripsi' => 'required|string',
        'gambar_tempat' => 'nullable|image|mimes:jpg,jpeg,png,gif',
    ]);

    // Mencari data mitra berdasarkan ID
    $mitra = Mitra::findOrFail($id);

    // Update data informasi toko
    $mitra->update([
        'nama_laundry' => $request->nama_laundry,
        'alamat' => $request->alamat_laundry,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'deskripsi' => $request->deskripsi,
    ]);

    // Update foto tempat jika ada
    if ($request->hasFile('gambar_tempat')) {
        if ($mitra->foto_tempat) {
            Storage::delete($mitra->foto_tempat); // Hapus foto lama jika ada
        }
        $mitra->foto_tempat = $request->file('gambar_tempat')->store('foto_mitra'); // Upload foto baru
    }

    return redirect()->route('mitra.pengaturan', $mitra->id)
        ->with('success', 'Informasi Toko berhasil diperbarui.');
}

public function updateLaundryPaket(Request $request, $id)
{
    // Validate the data
    $request->validate([
        'kategori_layanan' => 'required|string|in:cuci,setrika,cuci & setrika',
        'paket_laundry' => 'required|exists:paket_pakaians,id',
    ]);

    // Find the mitra by ID
    $mitra = Mitra::findOrFail($id);

    // Update Jenis Laundry and Paket Pakaian
    $mitra->update([
        'kategori_layanan' => $request->kategori_layanan,
    ]);

    $paket = PaketPakaian::find($request->paket_laundry);
    if ($paket) {
        $mitra->paketPakaian()->sync([$paket->id]);
    }

    return redirect()->route('mitra.pengaturan', $mitra->id)
        ->with('success', 'Jenis Laundry & Paket Pakaian berhasil diperbarui.');
}


// public function updateJenisPakaian(Request $request, $id)
// {
//     // Validasi input
//     $request->validate([
//         'jenis_pakaian' => 'required|array',
//         'jenis_pakaian.*.id' => 'required|exists:jenis_pakaian,id',
//         'jenis_pakaian.*.price' => 'required|numeric|min:0',
//         'jenis_pakaian.*.paket_pakaian_id' => 'required|exists:paket_pakaians,id',
//     ]);

//     // Temukan mitra berdasarkan ID
//     $mitra = Mitra::findOrFail($id);

//     // Update atau create setiap record pivot
//     foreach ($request->jenis_pakaian as $item) {
//         $mitra->jenisPakaian()->syncWithoutDetaching([
//             $item['id'] => [
//                 'price' => $item['price'],
//                 'paket_pakaian_id' => $item['paket_pakaian_id']
//             ]
//         ]);
//     }

//     return redirect()->route('mitra.pengaturan', $mitra->id)
//         ->with('success', 'Harga Jenis Pakaian berhasil diperbarui.');
// }


public function updateJenisPakaian(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'jenis_pakaian' => 'required|array',
        'jenis_pakaian.*.id' => 'required|exists:jenis_pakaian,id',
        'jenis_pakaian.*.price' => 'required|numeric|min:0',
        'jenis_pakaian.*.paket_id' => 'required|exists:paket_pakaians,id',
    ]);

    $mitra = Mitra::findOrFail($id);

    // Persiapkan data untuk sync
    $jenisPakaianData = [];
    foreach ($request->jenis_pakaian as $item) {
        $jenisPakaianData[$item['id']] = [
            'price' => $item['price'],
            'paket_pakaian_id' => $item['paket_id']
        ];
    }

    // Gunakan sync tanpa menghapus relasi lain
    $mitra->jenisPakaian()->syncWithoutDetaching($jenisPakaianData);

    return redirect()->back()->with('success', 'Harga berhasil diperbarui!');
}

public function addBarang(Request $request, $mitraId)
{
    // Validasi data yang diterima
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
    ]);

    // Mencari mitra berdasarkan ID
    $mitra = Mitra::findOrFail($mitraId);

    // Membuat jenis pakaian baru
    $jenisPakaian = JenisPakaian::create([
        'nama' => $request->nama,
    ]);

    // Menambahkan jenis pakaian ke mitra tertentu dengan harga
    $mitra->jenisPakaian()->syncWithoutDetaching([
        $jenisPakaian->id => ['price' => $request->harga]
    ]);

    return redirect()->route('mitra.pengaturan', $mitra->id)
        ->with('success', 'Barang (Jenis Pakaian) berhasil ditambahkan.');
}

public function updateHargaJenisPakaian(Request $request, $mitraId)
{
    // Validasi input
    $request->validate([
        'paket_laundry' => 'required|exists:paket_pakaians,id', // Validasi paket pakaian yang dipilih
        'jenis_pakaian' => 'required|array', // Pastikan jenis pakaian disertakan
        'jenis_pakaian.*.price' => 'required|numeric|min:0', // Validasi harga setiap jenis pakaian
        'jenis_pakaian.*.id' => 'required|exists:jenis_pakaian,id', // Validasi ID jenis pakaian yang dipilih
    ]);

    // Cari mitra berdasarkan ID
    $mitra = Mitra::findOrFail($mitraId);

    // Ambil data paket pakaian yang dipilih
    $paket = PaketPakaian::find($request->paket_laundry);

    // Sync paket pakaian yang dipilih dengan mitra
    $mitra->paketPakaian()->sync([$paket->id]);

    // Update harga jenis pakaian pada pivot table 'paket_jenis_pakaian'
    foreach ($request->jenis_pakaian as $jenis) {
        // Perbarui harga pada pivot tabel
        $mitra->paketPakaian()
            ->wherePivot('paket_pakaian_id', $paket->id)  // Menyaring paket yang dipilih
            ->wherePivot('jenis_pakaian_id', $jenis['id']) // Menyaring jenis pakaian yang dipilih
            ->updateExistingPivot($jenis['id'], ['price' => $jenis['price']]);
    }

    return redirect()->route('mitra.dashboard')->with('success', 'Produk berhasil diperbarui');
}


// Controller Method
public function getJenisPakaianByPaket($mitraId, $paketId)
{
    // Temukan mitra berdasarkan ID
    $mitra = Mitra::with(['paketPakaian.jenisPakaian'])->findOrFail($mitraId);
    
    // Cari paket berdasarkan ID dan ambil jenis pakaian yang terkait
    $paket = PaketPakaian::with('jenisPakaian')->findOrFail($paketId);

    // Kembalikan daftar jenis pakaian dalam bentuk HTML untuk dimasukkan ke halaman
    $output = '';
    foreach ($paket->jenisPakaian as $jenis) {
        $output .= '<div class="flex items-center space-x-3" id="jenis-pakaian-' . $jenis->id . '">
                        <input type="hidden" name="jenis_pakaian[' . $jenis->id . '][id]" value="' . $jenis->id . '">
                        <input type="text" value="' . $jenis->nama . '" class="flex-1 p-3 border border-gray-300 rounded-lg" readonly>
                        <input type="number" name="jenis_pakaian[' . $jenis->id . '][price]" value="' . $jenis->pivot->price . '" class="w-32 p-3 border border-gray-300 rounded-lg">
                    </div>';
    }

    return response()->json(['output' => $output]);
}


}

