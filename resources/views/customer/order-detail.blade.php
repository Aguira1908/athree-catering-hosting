@extends('layouts.main')

@section('title', 'Detail Pesanan #' . ($order->id_pesanan ?? '') . ' - ATHREE Catering')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold">Detail Pesanan</h1>
                <p class="text-gray-500 mt-1">ID Pesanan: #{{ $order->id_pesanan ?? '' }}</p>
            </div>
            <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

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

        <!-- Progress Status -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-bold mb-6">Status Pesanan</h2>

            @php
                $statusOrder = ['pending', 'proses', 'siap_kirim', 'dikirim', 'selesai'];
                $currentIndex = array_search($order->status_pesanan, $statusOrder);
                if ($currentIndex === false) $currentIndex = -1;

                $statusIcons = [
                    'pending' => 'fa-clock',
                    'proses' => 'fa-utensils',
                    'siap_kirim' => 'fa-box',
                    'dikirim' => 'fa-truck',
                    'selesai' => 'fa-check'
                ];

                $statusLabels = [
                    'pending' => 'Menunggu Verifikasi',
                    'proses' => 'Sedang Diproses',
                    'siap_kirim' => 'Siap Diambil',
                    'dikirim' => 'Sedang Dikirim',
                    'selesai' => 'Selesai'
                ];
            @endphp

            <!-- Timeline Progress -->
            <div class="relative">
                <!-- Progress Bar Background -->
                <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 rounded-full -z-10"></div>

                <!-- Progress Bar Active -->
                <div class="absolute top-5 left-0 h-1 bg-green-500 rounded-full transition-all duration-500 -z-10" style="width: {{ ($currentIndex + 1) * 20 }}%"></div>

                <!-- Steps -->
                <div class="flex justify-between">
                    <div class="text-center flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center transition-all duration-300 {{ $currentIndex >= 0 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas fa-clock"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium {{ $currentIndex >= 0 ? 'text-green-600' : 'text-gray-500' }}">Menunggu</p>
                        @if($currentIndex >= 0)
                            <p class="text-xs text-gray-400 mt-1">Verifikasi admin</p>
                        @endif
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center transition-all duration-300 {{ $currentIndex >= 1 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium {{ $currentIndex >= 1 ? 'text-green-600' : 'text-gray-500' }}">Diproses</p>
                        @if($currentIndex >= 1)
                            <p class="text-xs text-gray-400 mt-1">Sedang dimasak</p>
                        @endif
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center transition-all duration-300 {{ $currentIndex >= 2 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas fa-box"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium {{ $currentIndex >= 2 ? 'text-green-600' : 'text-gray-500' }}">Siap</p>
                        @if($currentIndex >= 2)
                            <p class="text-xs text-gray-400 mt-1">Siap diambil/dikirim</p>
                        @endif
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center transition-all duration-300 {{ $currentIndex >= 3 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas fa-truck"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium {{ $currentIndex >= 3 ? 'text-green-600' : 'text-gray-500' }}">Dikirim</p>
                        @if($currentIndex >= 3)
                            <p class="text-xs text-gray-400 mt-1">Dalam perjalanan</p>
                        @endif
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center transition-all duration-300 {{ $currentIndex >= 4 ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium {{ $currentIndex >= 4 ? 'text-green-600' : 'text-gray-500' }}">Selesai</p>
                        @if($currentIndex >= 4)
                            <p class="text-xs text-gray-400 mt-1">Pesanan selesai</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Message -->
            <div class="mt-8 p-4 rounded-lg text-center {{ $order->status_pesanan == 'batal' ? 'bg-red-50' : 'bg-gray-50' }}">
                @if($order->status_pesanan == 'batal')
                    <i class="fas fa-times-circle text-red-500 text-2xl mb-2"></i>
                    <p class="text-red-600 font-medium">Pesanan ini telah dibatalkan</p>
                    <p class="text-red-500 text-sm mt-1">Silakan hubungi admin untuk informasi lebih lanjut</p>
                @elseif($order->status_pesanan == 'pending')
                    <i class="fas fa-clock text-yellow-500 text-2xl mb-2"></i>
                    <p class="text-gray-700">Pesanan Anda sedang menunggu verifikasi dari admin</p>
                    <p class="text-gray-500 text-sm mt-1">Mohon tunggu konfirmasi dari kami</p>
                @elseif($order->status_pesanan == 'proses')
                    <i class="fas fa-utensils text-blue-500 text-2xl mb-2"></i>
                    <p class="text-gray-700">Pesanan Anda sedang diproses oleh tim dapur kami</p>
                    <p class="text-gray-500 text-sm mt-1">Kami akan segera menyiapkan pesanan Anda</p>
                @elseif($order->status_pesanan == 'siap_kirim')
                    <i class="fas fa-box text-purple-500 text-2xl mb-2"></i>
                    <p class="text-gray-700">Pesanan Anda sudah siap!</p>
                    <p class="text-gray-500 text-sm mt-1">Silakan ambil atau akan segera dikirim</p>
                @elseif($order->status_pesanan == 'dikirim')
                    <i class="fas fa-truck text-indigo-500 text-2xl mb-2"></i>
                    <p class="text-gray-700">Pesanan Anda sedang dalam perjalanan</p>
                    <p class="text-gray-500 text-sm mt-1">Silakan tunggu kurir kami sampai di tujuan</p>
                @elseif($order->status_pesanan == 'selesai')
                    <i class="fas fa-check-circle text-green-500 text-2xl mb-2"></i>
                    <p class="text-gray-700">Pesanan Anda telah selesai!</p>
                    <p class="text-gray-500 text-sm mt-1">Terima kasih telah memesan di ATHREE Catering</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informasi Pesanan & Menu -->
            <div class="lg:col-span-2">
                <!-- Informasi Pesanan -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-receipt text-[#c4a77d] mr-2"></i>
                        Informasi Pesanan
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">ID Pesanan</p>
                            <p class="font-medium text-lg">#{{ $order->id_pesanan }}</p>
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
                            <p class="text-gray-500 text-sm">Status Pembayaran</p>
                            <p class="font-medium">
                                @if($order->status_bayar == 'lunas')
                                    <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Lunas</span>
                                @elseif($order->status_bayar == 'verifikasi')
                                    <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i> Menunggu Verifikasi</span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i> Belum Bayar</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Alamat Kirim -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-[#c4a77d] mr-2"></i>
                        Alamat Pengiriman
                    </h2>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium">{{ $order->alamat_kirim ?? '-' }}</p>
                        @if($order->catatan)
                            <p class="text-gray-500 text-sm mt-2">
                                <i class="fas fa-sticky-note mr-1"></i> Catatan: {{ $order->catatan }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Daftar Menu -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-utensils text-[#c4a77d] mr-2"></i>
                        Daftar Menu
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 rounded-lg">
                                <tr>
                                    <th class="text-left py-3 px-4">Menu</th>
                                    <th class="text-center py-3 px-4">Jumlah</th>
                                    <th class="text-right py-3 px-4">Harga</th>
                                    <th class="text-right py-3 px-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div>
                                            <p class="font-medium">{{ $item->nama_menu }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->kategori ?? 'Menu' }}</p>
                                        </div>
                                    </td>
                                    <td class="text-center py-3 px-4">
                                        <span class="inline-block w-8 h-8 bg-gray-100 rounded-full text-center leading-8">{{ $item->jumlah }}</span>
                                    </td>
                                    <td class="text-right py-3 px-4">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-right py-3 px-4 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="text-right py-3 px-4 font-bold">Total</td>
                                    <td class="text-right py-3 px-4 font-bold text-lg text-[#c4a77d]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Tracking History -->
            <div>
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-history text-[#c4a77d] mr-2"></i>
                        Riwayat Status
                    </h2>

                    <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        @forelse($tracking as $track)
                        <div class="flex gap-3 relative">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 rounded-full {{ $loop->first ? 'bg-green-500 ring-4 ring-green-100' : 'bg-gray-400' }}"></div>
                                @if(!$loop->last)
                                    <div class="w-0.5 h-full bg-gray-200 mt-1"></div>
                                @endif
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($track->waktu)->translatedFormat('l, d F Y H:i') }}
                                </p>
                                <p class="text-gray-600 text-sm mt-1">{{ $track->deskripsi }}</p>
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
                                <span class="inline-block px-2 py-1 rounded-full text-xs {{ $badgeClass[$track->status] ?? 'bg-gray-100' }} mt-2">
                                    {{ $statusLabels[$track->status] ?? $track->status }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-history text-3xl mb-2"></i>
                            <p>Belum ada riwayat status</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Invoice Button -->
                    <div class="mt-6 pt-4 border-t">
                        <button onclick="window.print()" class="w-full btn-outline py-2 rounded-lg font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-print"></i> Cetak Invoice
                        </button>
                    </div>
                </div>

                <!-- Need Help -->
                <div class="bg-white rounded-xl shadow p-6 mt-6">
                    <h3 class="font-bold mb-3">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-600 mb-3">Hubungi customer service kami</p>
                    <div class="space-y-2 text-sm">
                        <p><i class="fab fa-whatsapp text-green-500 w-6"></i> +62 812 3456 7890</p>
                        <p><i class="fas fa-envelope text-gray-500 w-6"></i> cs@athree.com</p>
                    </div>
                </div>
            </div>

            <!-- Payment Section di Sidebar -->
<!-- Payment Section di Sidebar -->
<div class="bg-white rounded-xl shadow p-6 mt-6">
    <h3 class="font-bold mb-3 flex items-center">
        <i class="fas fa-credit-card text-[#c4a77d] mr-2"></i>
        Informasi Pembayaran
    </h3>

    @php
        $payment = DB::table('pembayaran')->where('id_pesanan', $order->id_pesanan)->first();
    @endphp

    @if($order->status_bayar == 'pending' || $order->status_bayar == 'belum_bayar')
        <div class="space-y-3">
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Total yang harus dibayar:</p>
                <p class="text-2xl font-bold text-[#c4a77d]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            </div>

            <div class="p-3 bg-blue-50 rounded-lg">
                <p class="text-sm font-medium text-blue-800 mb-2">Metode Pembayaran:</p>
                <p class="text-sm text-blue-700">
                    @if($payment && $payment->metode_pembayaran == 'transfer')
                        Transfer Bank (BCA/Mandiri)
                    @else
                        QRIS (GoPay/OVO/Dana)
                    @endif
                </p>
            </div>

            @if($payment && $payment->metode_pembayaran == 'qris')
                <!-- Tampilkan QRIS -->
                <div class="p-3 bg-green-50 rounded-lg">
                    <p class="text-sm text-green-800 mb-2 text-center">Scan QRIS untuk membayar:</p>
                    <div class="text-center">
                        <img src="{{ asset('image/qris.png') }}" alt="QRIS GoPay" class="w-48 h-48 mx-auto">
                    </div>
                    <p class="text-xs text-green-600 mt-2 text-center">Scan menggunakan GoPay / OVO / Dana</p>
                    <p class="text-xs text-gray-500 mt-1 text-center">a.n ATHREE Catering</p>
                </div>
            @else
                <!-- Tampilkan Rekening Bank -->
                <div class="p-3 bg-green-50 rounded-lg">
                    <p class="text-sm text-green-800 mb-2">Nomor Rekening:</p>
                    <div class="space-y-1">
                        <p class="font-mono text-sm">SEABANK: 901788899458 a.n Sutri</p>
                        <p class="font-mono text-sm">Mandiri: 1050016693891 a.n Sutri</p>
                    </div>
                    <button onclick="copyRekening()" class="text-xs text-green-600 mt-2">📋 Salin nomor rekening</button>
                </div>
            @endif

            <a href="https://wa.me/6281234567890?text=Halo%20ATHREE%2C%20saya%20ingin%20konfirmasi%20pembayaran%20pesanan%20%23{{ $order->id_pesanan }}"
               target="_blank"
               class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-green-700 transition">
                <i class="fab fa-whatsapp"></i> Konfirmasi via WhatsApp
            </a>
        </div>
    @elseif($order->status_bayar == 'lunas')
        <div class="p-3 bg-green-100 rounded-lg text-center">
            <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
            <p class="text-green-800 font-semibold">Pembayaran Lunas</p>
            <p class="text-green-600 text-sm">Terima kasih!</p>
        </div>
    @else
        <div class="p-3 bg-yellow-100 rounded-lg text-center">
            <i class="fas fa-clock text-yellow-600 text-2xl mb-2"></i>
            <p class="text-yellow-800 font-semibold">Menunggu Verifikasi</p>
            <p class="text-yellow-600 text-sm">Pembayaran sedang diverifikasi</p>
        </div>
    @endif
</div>

<script>
function copyRekening() {
    const rekening = "BCA: 123 456 7890 a.n ATHREE Catering\nMandiri: 098 765 4321 a.n ATHREE Catering";
    navigator.clipboard.writeText(rekening);
    alert('Nomor rekening disalin!');
}
</script>

<script>
function copyRekening() {
    const rekening = "BCA: 123 456 7890 a.n ATHREE Catering\nMandiri: 098 765 4321 a.n ATHREE Catering";
    navigator.clipboard.writeText(rekening);
    alert('Nomor rekening disalin!');
}
</script>
        </div>

        <!-- Action Buttons -->
        @if($order->status_pesanan == 'pending' && $order->status_bayar == 'belum_bayar')
        <div class="mt-8 flex justify-center gap-4">
            <a href="#" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
            </a>
            <a href="{{ route('menu.index') }}" class="btn-outline px-8 py-3 rounded-lg font-semibold">
                <i class="fas fa-plus mr-2"></i> Pesan Lagi
            </a>
        </div>
        @endif

        @if($order->status_pesanan == 'selesai')
        <div class="mt-8 flex justify-center">
            <a href="{{ route('menu.index') }}" class="btn-primary px-8 py-3 rounded-lg font-semibold">
                <i class="fas fa-shopping-bag mr-2"></i> Pesan Lagi
            </a>
        </div>
        @endif
    </div>
</section>

<style>
    @media print {
        nav, footer, .btn-primary, .btn-outline, #mobileMenuBtn, .sticky, .cart-icon, [class*="flex justify-center"] {
            display: none !important;
        }
        body {
            background: white;
            padding: 20px;
        }
        .bg-white, .shadow {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .container {
            max-width: 100%;
            padding: 0;
        }
    }
</style>
@endsection
