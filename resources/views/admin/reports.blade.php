@extends('layouts.main')

@section('title', 'Laporan - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Laporan</h1>

        <!-- Stats Cards -->
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
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <p class="text-3xl font-bold mt-2 text-green-600">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-3xl text-gray-400"></i>
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
                        <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                        <p class="text-3xl font-bold mt-2 text-green-600">{{ $completedOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Status Orders -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-yellow-800 text-sm">Pending</p>
                        <p class="text-2xl font-bold text-yellow-800">{{ $pendingOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-clock text-2xl text-yellow-500"></i>
                </div>
            </div>
            <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-800 text-sm">Diproses</p>
                        <p class="text-2xl font-bold text-blue-800">{{ $processingOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-cog text-2xl text-blue-500"></i>
                </div>
            </div>
            <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-green-800 text-sm">Selesai</p>
                        <p class="text-2xl font-bold text-green-800">{{ $completedOrders ?? 0 }}</p>
                    </div>
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                </div>
            </div>
        </div>

        <!-- Monthly Report Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <h2 class="text-xl font-bold p-6 border-b">Laporan Bulanan</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">Bulan</th>
                            <th class="text-center py-3 px-4">Jumlah Pesanan</th>
                            <th class="text-right py-3 px-4">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">
                                @php
                                    $months = [
                                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                    ];
                                    $monthYear = explode('-', $order->month);
                                    $monthName = $months[$monthYear[1]] ?? $monthYear[1];
                                @endphp
                                {{ $monthName }} {{ $monthYear[0] }}
                            </td>
                            <td class="text-center py-3 px-4">{{ $order->total }}</td>
                            <td class="text-right py-3 px-4 font-medium text-green-600">
                                Rp {{ number_format($order->revenue, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">Belum ada data pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Export Button -->
        <div class="mt-6 flex justify-end">
            <button onclick="window.print()" class="btn-primary px-6 py-2 rounded-lg">
                <i class="fas fa-print mr-2"></i> Cetak Laporan
            </button>
        </div>
    </div>
</section>

<style>
    @media print {
        nav, footer, .btn-primary, .bg-yellow-50, .bg-blue-50, .bg-green-50 {
            display: none !important;
        }
        body {
            background: white;
            padding: 20px;
        }
        .shadow {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endsection
