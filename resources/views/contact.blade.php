@extends('layouts.main')

@section('title', 'Kontak - ATHREE Catering')

@section('content')
<section class="relative py-24 bg-[#1a1a2e]">
    <div class="container mx-auto px-4 text-center text-white">
        <span class="text-[#c4a77d] tracking-wider text-sm">KONTAK</span>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mt-2">Hubungi Kami</h1>
        <div class="w-20 h-0.5 bg-[#c4a77d] mx-auto mt-4"></div>
        <p class="text-gray-300 mt-4 max-w-2xl mx-auto">Kami dengan senang hati mendengar dari Anda</p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-2xl font-serif font-bold mb-6">Informasi Kontak</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <i class="fas fa-map-marker-alt text-2xl text-[#c4a77d]"></i>
                        <div>
                            <h4 class="font-semibold">Alamat</h4>
                            <p class="text-gray-600">Jl. Setia Budi Pasar 1 Tanjung Sari Gg.Mekar Mulyo, Medan, Sumatera Utara, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-phone text-2xl text-[#c4a77d]"></i>
                        <div>
                            <h4 class="font-semibold">Telepon</h4>
                            <p class="text-gray-600">+62 813 6283 7973</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-envelope text-2xl text-[#c4a77d]"></i>
                        <div>
                            <h4 class="font-semibold">Email</h4>
                            <p class="text-gray-600">info@athree.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fas fa-clock text-2xl text-[#c4a77d]"></i>
                        <div>
                            <h4 class="font-semibold">Jam Operasional</h4>
                            <p class="text-gray-600">Senin - Sabtu: 09:00 - 21:00</p>
                            <p class="text-gray-600">Minggu: Libur</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Nama Anda" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                        <input type="email" name="email" placeholder="Email Anda" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                    </div>
                    <input type="text" name="subject" placeholder="Subjek" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]">
                    <textarea name="message" rows="5" placeholder="Pesan Anda" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#c4a77d]"></textarea>
                    <button type="submit" class="btn-primary px-8 py-3 rounded-lg font-semibold">Kirim Pesan</button>
                </form>
            </div>
        </div>
         <!-- Google Maps -->
        <div class="mt-16">
            <h2 class="text-2xl font-serif font-bold mb-6 text-center">Lokasi Kami</h2>
            <div class="rounded-2xl overflow-hidden shadow-lg h-96">
                <iframe
                    src="https://maps.app.goo.gl/N6vxmwwQXzjJWvkM7"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
            <p class="text-center text-gray-500 text-sm mt-3">
                <i class="fas fa-map-marker-alt text-[#c4a77d] mr-1"></i>
                Jl. Raya No. 123, Medan, Sumatera Utara, Indonesia
            </p>
        </div>
    </div>
</section>
@endsection
