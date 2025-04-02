<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('emails.contact');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'Name' => 'required|string|max:255',
        'Email' => 'required|email|max:255',
        'Phone' => 'nullable|string|max:20',
        'message' => 'required|string',
    ]);

    try {
        $data = [
            'name' => $validated['Name'],
            'email' => $validated['Email'],
            'phone' => $validated['Phone'] ?? null,
            'message' => $validated['message']
        ];

        Mail::send('emails.contact', $data, function($message) use ($data) {
            $message->to('rajsee200478@gmail.com')
                    ->subject('Pesan Baru dari Kontak')
                    ->replyTo($data['email']);
        });

        return redirect()->route('contact.index')
               ->with('success', 'Pesan berhasil dikirim!');

    } catch (\Exception $e) {
        Log::error('Email error: '.$e->getMessage());
        return back()->withInput()->with('error', 'Gagal mengirim pesan. Silakan coba lagi.');
    }
}
}