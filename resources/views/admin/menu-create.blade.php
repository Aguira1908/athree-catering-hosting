@extends('layouts.main')

@section('title', 'Tambah Menu - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Tambah Menu Baru</h1>
            <a href="{{ route('admin.menu.manage') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Gambar Menu (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Nama Menu *</label>
                    <input type="text" name="nama_menu" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Kategori *</label>
                    <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        <option value="Makanan">Makanan</option>
                        <option value="Snack">Snack</option>
                        <option value="Paket">Paket</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Harga *</label>
                    <input type="number" name="harga" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-medium">Stok</label>
                    <input type="number" name="stok" value="0" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#c4a77d] text-white py-2 rounded-lg font-semibold hover:bg-[#a88b62] transition">
                    <i class="fas fa-save mr-2"></i> Simpan Menu
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
