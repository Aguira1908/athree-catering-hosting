@extends('layouts.main')

@section('title', 'Tentang Kami - ATHREE Catering')

@section('content')
<section class="relative py-24 bg-[#1a1a2e]">
    <div class="container mx-auto px-4 text-center text-white">
        <span class="text-[#c4a77d] tracking-wider text-sm">CERITA KAMI</span>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mt-2">Tentang Kami</h1>
        <div class="w-20 h-0.5 bg-[#c4a77d] mx-auto mt-4"></div>
        <p class="text-gray-300 mt-4 max-w-2xl mx-auto">Gairah Untuk Rasa</p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="{{ asset('image/coverberanda.png') }}" alt="Tentang Kami" class="rounded-2xl shadow-lg w-full">
            </div>
            <div>
                <h2 class="text-3xl font-serif font-bold mb-4">Gairah Untuk Rasa</h2>
                <p class="text-gray-600 mb-4">Kami memulai dengan misi sederhana: menciptakan pengalaman bersantap tak terlupakan melalui makanan luar biasa dan keramahtamahan yang hangat.</p>
                <p class="text-gray-600 mb-4">Setiap hidangan dibuat dengan penuh gairah, menggunakan bahan-bahan terbaik untuk menghadirkan cita rasa yang menyenangkan dan menginspirasi.</p>
                <p class="text-gray-600">Dengan lebih dari 15 tahun pengalaman, tim koki ahli kami berdedikasi untuk memberikan pengalaman katering terbaik yang mungkin.</p>
            </div>
        </div>
    </div>
</section>
@endsection
