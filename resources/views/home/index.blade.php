@extends('layouts.main')

@section('title', 'ATHREE Catering - Layanan Catering Premium')

@section('content')
<!-- Hero Section -->
<section class="hero-section min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute inset-0 bg-black/70 z-10"></div>
    <div class="absolute inset-0">
        <img src="{{ asset('image/coverberanda.png') }}" alt="Hero" class="w-full h-full object-cover">
    </div>

    <div class="container mx-auto px-4 relative z-20 text-white">
        <div class="max-w-2xl animate-fade-up">
            <span class="text-[#c4a77d] tracking-wider text-sm">SELAMAT DATANG DI ATHREE CATERING</span>
            <h1 class="text-5xl md:text-7xl font-serif font-bold mt-4 mb-6">Makanan Enak<br>Suasana Bahagia</h1>
            <p class="text-gray-200 text-lg mb-8">Nikmati cita rasa kaya, suasana hangat, dan momen tak terlupakan dalam setiap gigitan.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('menu.index') }}" class="btn-primary px-8 py-3 rounded-full font-semibold">LIHAT MENU</a>
            </div>

        <div class="grid grid-cols-4 gap-4 mt-16">
            <div class="flex items-center gap-3">
            <i class="fas fa-calendar-alt text-3xl text-[#c4a77d]"></i>
            <div>
                <div class="stat-number">15+</div>
                <p class="text-sm text-gray-300">Tahun Pengalaman</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <i class="fas fa-user-chef text-3xl text-[#c4a77d]"></i>
            <div>
                <div class="stat-number">25+</div>
                <p class="text-sm text-gray-300">Koki Ahli</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <i class="fas fa-star text-3xl text-[#c4a77d]"></i>
            <div>
                <div class="stat-number">4.8</div>
                <p class="text-sm text-gray-300">Rating Rata-rata</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <i class="fas fa-smile text-3xl text-[#c4a77d]"></i>
            <div>
                <div class="stat-number">10K+</div>
                <p class="text-sm text-gray-300">Pelanggan Puas</p>
            </div>
    </div>
</div>
</div>
</section>

<!-- Our Specialties -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-[#c4a77d] tracking-wider text-sm">SPESIALITAS KAMI</span>
            <h2 class="section-title mt-2">Kreasi Lezat</h2>
            <div class="flex justify-center mt-4">
                <a href="{{ route('menu.index') }}" class="text-[#c4a77d] hover:text-[#a88b62] flex items-center gap-2">LIHAT MENU LENGKAP <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
$specialties = [
    [
        'name' => 'Nasi Paket Rendang',
        'price' => 35000,
        'desc' => 'Nasi putih hangat dengan rendang sapi pilihan yang dimasak dengan bumbu rempah khas Padang. Empuk, gurih, dan kaya rasa.',
        'image' => asset('image/nasirendang.png'),
        'wa_message' => null
    ],
    [
        'name' => 'Nasi Gurih',
        'price' => 25000,
        'desc' => 'Nasi yang dimasak dengan santan dan rempah pilihan, disajikan dengan telur balado dan sambal teri. Cocok untuk sarapan atau makan siang.',
        'image' => asset('image/nasigurih.png'),
        'wa_message' => null
    ],
    [
        'name' => 'Ricebowl Ayam Popcorn Chilipadi',
        'price' => 20000,
        'desc' => 'Rice bowl dengan ayam popcorn chilipadi pedas gurih, ditambah telur mata sapi, timun, dan sambal. Porsi pas untuk satu orang.',
        'image' => asset('image/ricebowlchilipadi.png'),
        'wa_message' => null
    ],
    [
        'name' => 'Sambel Tempe Orek + Teri',
        'price' => 35000,
        'desc' => 'Tempe orek pedas manis dicampur teri nasi gurih. Disajikan dengan nasi putih dan lalapan. Murah meriah tapi nagih!',
        'image' => asset('image/tempeorek.png'),
        'wa_message' => null
    ],
];
@endphp

            @foreach($specialties as $index => $item)
            <div class="menu-card card-hover">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    <div class="absolute top-4 right-4 bg-[#c4a77d] text-white px-3 py-1 rounded-full text-sm font-semibold">
                        @if($item['price'])
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        @else
                            💬 Chat WA
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-serif font-bold mb-2">{{ $item['name'] }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ $item['desc'] }}</p>

                    @if($item['price'])
                        <button onclick="addToCart({{ $index }})" class="w-full btn-primary py-2 rounded-full text-sm font-semibold">
                            PESAN SEKARANG
                        </button>
                    @else
                        <a href="https://wa.me/6282173408747?text={{ urlencode($item['wa_message']) }}"
                           target="_blank"
                           class="w-full bg-green-600 text-white py-2 rounded-full text-sm font-semibold flex items-center justify-center gap-2 hover:bg-green-700 transition">
                            <i class="fab fa-whatsapp"></i> TANYAKAN VIA WA
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function addToCart(id) {
    alert('Menu ditambahkan ke keranjang!');
}
</script>
@endpush
