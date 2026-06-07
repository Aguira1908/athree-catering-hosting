@extends('layouts.main')

@section('title', 'Keranjang Belanja - ATHREE Catering')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Keranjang Belanja</h1>

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

    @if(empty($cart))
        <div class="text-center py-12 bg-white rounded-xl shadow">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Keranjang belanja masih kosong</p>
            <a href="{{ route('menu.index') }}" class="btn-primary inline-block mt-4 px-6 py-2 rounded-lg">
                Lihat Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Daftar Item -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left py-4 px-4">Menu</th>
                                    <th class="text-center py-4 px-4">Jumlah</th>
                                    <th class="text-right py-4 px-4">Subtotal</th>
                                    <th class="text-center py-4 px-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div>
                                            <h4 class="font-semibold">{{ $item['nama_menu'] }}</h4>
                                            <p class="text-sm text-gray-500">{{ $item['kategori'] ?? 'Menu' }}</p>
                                            <p class="text-sm text-gray-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex justify-center items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="id_menu" value="{{ $id }}">
                                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1"
                                                class="w-16 px-2 py-1 bg-gray-100 border border-gray-300 rounded text-center focus:outline-none focus:border-[#c4a77d]">
                                            <button type="submit" class="text-gray-500 hover:text-[#c4a77d] transition">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 text-right font-semibold">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua keranjang?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-500 text-sm transition">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan -->
            <div>
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>

                    <div class="space-y-3 mb-6">
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

                    @auth('customer')
                        <a href="{{ route('checkout.form') }}" class="btn-primary w-full block text-center py-3 rounded-lg font-semibold">
                            Lanjut ke Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full block text-center py-3 rounded-lg font-semibold">
                            Login untuk Checkout
                        </a>
                    @endauth

                    <a href="{{ route('menu.index') }}" class="block text-center text-gray-500 hover:text-[#c4a77d] mt-4 text-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Menu Lain
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
