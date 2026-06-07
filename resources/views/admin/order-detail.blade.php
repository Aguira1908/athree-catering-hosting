@extends('layouts.main')

@section('title', 'Detail Pesanan #' . ($order->id_pesanan ?? '') . ' - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Detail Pesanan #{{ $order->id_pesanan ?? '' }}</h1>
            <a href="{{ route('admin.orders') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informasi Pesanan -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Informasi Pesanan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">ID Pesanan</p>
                            <p class="font-medium">#{{ $order->id_pesanan }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Tanggal Pesan</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Tanggal Kirim</p>
                            <p class="font-medium">{{ $order->tanggal_kirim ? \Carbon\Carbon::parse($order->tanggal_kirim)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Total Harga</p>
                            <p class="font-bold text-lg text-[#c4a77d]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Informasi Customer</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Nama</p>
                            <p class="font-medium">{{ $order->customer_name ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Email</p>
                            <p class="font-medium">{{ $order->email ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">No. HP</p>
                            <p class="font-medium">{{ $order->no_hp ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Alamat Kirim</p>
                            <p class="font-medium">{{ $order->alamat_kirim ?? '-' }}</p>
                        </div>
                    </div>
                    @if($order->catatan)
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                            <p class="text-gray-500 text-sm">Catatan Customer</p>
                            <p class="font-medium">{{ $order->catatan }}</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Daftar Menu</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-2 px-3">Menu</th>
                                    <th class="text-center py-2 px-3">Jumlah</th>
                                    <th class="text-right py-2 px-3">Harga</th>
                                    <th class="text-right py-2 px-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                <tr class="border-b">
                                    <td class="py-2 px-3">{{ $item->nama_menu }}</td>
                                    <td class="text-center py-2 px-3">{{ $item->jumlah }}</td>
                                    <td class="text-right py-2 px-3">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-right py-2 px-3">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="text-right py-2 px-3 font-bold">Total</td>
                                    <td class="text-right py-2 px-3 font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div>
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4">Update Status</h2>

                    <form action="{{ route('admin.order.status', $order->id_pesanan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">Status Pesanan</label>
                            <select name="status_pesanan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                                <option value="pending" {{ $order->status_pesanan == 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu)</option>
                                <option value="proses" {{ $order->status_pesanan == 'proses' ? 'selected' : '' }}>🍳 Proses (Sedang Dimasak)</option>
                                <option value="siap_kirim" {{ $order->status_pesanan == 'siap_kirim' ? 'selected' : '' }}>📦 Siap Kirim</option>
                                <option value="dikirim" {{ $order->status_pesanan == 'dikirim' ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="selesai" {{ $order->status_pesanan == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="batal" {{ $order->status_pesanan == 'batal' ? 'selected' : '' }}>❌ Batal</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]" placeholder="Contoh: Pesanan akan diantar jam 10 pagi"></textarea>
                        </div>

                        <button type="submit" class="btn-primary w-full py-2 rounded-lg font-semibold">
                            Update Status
                        </button>
                    </form>

                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-500 text-sm mb-2">Status Saat Ini</p>
                        @php
                            $badgeClass = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'proses' => 'bg-blue-100 text-blue-800',
                                'siap_kirim' => 'bg-purple-100 text-purple-800',
                                'dikirim' => 'bg-indigo-100 text-indigo-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'batal' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $badgeClass[$order->status_pesanan] ?? 'bg-gray-100' }}">
                            {{ ucfirst($order->status_pesanan) }}
                        </span>
                    </div>
                </div>

                <!-- Tracking History -->
                <div class="bg-white rounded-xl shadow p-6 mt-6">
                    <h2 class="text-xl font-bold mb-4">Riwayat Status</h2>
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @forelse($tracking as $track)
                        <div class="flex gap-3">
                            <div class="w-2 h-2 mt-2 rounded-full {{ $loop->first ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                            <div>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($track->waktu)->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-700">{{ $track->deskripsi }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">Belum ada riwayat</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
