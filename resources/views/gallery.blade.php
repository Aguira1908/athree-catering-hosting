@extends('layouts.main')

@section('title', 'Galeri Menu - ATHREE Catering')

@section('content')
<section class="relative py-24 bg-[#1a1a2e]">
    <div class="container mx-auto px-4 text-center text-white">
        <span class="text-[#c4a77d] tracking-wider text-sm">GALERI</span>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mt-2">Galeri Menu Kami</h1>
        <div class="w-20 h-0.5 bg-[#c4a77d] mx-auto mt-4"></div>
        <p class="text-gray-300 mt-4 max-w-2xl mx-auto">Koleksi foto menu unggulan dari ATHREE Catering</p>
    </div>
</section>

<section class="py-20 bg-[#faf8f5]">
    <div class="container mx-auto px-4">
        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button class="filter-btn px-5 py-2 rounded-full bg-[#c4a77d] text-white text-sm font-semibold" data-filter="all">Semua</button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 text-sm font-semibold hover:bg-[#c4a77d] hover:text-white transition" data-filter="Makanan">Makanan</button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 text-sm font-semibold hover:bg-[#c4a77d] hover:text-white transition" data-filter="Snack">Snack</button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 text-sm font-semibold hover:bg-[#c4a77d] hover:text-white transition" data-filter="Paket">Paket</button>
        </div>

        <!-- Grid Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="galleryGrid">
            @php
            // Ambil data menu dari database
            $menus = DB::table('catering_menu')->where('status', 'aktif')->get();
            @endphp

            @forelse($menus as $menu)
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg cursor-pointer" data-category="{{ $menu->kategori }}">
                <img src="{{ asset($menu->foto ?? 'image/default.png') }}" alt="{{ $menu->nama_menu }}" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-end pb-6">
                    <h3 class="text-white text-xl font-serif font-bold text-center px-4">{{ $menu->nama_menu }}</h3>
                    <p class="text-[#c4a77d] font-semibold mt-1">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-300 text-sm mt-1">{{ $menu->kategori }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-image text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada menu. Silakan tambah menu terlebih dahulu.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    // Filter Gallery
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;

            // Update active button style
            document.querySelectorAll('.filter-btn').forEach(b => {
                if (b.dataset.filter === filter) {
                    b.classList.remove('bg-gray-200', 'text-gray-700');
                    b.classList.add('bg-[#c4a77d]', 'text-white');
                } else {
                    b.classList.remove('bg-[#c4a77d]', 'text-white');
                    b.classList.add('bg-gray-200', 'text-gray-700');
                }
            });

            // Filter items
            document.querySelectorAll('.gallery-item').forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
