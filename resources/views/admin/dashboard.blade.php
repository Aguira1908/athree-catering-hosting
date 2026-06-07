@extends('layouts.main')

@section('title', 'Admin Dashboard - ATHREE Catering')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Dashboard Admin</h1>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pesanan</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-shopping-bag text-3xl text-gray-400"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Customer</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalCustomers ?? 0 }}</p>
                    </div>
                    <i class="fas fa-users text-3xl text-gray-400"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Menu</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalMenus ?? 0 }}</p>
                    </div>
                    <i class="fas fa-utensils text-3xl text-gray-400"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Pesanan Pending</p>
                        <p class="text-3xl font-bold mt-2">{{ $pendingOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-clock text-3xl text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Pesanan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-3 px-4">ID</th>
                            <th class="text-left py-3 px-4">Customer</th>
                            <th class="text-left py-3 px-4">Total</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">#{{ $order->id_pesanan }}</td>
                            <td class="py-3 px-4">{{ $order->customer_name ?? '-' }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
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
                                        'pending' => 'Pending',
                                        'proses' => 'Diproses',
                                        'siap_kirim' => 'Siap Kirim',
                                        'dikirim' => 'Dikirim',
                                        'selesai' => 'Selesai',
                                        'batal' => 'Batal'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass[$order->status_pesanan] ?? 'bg-gray-100' }}">
                                    {{ $statusText[$order->status_pesanan] ?? $order->status_pesanan }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.order.detail', $order->id_pesanan) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">Belum ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <a href="{{ route('admin.orders') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg">Kelola Pesanan</h3>
                    <p class="text-gray-500 text-sm">Lihat dan update status pesanan</p>
                </div>
                <i class="fas fa-arrow-right text-[#c4a77d]"></i>
            </a>
            <a href="{{ route('admin.menu.manage') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg">Kelola Menu</h3>
                    <p class="text-gray-500 text-sm">Tambah, edit, atau hapus menu</p>
                </div>
                <i class="fas fa-arrow-right text-[#c4a77d]"></i>
            </a>
            <a href="{{ route('admin.customers') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg">Kelola Customer</h3>
                    <p class="text-gray-500 text-sm">Lihat data customer</p>
                </div>
                <i class="fas fa-arrow-right text-[#c4a77d]"></i>
            </a>
            <!-- TAMBAHKAN CARD INI UNTUK KELOLA PEMBAYARAN -->
    <a href="{{ route('admin.payments') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition flex items-center justify-between">
        <div>
            <h3 class="font-bold text-lg">Kelola Pembayaran</h3>
            <p class="text-gray-500 text-sm">Verifikasi pembayaran customer</p>
        </div>
        <i class="fas fa-credit-card text-2xl text-[#c4a77d]"></i>
    </a>
</div>
        </div>
    </div>
</section>
@endsection
