<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use PDF;  // Mengimpor facade PDF

class InvoiceController extends Controller
{
    public function downloadInvoice($id)
    {
        // Ambil data pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($id);

        // Persiapkan data untuk view invoice
        $data = [
            'pesanan' => $pesanan,
            // Anda bisa menambahkan data lain yang diperlukan
        ];

        // Membuat PDF dari view invoice
        $pdf = PDF::loadView('invoices.invoice', $data);

        // Mengunduh PDF dengan nama file invoice
        return $pdf->download('invoice-' . $pesanan->id . '.pdf');
    }
}
