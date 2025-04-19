@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-semibold">Hubungi Kami</h1>

    <!-- Table to display Contact Submissions -->
    <div class="mt-6">
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Nama Pengirim</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Nomor Telepon</th>
                    <th class="px-4 py-2 text-left">Pesan</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $contact->name }}</td> <!-- Display name -->
                        <td class="px-4 py-2">{{ $contact->email }}</td> <!-- Display email -->
                        <td class="px-4 py-2">{{ $contact->phone ?? 'Tidak dicantumkan' }}</td> <!-- Display phone number -->
                        <td class="px-4 py-2">{{ $contact->message }}</td> <!-- Display message -->
                        <td class="px-4 py-2">{{ $contact->created_at->format('d-m-Y') }}</td> <!-- Display submission date -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
