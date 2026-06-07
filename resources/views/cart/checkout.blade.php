@extends('layouts.main')

@section('title', 'Checkout - ATHREE Catering')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Informasi Pengiriman & Pembayaran -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('checkout') }}" id="checkoutForm">
                @csrf

                <!-- Informasi Pengiriman -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Informasi Pengiriman</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Alamat Kirim *</label>
                        <textarea name="alamat_kirim" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]"
                            required>{{ Auth::guard('customer')->user()->alamat ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Tanggal Kirim *</label>
                        <input type="date" name="tanggal_kirim"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]"
                            placeholder="Contoh: Tolong pisahkan sambal"></textarea>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Metode Pembayaran</h3>

                    <div class="space-y-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" id="transferLabel">
                            <input type="radio" name="metode_bayar" value="transfer" class="mr-3" checked>
                            <i class="fas fa-university text-blue-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-semibold">Transfer Bank</p>
                                <p class="text-sm text-gray-500">BCA / Mandiri / BRI</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" id="qrisLabel">
                            <input type="radio" name="metode_bayar" value="qris" class="mr-3">
                            <i class="fas fa-qrcode text-green-600 text-xl mr-3"></i>
                            <div>
                                <p class="font-semibold">QRIS</p>
                                <p class="text-sm text-gray-500">Scan menggunakan aplikasi bank</p>
                            </div>
                        </label>
                    </div>

                    <!-- Detail Rekening (Transfer) -->
                    <div id="rekeningInfo" class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700 font-medium mb-2">Nomor Rekening:</p>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center p-2 bg-white rounded">
                                <span class="font-mono">SEABANK: 901788899458</span>
                                <button type="button" onclick="copyText('SEABANK: 901788899458')" class="text-blue-600 text-sm">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-white rounded">
                                <span class="font-mono">Mandiri: 1050016693891</span>
                                <button type="button" onclick="copyText('Mandiri: 1050016693891')" class="text-blue-600 text-sm">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">a.n Sutri</p>
                    </div>

                    <!-- QRIS Info -->
<div id="qrisInfo" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
    <div class="text-center">
        <div class="inline-block p-4 bg-white rounded-lg">
            <img src="{{ asset('image/qris.png') }}" alt="QRIS GoPay" class="w-48 h-48 mx-auto">
        </div>
        <p class="text-sm text-gray-600 mt-2">Scan QRIS menggunakan GoPay / Bank apa saja</p>
        <p class="text-xs text-gray-500 mt-1">a.n ATHREE Catering</p>
    </div>
</div>
                </div>

                <!-- WhatsApp Konfirmasi -->
                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                    <div class="flex items-start gap-3">
                        <i class="fab fa-whatsapp text-3xl text-green-600"></i>
                        <div class="flex-1">
                            <h4 class="font-semibold text-green-800">Konfirmasi Pembayaran via WhatsApp</h4>
                            <p class="text-sm text-green-700 mt-1">
                                Setelah melakukan transfer, silakan konfirmasi melalui WhatsApp dengan mengirimkan bukti transfer.
                            </p>
                            <div class="mt-3">
                                <button type="button" onclick="sendWhatsApp()"
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition inline-flex items-center gap-2">
                                    <i class="fab fa-whatsapp"></i> Konfirmasi via WhatsApp
                                </button>
                            </div>
                            <p class="text-xs text-green-600 mt-2">
                                * Pesanan akan diproses setelah pembayaran diverifikasi
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full py-3 rounded-lg font-semibold mt-6">
                    Buat Pesanan
                </button>
            </form>
        </div>

        <!-- Ringkasan Pesanan -->
        <div>
            <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>

                <div class="max-h-80 overflow-y-auto mb-4">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-sm mb-3 pb-3 border-b border-gray-100">
                        <div>
                            <p class="font-semibold">{{ $item['nama_menu'] }}</p>
                            <p class="text-gray-500 text-xs">x{{ $item['jumlah'] }}</p>
                        </div>
                        <span class="font-medium">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-3 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Kirim</span>
                        <span>Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-[#c4a77d]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('cart') }}" class="block text-center text-gray-500 hover:text-[#c4a77d] mt-4 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle metode pembayaran info
    document.querySelectorAll('input[name="metode_bayar"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const rekeningInfo = document.getElementById('rekeningInfo');
            const qrisInfo = document.getElementById('qrisInfo');

            if (this.value === 'transfer') {
                rekeningInfo.classList.remove('hidden');
                qrisInfo.classList.add('hidden');
            } else {
                rekeningInfo.classList.add('hidden');
                qrisInfo.classList.remove('hidden');
            }
        });
    });

    // Copy teks ke clipboard
    function copyText(text) {
        navigator.clipboard.writeText(text);
        alert('Nomor rekening disalin: ' + text);
    }

    // Simpan data sementara untuk WhatsApp
    let pendingOrderData = null;

    // WhatsApp konfirmasi
    function sendWhatsApp() {
        const alamat = document.querySelector('textarea[name="alamat_kirim"]').value;
        const tanggalKirim = document.querySelector('input[name="tanggal_kirim"]').value;
        const metodeBayar = document.querySelector('input[name="metode_bayar"]:checked').value;
        const total = {{ $total }};

        if (!alamat || !tanggalKirim) {
            alert('Silakan isi alamat dan tanggal kirim terlebih dahulu!');
            return;
        }

        const message = `Halo ATHREE Catering,

Saya ingin konfirmasi pembayaran untuk pesanan:

Nama: {{ Auth::guard('customer')->user()->nama }}
Email: {{ Auth::guard('customer')->user()->email }}
Total: Rp {{ number_format($total, 0, ',', '.') }}
Metode: ${metodeBayar === 'transfer' ? 'Transfer Bank' : 'QRIS'}
Tanggal Kirim: ${tanggalKirim}
Alamat: ${alamat}

*Bukti transfer akan menyusul*

Terima kasih.`;

        const encodedMessage = encodeURIComponent(message);
        const phoneNumber = '6282173408747'; // Ganti dengan nomor WhatsApp admin
        window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');
    }
</script>
@endsection
