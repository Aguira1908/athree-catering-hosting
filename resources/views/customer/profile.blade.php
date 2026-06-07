@extends('layouts.main')

@section('title', 'Profil Saya - ATHREE Catering')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Profil Saya</h1>
            <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informasi Profil -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-user-circle text-[#c4a77d] mr-2"></i>
                        Informasi Akun
                    </h2>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $customer->nama }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ $customer->email }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100"
                                readonly disabled>
                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">No. HP</label>
                            <input type="tel" name="no_hp" value="{{ $customer->no_hp ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">{{ $customer->alamat ?? '' }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Password Baru (kosongkan jika tidak diubah)</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        </div>

                        <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-semibold">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-[#c4a77d] rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                            {{ substr($customer->nama, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-lg">{{ $customer->nama }}</h3>
                        <p class="text-gray-500 text-sm">{{ $customer->email }}</p>
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-calendar-alt mr-2 text-[#c4a77d]"></i>
                                Bergabung: {{ \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
