<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\PaketPakaian;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\PesananItem;
use App\Models\JenisPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class KatalogController extends Controller
{
    // Step 1: Display the catalog of laundries
    public function index()
    {
        $mitras = Mitra::all(); // Fetch all laundry services (partners)
        return view('katalog.index', compact('mitras'));
    }

    // Show the details for a specific mitra including reviews
    public function showKatalogDetail(Mitra $mitra)
    {
        // Fetch reviews related to the specific mitra
        $ulasan = Ulasan::where('mitra_id', $mitra->id)->with('user')->get();

        // Pass mitra and ulasan to the view
        return view('katalog.detail', compact('mitra', 'ulasan'));
    }

    // Step 3: Store order data and redirect to checkout page
    public function storeAndCheckout(Request $request, Mitra $mitra)
    {
        $validated = $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|array',
            'quantities.*.*' => 'required|integer|min:0',
        ]);

        $items = [];
        $totalCost = 0;

        foreach ($request->quantities as $paketId => $quantities) {
            $paket = PaketPakaian::find($paketId);
            if (!$paket) continue;

            foreach ($quantities as $jenisId => $quantity) {
                if ($quantity <= 0) continue;

                $jenis = $paket->jenisPakaian()->find($jenisId);
                if (!$jenis) continue;

                $cost = $jenis->pivot->price * $quantity;
                $totalCost += $cost;

                $items[] = [
                    'jenis' => $jenis->nama,
                    'quantity' => $quantity,
                    'cost' => $cost
                ];
            }
        }

        session(['checkout_items' => $items, 'total_cost' => $totalCost]);
        return view('katalog.order_summary', compact('mitra', 'items', 'totalCost'));
    }
    
    public function placeOrder(Request $request, Mitra $mitra)
    {
        // Validasi input metode pembayaran
        $validated = $request->validate([
            'payment_method' => 'required|in:qris,cod',
        ]);

        // Ambil data pesanan dari session
        $items = session('checkout_items', []);
        $totalCost = session('total_cost', 0);

        if (empty($items)) {
            return back()->withErrors(['error' => 'Keranjang belanja kosong.']);
        }

        // Simpan pesanan utama
        $pesanan = new Pesanan();
        $pesanan->pembeli_id = auth()->id();
        $pesanan->mitra_id = $mitra->id;
        $pesanan->total_harga = $totalCost;
        $pesanan->status = 'Menunggu';
        $pesanan->kode_referral = 'REF-' . strtoupper(Str::random(6));
        $pesanan->metode_pembayaran = $validated['payment_method']; // Tambahkan metode pembayaran
        $pesanan->save();

        // Simpan setiap item dalam pesanan
        foreach ($items as $item) {
            $jenisPakaian = JenisPakaian::where('nama', $item['jenis'])->first();

            if (!$jenisPakaian) {
                return back()->withErrors(['error' => "Jenis pakaian '{$item['jenis']}' tidak ditemukan."]);
            }

            // Simpan item pesanan
            PesananItem::create([
                'pesanan_id' => $pesanan->id,
                'item_id' => $jenisPakaian->id,
                'jumlah' => $item['quantity'],
            ]);
        }

        // Hapus session setelah pesanan berhasil disimpan
        session()->forget(['checkout_items', 'total_cost']);
        $orderCount = Pesanan::where('pembeli_id', auth()->id())->count();

        // Redirect ke halaman konfirmasi pesanan dengan jumlah pesanan
        return redirect()->route('katalog.orderConfirmation', $pesanan->id)
            ->with('orderCount', $orderCount)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
    

    // Step 5: Order confirmation
    public function orderConfirmation(Pesanan $pesanan)
{
    // Hitung jumlah pesanan yang telah dilakukan oleh pengguna
    $orderCount = Pesanan::where('pembeli_id', $pesanan->pembeli_id)->count();

    return view('katalog.orderConfirmation', compact('pesanan', 'orderCount'));
}

}
