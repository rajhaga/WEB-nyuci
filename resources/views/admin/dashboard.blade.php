@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>
    
    <a href="{{ url('/') }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <h3>Daftar Pengguna Pending</h3>

    @if($users->isEmpty())
        <div class="alert alert-info">Tidak ada pengguna yang sedang menunggu verifikasi.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nama }}</td> <!-- Ganti dengan nama kolom yang benar, misal 'name' -->
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                @if ($user->status === 'pending' && $user->role !== 'admin')  <!-- Tambahkan kondisi untuk memeriksa peran -->
                                    <a href="{{ route('admin.approve', $user->id) }}" class="btn btn-success btn-sm">Approve</a>
                                    <a href="{{ route('admin.reject', $user->id) }}" class="btn btn-danger btn-sm">Reject</a>
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
