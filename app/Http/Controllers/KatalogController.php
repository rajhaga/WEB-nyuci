<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\PaketPakaian;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\PesananItem;
use App\Models\JenisPakaian;
use App\Models\MitraJenisPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class KatalogController extends Controller
{

    public function showKatalogDetail(Mitra $mitra)
{
    // Cek status mitra
    if ($mitra->user->status !== 'verified') {
        return redirect()->route('catalog')->with('error', 'Mitra not verified.');
    }

    // Load data dengan relasi yang diperlukan
    $mitra->load([
        'jenisPakaian' => function($query) {
            $query->withPivot('price', 'paket_pakaian_id');
        },
        'paketPakaian',
        'ulasan.user'
    ]);

    return view('katalog.detail', [
        'mitra' => $mitra,
        'jenisPakaianList' => $mitra->jenisPakaian,
        'ulasan' => $mitra->ulasan
    ]);
}

public function storeAndCheckout(Request $request, Mitra $mitra)
{
    // Validate the quantities
    $validated = $request->validate([
        'quantities' => 'required|array',
        'quantities.*' => 'required|array',
        'quantities.*.*' => 'required|integer|min:0',
    ]);


    $items = [];
    $totalCost = 0;

    // Loop through the quantities and calculate the total cost for each item
    foreach ($request->quantities as $paketId => $quantities) {
        $paket = PaketPakaian::find($paketId);
        if (!$paket) continue;

        foreach ($quantities as $jenisId => $quantity) {
            if ($quantity <= 0) continue;

            // Fetch the 'JenisPakaian' name and price from the request data
            $jenis = $request->items[$jenisId] ?? null;
            if (!$jenis) continue;

            // Get the name of the item based on the jenis_pakaian_id
            $jenisPakaianName = JenisPakaian::find($jenisId)->nama;

            // Directly use the price from the request data (instead of pivot)
            $price = $jenis['price']; // Get price from the request

            // Calculate the cost for the item, using the price from the request data
            $cost = $price * $quantity;  // Multiply price by quantity
            $totalCost += $cost;  // Add to the total cost

            // Store the item data, including the calculated cost
            $items[] = [
                'jenis' => $jenisPakaianName,  // Store the name of the item, not the ID
                'quantity' => $quantity,
                'cost' => $cost,  // Store the calculated cost
            ];
        }
    }


    // Store the items and the total cost in session
    session(['checkout_items' => $items, 'total_cost' => $totalCost]);


    // Return to the checkout summary view
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

    // Add admin fee to the total cost (Rp8.000)
    $adminFee = 8000;
    $totalCost += $adminFee;

    if (empty($items)) {
        return back()->withErrors(['error' => 'Keranjang belanja kosong.']);
    }

    // Simpan pesanan utama
    $pesanan = new Pesanan();
    $pesanan->pembeli_id = auth()->id();
    $pesanan->mitra_id = $mitra->id;
    $pesanan->total_harga = $totalCost;  // Use the updated total cost
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
