<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\Pesanan;

class RekomendasiController extends Controller
{
    public function getRekomendasi(Request $request)
    {
        $user = Auth::user();
        $rekomendasi = collect(); // Default kosong
        $kategoriFavorit = null;
    
        // Cek apakah ada user yang login
        if ($user) {
            // Cari kategori pakaian favorit user (yang paling banyak dipesan)
            $kategoriFavorit = DB::table('pesanan_item as pi')
                ->join('jenis_pakaian as jp', 'pi.item_id', '=', 'jp.id')
                ->join('pesanan as p', 'pi.pesanan_id', '=', 'p.id')
                ->select('pi.item_id', 'jp.nama', DB::raw('COUNT(*) as total_dipesan'))
                ->where('p.pembeli_id', $user->id)
                ->groupBy('pi.item_id', 'jp.nama')
                ->orderByDesc('total_dipesan')
                ->limit(1)
                ->first();
    
            if ($kategoriFavorit) {
                // Cari mitra yang menyediakan kategori pakaian favorit dengan status selain 'pending'
                $rekomendasi = Mitra::join('pengguna as u', 'm.user_id', '=', 'u.id')
                    ->join('mitra_paket_pakaian as mp', 'm.id', '=', 'mp.mitra_id')
                    ->join('paket_jenis_pakaian as pjp', 'mp.paket_pakaian_id', '=', 'pjp.paket_pakaian_id')
                    ->where('pjp.jenis_pakaian_id', $kategoriFavorit->item_id)
                    ->where('u.status', '!=', 'pending') // Mengecualikan mitra dengan status 'pending'
                    ->orderByDesc('m.rating')
                    ->limit(5)
                    ->get(['m.id', 'm.nama_pemilik', 'm.nama_laundry', 'm.foto_tempat', 'm.rating']);
            }
        }
    
        return view('home', compact('rekomendasi', 'kategoriFavorit'));
    }
        


    public function rekomendasiLaundry(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',   // Latitude pengguna
            'lng' => 'required|numeric',   // Longitude pengguna
            'radius' => 'sometimes|numeric|min:1|max:50' // Radius pencarian (dalam km), default 50
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius ?? 50; // Defaultkan radius 50 km jika tidak diberikan

        // Query untuk mengambil laundries dalam radius tertentu
        $laundries = Mitra::selectRaw(
            "mitras.id, mitras.nama_laundry, mitras.alamat, mitras.foto_tempat, mitras.harga, mitras.rating, mitras.latitude, mitras.longitude, 
            ( 6371 * acos( cos( radians(?) ) * 
            cos( radians( mitras.latitude ) ) * 
            cos( radians( mitras.longitude ) - radians(?) ) + 
            sin( radians(?) ) * 
            sin( radians( mitras.latitude ) ) ) ) AS distance",
            [$lat, $lng, $lat]
        )
        ->join('pengguna as u', 'mitras.user_id', '=', 'u.id')  // Bergabung dengan tabel pengguna untuk status
        ->where('u.status', 'verified')  // Pastikan hanya mitra dengan status verified
        ->having('distance', '<', $radius)  // Filter berdasarkan radius
        ->orderBy('distance')  // Urutkan berdasarkan jarak terdekat
        ->get();

        // Mapping untuk menampilkan hasil
        $laundries = $laundries->map(function ($laundry) {
            return [
                'id' => $laundry->id,
                'nama_laundry' => $laundry->nama_laundry,
                'alamat' => $laundry->alamat,
                'foto_tempat' => $laundry->foto_tempat,
                'harga' => $laundry->harga,
                'rating' => $laundry->rating,
                'latitude' => $laundry->latitude,
                'longitude' => $laundry->longitude,
                'distance' => round($laundry->distance, 2) . ' km',
            ];
        });

        // dd($laundries); // Uncomment if needed to debug

        // Return the formatted data as JSON
        return response()->json([
            'success' => true,
            'data' => $laundries,
            'current_location' => [
                'lat' => $lat,
                'lng' => $lng
            ]
        ]);
    }

}
