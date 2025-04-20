<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra; // Model untuk mitra
use App\Models\User;  // Model untuk user
use App\Models\Pesanan;  // Model untuk user
use App\Models\Contact;  // Model untuk user


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
        // Get statistics for the dashboard
        $totalSaldo = Pesanan::where('status', 'completed')->sum('total_harga');
        $totalMitra = user::count();
        $pendingMitra = user::where('status', 'pending')->count();
        $totalPelanggan = User::where('role', 'pembeli')->count();
        
        // Get customer growth data (last 8 months)
        $customerGrowth = $this->getCustomerGrowthData();
        
        // Get digital metrics data
        $digitalMetrics = $this->getDigitalMetricsData();
        
        return view('admin.dashboard', compact(
            'totalSaldo',
            'totalMitra',
            'pendingMitra',
            'totalPelanggan',
            'customerGrowth',
            'digitalMetrics'
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
    
    private function getCustomerGrowthData()
    {
        // This would typically come from your database
        // For now, we'll use the sample data from your image
        return [
            'current' => 0.1900,
            'previous' => [
                0.1700, 0.1500, 0.1300, 0.1100, 0.0900, 0.0700, 0.0500
            ]
        ];
    }
    
    private function getDigitalMetricsData()
    {
        // This would typically come from your database
        // For now, we'll use the sample data from your image
        return [
            'current' => 0.1679,
            'trend' => [
                0.1532, 0.1405, 0.1244, 0.1121, 0.1143, 0.1166, 0.1178,
                0.1187, 0.1196, 0.1209, 0.1227, 0.1230, 0.1244, 0.1257,
                // ... and so on with the rest of your data
            ]
        ];
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
        // Get all mitra that need to be verified
        $mitraList = user::where('status', 'pending')->get();

        return view('admin.verifikasi-mitra', compact('mitraList'));
    }

    public function verifikasiMitraDetail($id)
    {
        // Fetch a specific mitra and its details
        $mitra = Mitra::findOrFail($id);

        // Pass mitra to the detail view
        return view('admin.verifikasi-mitra-detail', compact('mitra'));
    }
    public function updateVerifikasiMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->status_registration_mitra = 'verified'; // Update the status to 'verified'
        $mitra->save();

        return redirect()->route('admin.verifikasiMitra')->with('success', 'Mitra berhasil diverifikasi');
    }

}
