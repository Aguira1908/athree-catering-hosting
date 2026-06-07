@extends('layouts.main')

@section('title', 'Kelola Pembayaran - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Kelola Pembayaran</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">ID</th>
                            <th class="text-left py-3 px-4">Customer</th>
                            <th class="text-left py-3 px-4">ID Pesanan</th>
                            <th class="text-right py-3 px-4">Jumlah</th>
                            <th class="text-center py-3 px-4">Metode</th>
                            <th class="text-center py-3 px-4">Status</th>
                            <th class="text-center py-3 px-4">Tanggal</th>
                            <th class="text-center py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $payment->id_pembayaran }}</td>
                            <td class="py-3 px-4">{{ $payment->customer_name ?? '-' }}</td>
                            <td class="py-3 px-4">#{{ $payment->id_pesanan }}</td>
                            <td class="py-3 px-4 text-right">Rp {{ number_format($payment->jumlah_bayar ?? $payment->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs bg-gray-100">
                                    {{ $payment->metode_pembayaran == 'transfer' ? 'Transfer Bank' : 'QRIS' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'verified' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs {{ $statusClass[$payment->status_verifikasi] ?? 'bg-gray-100' }}">
                                    @if($payment->status_verifikasi == 'pending')
                                        Menunggu
                                    @elseif($payment->status_verifikasi == 'verified')
                                        Terverifikasi
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ $payment->tanggal_bayar ? \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($payment->status_verifikasi == 'pending')
                                    <form action="{{ route('admin.payment.verify', $payment->id_pembayaran) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="text-green-600 hover:text-green-800 mr-2" title="Verifikasi" onclick="return confirm('Verifikasi pembayaran ini?')">
                                            <i class="fas fa-check-circle text-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payment.verify', $payment->id_pembayaran) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Tolak" onclick="return confirm('Tolak pembayaran ini?')">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                    </form>
                                @elseif($payment->status_verifikasi == 'verified')
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="text-red-600">
                                        <i class="fas fa-times-circle"></i> Rejected
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-500">
                                <i class="fas fa-credit-card text-4xl mb-2 block"></i>
                                Belum ada data pembayaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
