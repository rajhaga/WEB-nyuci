<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        // Dapatkan ID pengguna yang sedang login
        $userId = Auth::id();
    
        // Ambil pesanan sesuai dengan pengguna yang login
        $query = Pesanan::where('pembeli_id', $userId);
    
        // Filter berdasarkan status jika ada parameter status di request
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
    
        // Ambil semua pesanan sesuai filter
        $pesanan = $query->get();
    
        return view('', compact('pesanan'));
    }
    
}

// namespace App\Http\Controllers;

// use App\Models\Pesanan;
// use Illuminate\Http\Request;

// class TrackController extends Controller
// {
//     // Show the Track Order Page (Step 1)
//     public function index()
//     {
//         return view('track.index'); // Display the form to input Kode Referral
//     }

//     // Track Order based on Kode Referral (Step 2)
//     public function trackOrder(Request $request)
//     {
//         // Validate the Kode Referral input
//         $validated = $request->validate([
//             'kode_referral' => 'required|string',
//         ]);

//         // Search for the pesanan using the provided Kode Referral
//         $pesanan = Pesanan::where('kode_referral', $validated['kode_referral'])->first();

//         // If no pesanan found, show an error message
//         if (!$pesanan) {
//             return redirect()->route('track.index')->with('error', 'Kode Referral tidak ditemukan!');
//         }

//         // Show the tracking page with the pesanan details
//         return view('track.track', compact('pesanan'));
//     }
// }
