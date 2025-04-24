@extends('layouts.app')

@section('title', 'Nyuci - Hubungi Kami')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Form Section -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="mb-6 text-center">
                <h2 class="text-3xl font-bold text-gray-800">Hubungi Kami</h2>
                <p class="text-gray-500 mt-1">Kami siap membantu Anda kapan saja</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="Name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="Name" name="Name" value="{{ old('Name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        @error('Name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="Email" name="Email" value="{{ old('Email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        @error('Email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" id="Phone" name="Phone" value="{{ old('Phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            Kirim Pesan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Image Section -->
        <div class="flex justify-center">
            <img src="{{ asset('images\hubungikami\image.png') }}" alt="Customer Service Illustration"
                class="max-w-full h-auto rounded-md shadow-md">
        </div>
    </div>
</div>
@endsection
