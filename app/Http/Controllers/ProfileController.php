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
        // Jika pengguna memiliki mitra dan statusnya adalah pending, tampilkan mitra tersebut
        if ($mitra && $user->status === 'pending') {
            // Tampilkan data mitra
            return view('profile', compact('user', 'mitra','jenisPakaian'));
        }
        return view('profile', compact('user', 'mitra','jenisPakaian'));

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
        $currentStatus = request('status');

        if (!$user) {
            return redirect()->route('login');
        }

        $pesanans = Pesanan::where('pembeli_id', $user->id)
            ->when($currentStatus, fn($q) => $q->where('status', $currentStatus))
            ->with(['pesananItems.jenisPakaian', 'mitra'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order_history', compact('pesanans', 'currentStatus'));
    }

    

public function donehistroryprofile()
{
    $user = Auth::user();
    
    // Flag to check if the current page is "Riwayat Pesanan"
    $isProfilePage = false;  // For example, false because this is Riwayat Pesanan page

    $pesanans = Pesanan::where('pembeli_id', $user->id)
                       ->where('status', 'Selesai')  // Only 'Selesai' status
                       ->with('items')
                       ->get();

    return view('profile_history', compact('pesanans', 'isProfilePage'));

}
}
