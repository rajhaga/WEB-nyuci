<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        // Get the status from the query parameter, default to null (show all orders)
        $status = $request->get('status');

        // If a specific status is provided, filter by that status; otherwise, get all orders
        if ($status) {
            // Get orders with the selected status
            $pesanan = Pesanan::with(['mitra', 'pesananItems.jenisPakaian'])
                ->where('status', $status)
                ->get();
        } else {
            // Get all orders
            $pesanan = Pesanan::with(['mitra', 'pesananItems.jenisPakaian'])->get();
        }

        return view('pesanan.index', compact('pesanan'));
    }
}
