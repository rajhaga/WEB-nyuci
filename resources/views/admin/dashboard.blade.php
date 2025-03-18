@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
    
    <a href="{{ url('/') }}" class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        <i class="fas fa-arrow-left mr-2"></i> Back
    </a>

    <h3 class="text-xl font-semibold mt-6">Daftar Pengguna Pending</h3>

    @if($users->isEmpty())
        <div class="bg-blue-100 text-blue-700 p-4 rounded-md mt-4">Tidak ada pengguna yang sedang menunggu verifikasi.</div>
    @else
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-gray-50 hover:bg-gray-100 transition">
                            <td class="border border-gray-300 px-4 py-2">{{ $user->nama }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->status }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                @if ($user->status === 'pending' && $user->role !== 'admin')
                                    <a href="{{ route('admin.approve', $user->id) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition text-sm">Approve</a>
                                    <a href="{{ route('admin.reject', $user->id) }}" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">Reject</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
