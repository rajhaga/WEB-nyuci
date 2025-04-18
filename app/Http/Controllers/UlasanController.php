<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function showReviewForm(Pesanan $pesanan)
    {
        // Ensure that the user is authorized to review this order
        if ($pesanan->status !== 'Selesai') {
            return redirect()->route('home')->with('error', 'Pesanan belum selesai.');
        }

        // Pass the pesanan to the view
        return view('mitra.ulasan', compact('pesanan'));
    }

    public function storeReview(Request $request, Pesanan $pesanan)
{
    // Validate the input
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string|max:255',
    ]);

    // Store the ulasan in the database
    Ulasan::create([
        'pesanan_id' => $pesanan->id,
        'user_id' => Auth::id(),
        'mitra_id' => $pesanan->mitra_id,
        'rating' => $validated['rating'],
        'komentar' => $validated['komentar'],
    ]);

    // Update the Mitra's average rating
    $mitra = Mitra::find($pesanan->mitra_id);

    // Calculate the new average rating for the mitra
    $averageRating = Ulasan::where('mitra_id', $mitra->id)
                           ->avg('rating'); // Calculates the average rating

    // Update the mitra's rating
    $mitra->update(['rating' => round($averageRating, 2)]);

    return redirect()->route('home')->with('success', 'Ulasan berhasil dikirim');
}


    public function showReport()
    {
        // Get the current logged-in mitra
        $mitra = Mitra::where('user_id', Auth::id())->first();

        // Fetch all reviews for this mitra
        $ulasan = Ulasan::where('mitra_id', $mitra->id)->with('user')->get();

        return view('mitra.reports', compact('ulasan'));
    }
}
