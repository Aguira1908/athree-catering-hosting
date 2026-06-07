@extends('layouts.main')

@section('title', 'Edit Menu - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit Menu</h1>
            <a href="{{ route('admin.menu.manage') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Gambar Saat Ini -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Gambar Saat Ini</label>
                    @if($menu->foto && file_exists(public_path($menu->foto)))
                        <div class="mb-2">
                            <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @else
                        <div class="mb-2 p-4 bg-gray-100 rounded-lg text-center">
                            <i class="fas fa-image text-3xl text-gray-400 mb-1"></i>
                            <p class="text-sm text-gray-500">Belum ada gambar</p>
                        </div>
                    @endif
                </div>

                <!-- Upload Gambar Baru -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Ganti Gambar (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Nama Menu *</label>
                    <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Kategori *</label>
                    <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        <option value="Makanan" {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Snack" {{ $menu->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                        <option value="Paket" {{ $menu->kategori == 'Paket' ? 'selected' : '' }}>Paket</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Harga *</label>
                    <input type="number" name="harga" value="{{ $menu->harga }}" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">{{ $menu->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Stok</label>
                    <input type="number" name="stok" value="{{ $menu->stok ?? 0 }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        <option value="aktif" {{ $menu->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $menu->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#c4a77d] text-white py-2 rounded-lg font-semibold hover:bg-[#a88b62] transition">
                    <i class="fas fa-save mr-2"></i> Update Menu
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
