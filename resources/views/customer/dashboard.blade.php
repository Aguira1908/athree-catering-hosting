@extends('layouts.main')

@section('title', 'Dashboard Customer - ATHREE Catering')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Dashboard Customer</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profil Customer -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-[#c4a77d] rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr(Auth::guard('customer')->user()->nama ?? 'C', 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">{{ Auth::guard('customer')->user()->nama ?? 'Customer' }}</h2>
                        <p class="text-gray-500">{{ Auth::guard('customer')->user()->email ?? '' }}</p>
                    </div>
                </div>
                <div class="border-t pt-4 space-y-2">
                    <p><i class="fas fa-phone w-6 text-gray-400"></i> {{ Auth::guard('customer')->user()->no_hp ?? '-' }}</p>
                    <p><i class="fas fa-map-marker-alt w-6 text-gray-400"></i> {{ Auth::guard('customer')->user()->alamat ?? '-' }}</p>
                    <p><i class="fas fa-calendar-alt w-6 text-gray-400"></i> Member sejak {{ Auth::guard('customer')->user()->created_at ? \Carbon\Carbon::parse(Auth::guard('customer')->user()->created_at)->format('d/m/Y') : '-' }}</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('profile') }}" class="text-[#c4a77d] hover:text-[#a88b62] text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit Profil
                    </a>
                </div>
            </div>

            <!-- Statistik Pesanan -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-lg mb-4">Statistik Pesanan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Total Pesanan</span>
                        <span class="font-bold text-xl text-[#c4a77d]">{{ $totalOrders ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Pesanan Diproses</span>
                        <span class="font-bold text-blue-600">{{ $processingOrders ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b">
                        <span class="text-gray-600">Pesanan Dikirim</span>
                        <span class="font-bold text-purple-600">{{ $shippedOrders ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pesanan Selesai</span>
                        <span class="font-bold text-green-600">{{ $completedOrders ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Informasi -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-lg mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    <p class="text-gray-600">
                        <i class="fas fa-info-circle text-[#c4a77d] mr-2"></i>
                        Status pesanan akan diupdate oleh admin.
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-truck text-[#c4a77d] mr-2"></i>
                        Anda bisa melacak pesanan di riwayat pesanan.
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-credit-card text-[#c4a77d] mr-2"></i>
                        Pembayaran bisa dilakukan via transfer bank.
                    </p>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="bg-white rounded-xl shadow p-6 mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Riwayat Pesanan Saya</h2>
                <a href="{{ route('menu.index') }}" class="text-[#c4a77d] hover:text-[#a88b62] text-sm">
                    <i class="fas fa-plus mr-1"></i> Buat Pesanan Baru
                </a>
            </div>

            @if(isset($orders) && count($orders) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-3 px-4">ID Pesanan</th>
                                <th class="text-left py-3 px-4">Tanggal</th>
                                <th class="text-left py-3 px-4">Tanggal Kirim</th>
                                <th class="text-left py-3 px-4">Total</th>
                                <th class="text-left py-3 px-4">Status</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium">#{{ $order->id_pesanan }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4">{{ $order->tanggal_kirim ? \Carbon\Carbon::parse($order->tanggal_kirim)->format('d/m/Y') : '-' }}</td>
                                <td class="py-3 px-4">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'proses' => 'bg-blue-100 text-blue-800',
                                            'siap_kirim' => 'bg-purple-100 text-purple-800',
                                            'dikirim' => 'bg-indigo-100 text-indigo-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'batal' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusText = [
                                            'pending' => 'Menunggu Verifikasi',
                                            'proses' => 'Sedang Diproses',
                                            'siap_kirim' => 'Siap Diambil',
                                            'dikirim' => 'Sedang Dikirim',
                                            'selesai' => 'Selesai',
                                            'batal' => 'Dibatalkan'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass[$order->status_pesanan] ?? 'bg-gray-100' }}">
                                        <i class="fas
                                            @if($order->status_pesanan == 'pending') fa-clock
                                            @elseif($order->status_pesanan == 'proses') fa-cooking
                                            @elseif($order->status_pesanan == 'siap_kirim') fa-box
                                            @elseif($order->status_pesanan == 'dikirim') fa-truck
                                            @elseif($order->status_pesanan == 'selesai') fa-check
                                            @else fa-times
                                            @endif mr-1"></i>
                                        {{ $statusText[$order->status_pesanan] ?? $order->status_pesanan }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('customer.order.detail', $order->id_pesanan) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>
                                    @if($order->status_pesanan == 'selesai')
                                        <a href="#" class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-star mr-1"></i> Review
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-shopping-bag text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada pesanan</p>
                    <a href="{{ route('menu.index') }}" class="btn-primary inline-block mt-4 px-6 py-2 rounded-lg">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
