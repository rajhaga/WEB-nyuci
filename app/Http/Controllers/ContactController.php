<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // Menampilkan FORM ke user
    public function index()
    {
        return view('emails.contact'); // resources/views/contact.blade.php
    }

    // Mengirim EMAIL dan menyimpan ke DATABASE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'Phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            // Data untuk email
            $data = [
                'name' => $validated['Name'],
                'email' => $validated['Email'],
                'phone' => $validated['Phone'] ?? 'Tidak dicantumkan',
                'messageContent' => $validated['message'] // Hindari nama 'message'
            ];

            // Simpan data kontak ke database
            Contact::create([
                'name' => $validated['Name'],
                'email' => $validated['Email'],
                'phone' => $validated['Phone'] ?? null,
                'message' => $validated['message']
            ]);

            // Menggunakan template EMAIL: resources/views/emails/contact-form.blade.php
            Mail::send('emails.contact-form', $data, function($message) use ($data) {
                $message->to('rajsee200478@gmail.com')
                        ->subject('Pesan Baru dari Website')
                        ->replyTo($data['email']);
            });

            // Redirect dengan pesan sukses
            return redirect()->route('contact.index')
                   ->with('success', 'Pesan berhasil dikirim dan disimpan!');

        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            Log::error('Email error: '.$e->getMessage());
            return back()->withInput()
                         ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
