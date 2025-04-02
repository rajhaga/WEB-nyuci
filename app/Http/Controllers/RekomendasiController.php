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
}
