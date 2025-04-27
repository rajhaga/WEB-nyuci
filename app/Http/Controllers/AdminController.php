<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra; // Model untuk mitra
use App\Models\User;  // Model untuk user
use App\Models\Pesanan;  // Model untuk user
use App\Models\Contact;  // Model untuk user
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Admin;



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

    public function dashboard()
    {
        // 1. Total Saldo Admin (semua pendapatan di tabel admins)
        $totalSaldo = Admin::sum('pendapatan');

        // 2. Total Mitra Terdaftar
        $totalMitra = Mitra::count();

        // 3. Mitra Pending Verifikasi
        $pendingMitra = Mitra::whereHas('user', fn($q) =>
            $q->where('role','mitra')->where('status','pending')
        )->count();

        // 4. Total Pelanggan
        $totalPelanggan = User::where('role','pembeli')->count();

        // 5. Pertumbuhan Pelanggan Baru 12 bulan
        $customerGrowth = User::where('role','pembeli')
            ->select([
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month"),
                DB::raw("COUNT(*) as total")
            ])
            ->where('created_at','>=', Carbon::now()->subYear())
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('total','month');

        $customerGrowthLabels = $customerGrowth->keys();
        $customerGrowthData   = $customerGrowth->values();

        // 6. Metrik Digital: pesanan harian 7 hari terakhir
        $digitalMetrics = Pesanan::select([
                DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date"),
                DB::raw("COUNT(*) as total")
            ])
            ->where('created_at','>=', Carbon::now()->subDays(7))
            ->groupBy('date')->orderBy('date')
            ->get()->pluck('total','date');

        $digitalMetricsLabels = $digitalMetrics->keys();
        $digitalMetricsData   = $digitalMetrics->values();

       
        return view('admin.dashboard', compact(
            'totalSaldo',
            'totalMitra',
            'pendingMitra',
            'totalPelanggan',
            'customerGrowthLabels',
            'customerGrowthData',
            'digitalMetricsLabels',
            'digitalMetricsData'
        ));
    }
    
    
    public function verifyMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_registration_mitra = 'approved';
        $mitra->save();
        
        return redirect()->back()->with('success', 'Mitra berhasil diverifikasi');
    }
    
    public function manageCustomers()
    {
        $customers = User::where('role', 'customer')->paginate(10);
        return view('admin.customers', compact('customers'));
    }
    

    public function hubungiKami()
    {
        // Fetch all contact submissions from the 'contacts' table
        $contacts = Contact::orderBy('created_at', 'desc')->get();

        // Pass the contacts data to the view
        return view('admin.hubungi-kami', compact('contacts'));
    }

    public function kelolaPelanggan()
    {
        // Fetch all customers (role = 'pembeli') and filter by the last updated date
        $pelanggan = User::where('role', 'pembeli')
                         ->get()
                         ->map(function($user) {
                             // Check if the user was last updated over a year ago
                             $user->showDeleteButton = $user->updated_at->lt(now()->subYear());
                             return $user;
                         });

        return view('admin.kelola-pelanggan', compact('pelanggan'));
    }
    public function deletePelanggan($id)
    {
        $pelanggan = User::findOrFail($id);
        
        // Delete the user
        $pelanggan->delete();
    
        return redirect()->route('admin.kelolaPelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }
    
    public function verifikasiMitra()
{
    $mitraList = Mitra::with([
            'user:id,nama,email,phone,photo,status'  // pilih kolom user yang kamu butuhkan
        ])
        ->whereHas('user', function($q) {
            $q->where('status', 'pending');
        })
        ->get();
    return view('admin.verifikasi-mitra', compact('mitraList'));
}


    public function show($id)
    {
        $mitra = Mitra::with(['user','paketPakaian','paketPakaian.jenisPakaian'])
                      ->findOrFail($id);

        return view('admin.verifikasi-mitra-detail', compact('mitra'));
    }
    
    
    public function verify($id)
    {
        $mitra = Mitra::findOrFail($id);

        // Example verification logic: change the status to 'verified'
        if ($mitra->status != 'verified') {
            $mitra->status = 'verified'; // Update status
            $mitra->save();

            return redirect()->route('admin.verifikasiMitraDetail', $mitra->id)
                ->with('success', 'Mitra successfully verified');
        }

        return redirect()->route('admin.verifikasiMitraDetail', $mitra->id)
            ->with('error', 'Mitra is already verified');
    }

    public function deleteMitra($id)
{
    // Find the mitra by id
    $mitra = Mitra::findOrFail($id);
    
    // Find the associated user of this mitra
    $user = $mitra->user;

    // Update the user's status to 'Ditolak' (Rejected)
    $user->status = 'Ditolak';
    $user->save();

    // Delete the mitra record
    $mitra->delete();

    // Redirect with a success message
    return redirect()->route('admin.verifikasiMitra')
        ->with('success', 'Mitra has been rejected, and the user status has been updated to Ditolak. The Mitra record has been deleted.');
}
}
