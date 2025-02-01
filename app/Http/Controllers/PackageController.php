<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    // Menampilkan semua data paket
    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }

    // Menyimpan data lokasi paket
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string',
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'destination_latitude' => 'required',
            'destination_longitude' => 'required',
        ]);

        Package::create($request->all());
        return redirect('/packages')->with('success', 'Package added successfully!');
    }
}
