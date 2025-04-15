<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\Pesanan;

class RekomendasiController extends Controller
{
    public function getRekomendasi()
    {
        $user = Auth::user();

        // Default rekomendasi jika user belum login
        $rekomendasi = DB::table('mitras')
            ->orderByDesc('rating')
            ->limit(5)
            ->get();
        
        $kategoriFavorit = null;

        if ($user) {
            // Cari kategori pakaian favorit user berdasarkan pesanan
            $kategoriFavorit = DB::table('pesanan_item as pi')
                ->join('jenis_pakaian as jp', 'pi.item_id', '=', 'jp.id')
                ->join('pesanan as p', 'pi.pesanan_id', '=', 'p.id')
                ->select('pi.item_id', 'jp.nama', DB::raw('COUNT(*) as total_dipesan'))
                ->where('p.pembeli_id', $user->id)
                ->groupBy('pi.item_id', 'jp.nama')
                ->orderByDesc('total_dipesan')
                ->limit(1)
                ->first();

            // Jika ada kategori favorit, ambil mitra yang menyediakan layanan tersebut
            if ($kategoriFavorit) {
                // $rekomendasi = DB::table('mitras as m')
                //     ->join('mitra_paket_pakaian as mp', 'm.id', '=', 'mp.mitra_id')
                //     ->join('paket_jenis_pakaian as pjp', 'mp.paket_pakaian_id', '=', 'pjp.paket_pakaian_id')
                //     ->where('pjp.jenis_pakaian_id', $kategoriFavorit->item_id)
                //     ->orderByDesc('m.rating')
                //     ->limit(5)
                //     ->get(['m.id', 'm.nama_pemilik','m.nama_laundry' ,'m.foto_tempat', 'm.rating']);

                $rekomendasi = DB::table('mitras as m')
                    ->join('mitra_paket_pakaian as mp', 'm.id', '=', 'mp.mitra_id')
                    ->join('paket_jenis_pakaian as pjp', 'mp.paket_pakaian_id', '=', 'pjp.paket_pakaian_id')
                    ->where('pjp.jenis_pakaian_id', $kategoriFavorit->item_id)
                    ->orderByDesc('m.rating')
                    ->limit(5)
                    ->get(['m.id', 'm.nama_pemilik', 'm.nama_laundry', 'm.foto_tempat', 'm.rating']);

            }
        }
        // Pastikan data dikirim ke view
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
        "id, nama_laundry, alamat, foto_tempat, harga, rating, latitude, longitude, 
        ( 6371 * acos( cos( radians(?) ) * 
          cos( radians( latitude ) ) * 
          cos( radians( longitude ) - radians(?) ) + 
          sin( radians(?) ) * 
          sin( radians( latitude ) ) ) ) AS distance",
        [$lat, $lng, $lat]
    )
    ->having('distance', '<', $radius)  // Filter berdasarkan radius
    ->orderBy('distance')  // Urutkan berdasarkan jarak terdekat
    ->get();

    // Format data to only show necessary attributes
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
