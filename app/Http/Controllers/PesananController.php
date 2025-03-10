<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['mitra', 'pesananItems.jenisPakaian'])->get();
        return view('pesanan.index', compact('pesanan'));
    }
}
