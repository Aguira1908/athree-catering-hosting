@extends('layouts.main')

@section('title', 'ATHREE Catering - Layanan Catering Premium')

@section('content')
  <!-- Hero Section -->
  <section class="hero-section relative flex min-h-screen items-center overflow-hidden">
    <div class="absolute inset-0 z-10 bg-black/70"></div>
    <div class="absolute inset-0">
      <img alt="Hero" class="h-full w-full object-cover" src="{{ asset('image/coverberanda.png') }}">
    </div>

    <div class="container relative z-20 mx-auto px-4 text-white">
      <div class="animate-fade-up max-w-2xl">
        <span class="text-sm tracking-wider text-[#c4a77d]">SELAMAT DATANG DI ATHREE CATERING</span>
        <h1 class="mb-6 mt-4 font-serif text-5xl font-bold md:text-7xl">Makanan Enak<br>Suasana Bahagia</h1>
        <p class="mb-8 text-lg text-gray-200">Nikmati cita rasa kaya, suasana hangat, dan momen tak terlupakan dalam
          setiap gigitan.</p>
        <div class="flex flex-wrap gap-4">
          <a class="btn-primary rounded-full px-8 py-3 font-semibold" href="{{ route('menu.index') }}">LIHAT MENU</a>
        </div>

        <div class="mt-16 grid grid-cols-4 gap-4">
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
  <section class="bg-white py-20">
    <div class="container mx-auto px-4">
      <div class="mb-12 text-center">
        <span class="text-sm tracking-wider text-[#c4a77d]">SPESIALITAS KAMI</span>
        <h2 class="section-title mt-2">Kreasi Lezat</h2>
        <div class="mt-4 flex justify-center">
          <a class="flex items-center gap-2 text-[#c4a77d] hover:text-[#a88b62]" href="{{ route('menu.index') }}">LIHAT
            MENU LENGKAP <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        @foreach ($specialties as $item)
          <div class="menu-card card-hover">
            <div class="relative h-64 overflow-hidden">
              <img alt="{{ $item->nama_menu }}"
                class="h-full w-full object-cover transition-transform duration-500 hover:scale-110"
                src="{{ asset($item->foto) }}">
              <div class="absolute right-4 top-4 rounded-full bg-[#c4a77d] px-3 py-1 text-sm font-semibold text-white">
                @if ($item->harga)
                  Rp {{ number_format($item->harga, 0, ',', '.') }}
                @else
                  💬 Chat WA
                @endif
              </div>
            </div>
            <div class="p-6">
              <h3 class="mb-2 font-serif text-xl font-bold">{{ $item->nama_menu }}</h3>
              <p class="mb-4 text-sm text-gray-500">{{ Str::limit($item->deskripsi, 100) }}</p>

              @if ($item->harga)
                <button class="btn-primary w-full rounded-full py-2 text-sm font-semibold"
                  onclick="addToCart({{ $item->id_menu }})">
                  PESAN SEKARANG
                </button>
              @else
                <a class="flex w-full items-center justify-center gap-2 rounded-full bg-green-600 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                  href="https://wa.me/6282173408747?text={{ urlencode('Halo, saya ingin memesan ' . $item->nama_menu) }}" target="_blank">
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
      fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          id_menu: id,
          jumlah: 1
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          // Panggil updateCartCount dari main.blade.php jika ada
          if (typeof updateCartCount === 'function') {
            updateCartCount();
          }
        } else {
          alert(data.error || 'Terjadi kesalahan.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambahkan ke keranjang');
      });
    }
  </script>
@endpush
