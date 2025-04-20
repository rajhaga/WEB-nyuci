@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-semibold">Kelola Pelanggan</h1>

    <!-- Customer List -->
    <div class="mt-6">
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Nama Pelanggan</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Nomor Telepon</th>
                    <th class="px-4 py-2 text-left">Terakhir Diperbarui</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $p->nama }}</td> <!-- Display customer's name -->
                        <td class="px-4 py-2">{{ $p->email }}</td> <!-- Display email -->
                        <td class="px-4 py-2">{{ $p->phone ?? 'Tidak dicantumkan' }}</td> <!-- Display phone number -->
                        <td class="px-4 py-2">{{ $p->updated_at->format('d-m-Y') }}</td> <!-- Display last updated date -->
                        <td class="px-4 py-2">
                            <!-- Show delete button only if the user hasn't been updated in a year -->
                            @if($p->showDeleteButton)
                                <form action="{{ route('admin.deletePelanggan', $p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">Tidak dapat dihapus</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
