@extends('layouts.main')

@section('title', 'Kelola Menu - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Kelola Menu</h1>
            <a href="{{ route('admin.menu.create') }}" class="bg-[#c4a77d] text-white px-4 py-2 rounded-lg hover:bg-[#a88b62] transition">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
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

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">ID</th>
                            <th class="text-left py-3 px-4">Gambar</th>
                            <th class="text-left py-3 px-4">Nama Menu</th>
                            <th class="text-left py-3 px-4">Kategori</th>
                            <th class="text-right py-3 px-4">Harga</th>
                            <th class="text-center py-3 px-4">Stok</th>
                            <th class="text-center py-3 px-4">Status</th>
                            <th class="text-center py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $menu->id_menu }}</td>
                            <td class="py-3 px-4">
                                @if($menu->foto && file_exists(public_path($menu->foto)))
                                    <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-medium">{{ $menu->nama_menu }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs bg-gray-100">
                                    {{ $menu->kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">{{ $menu->stok ?? 0 }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($menu->status == 'aktif')
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.menu.edit', $menu->id_menu) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menu.destroy', $menu->id_menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-500">
                                <i class="fas fa-utensils text-4xl mb-2 block"></i>
                                Belum ada menu. Silakan tambah menu baru.
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
