@extends('layouts.main')

@section('title', 'Menu - ATHREE Catering')

@section('content')
<!-- Menu Header -->
<section class="relative py-24 bg-[#1a1a2e]">
    <div class="container mx-auto px-4 text-center text-white">
        <span class="text-[#c4a77d] tracking-wider text-sm">MENU KAMI</span>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mt-2">Spesialitas Kami</h1>
        <div class="w-20 h-0.5 bg-[#c4a77d] mx-auto mt-4"></div>
        <p class="text-gray-300 mt-4 max-w-2xl mx-auto">Hidangan pilihan, dibuat dengan cinta dan penuh semangat.</p>
    </div>
</section>

<!-- Menu Categories -->
<section class="py-12 bg-white sticky top-20 z-30 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-4">
            <button class="category-btn px-6 py-2 rounded-full transition btn-primary text-white" data-category="all">Semua</button>
            <button class="category-btn px-6 py-2 rounded-full transition border border-gray-300 text-gray-600 hover:border-[#c4a77d]" data-category="Makanan">Makanan</button>
            <button class="category-btn px-6 py-2 rounded-full transition border border-gray-300 text-gray-600 hover:border-[#c4a77d]" data-category="Snack">Snack</button>
            <button class="category-btn px-6 py-2 rounded-full transition border border-gray-300 text-gray-600 hover:border-[#c4a77d]" data-category="Paket">Paket</button>
        </div>
    </div>
</section>

<!-- Menu Items -->
<section class="py-16 bg-[#faf8f5]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="menuList">
            @php
            $menus = DB::table('catering_menu')->get();
            @endphp

            @foreach($menus as $menu)
            <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-sm" data-category="{{ $menu->kategori }}">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $menu->foto ?? 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg' }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    <div class="absolute top-4 right-4 bg-[#c4a77d] text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </div>
                </div>
                <div class="p-6">
                    <div class="absolute top-4 right-4 bg-[#c4a77d] text-white px-3 py-1 rounded-full text-sm font-semibold">
    @if($menu->harga > 0)
        Rp {{ number_format($menu->harga, 0, ',', '.') }}
    @elseif($menu->kategori == 'Paket')
        💬 Chat WA
    @else
        Hubungi Kami
    @endif
</div>
                    <p class="text-gray-500 text-sm mb-4">{{ $menu->deskripsi ?? 'Hidangan pilihan, dibuat dengan cinta dan penuh semangat.' }}</p>

                    <!-- Form untuk menambah ke keranjang langsung -->
                    @if($menu->harga > 0)
    <!-- Form untuk menu dengan harga -->
    <form action="{{ route('cart.direct.add') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">
        <input type="hidden" name="jumlah" value="1">
        <button type="submit" class="w-full btn-primary py-2 rounded-full text-sm font-semibold">
            PESAN SEKARANG <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </form>
@elseif($menu->kategori == 'Paket' && $menu->harga == 0)
    <!-- Tombol WhatsApp untuk paket tumpeng -->
    <a href="https://wa.me/6282173408747?text=Halo%20ATHREE%20Catering%2C%20saya%20ingin%20pesan%20{{ urlencode($menu->nama_menu) }}.%20Mohon%20info%20harga%20dan%20porsi."
       target="_blank"
       class="w-full bg-green-600 text-white py-2 rounded-full text-sm font-semibold flex items-center justify-center gap-2 hover:bg-green-700 transition mt-4">
        <i class="fab fa-whatsapp"></i> TANYAKAN VIA WA
    </a>
@else
    <button class="w-full bg-gray-400 text-white py-2 rounded-full text-sm font-semibold cursor-not-allowed mt-4" disabled>
        TIDAK TERSEDIA
    </button>
@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
// Filter category
document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const category = this.dataset.category;

        document.querySelectorAll('.category-btn').forEach(b => {
            if (b.dataset.category === category) {
                b.classList.remove('border', 'border-gray-300', 'text-gray-600');
                b.classList.add('btn-primary', 'text-white');
            } else {
                b.classList.remove('btn-primary', 'text-white');
                b.classList.add('border', 'border-gray-300', 'text-gray-600');
            }
        });

        document.querySelectorAll('[data-category]').forEach(menu => {
            if (category === 'all' || menu.dataset.category === category) {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection
