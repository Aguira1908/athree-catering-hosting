@extends('layouts.main')

@section('title', 'Kelola Pesanan - ATHREE Catering')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Kelola Pesanan</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">ID Pesanan</th>
                            <th class="text-left py-3 px-4">Customer</th>
                            <th class="text-left py-3 px-4">Tanggal</th>
                            <th class="text-left py-3 px-4">Total</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">#{{ $order->id_pesanan }}</td>
                            <td class="py-3 px-4">{{ $order->customer_name ?? '-' }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y') }}</td>
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
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs {{ $statusClass[$order->status_pesanan] ?? 'bg-gray-100' }}">
                                    @if($order->status_pesanan == 'pending') Menunggu
                                    @elseif($order->status_pesanan == 'proses') Diproses
                                    @elseif($order->status_pesanan == 'siap_kirim') Siap Diambil
                                    @elseif($order->status_pesanan == 'dikirim') Dikirim
                                    @elseif($order->status_pesanan == 'selesai') Selesai
                                    @elseif($order->status_pesanan == 'batal') Batal
                                    @endif
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.order.detail', $order->id_pesanan) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">Belum ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
