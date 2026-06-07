<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ATHREE Catering - Premium Catering Service')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        h1, h2, h3, h4, .font-serif { font-family: 'Playfair Display', serif; }
        body { background: #faf8f5; color: #2c2c2c; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #e8e0d5; }
        ::-webkit-scrollbar-thumb { background: #c4a77d; border-radius: 4px; }

        .hero-section { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); }
        .card-hover { transition: all 0.4s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

        .btn-primary { background: #c4a77d; color: white; transition: all 0.3s ease; }
        .btn-primary:hover { background: #a88b62; transform: translateY(-2px); }

        .btn-outline { border: 2px solid #c4a77d; color: #c4a77d; transition: all 0.3s ease; }
        .btn-outline:hover { background: #c4a77d; color: white; }

        .stat-number { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 700; color: #c4a77d; }

        .section-title { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 700; position: relative; display: inline-block; }
        .section-title:after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background: #c4a77d; }

        .menu-card { background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .menu-card:hover { box-shadow: 0 15px 40px rgba(0,0,0,0.1); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeInUp 0.8s ease-out; }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #c4a77d;
            color: white;
            font-size: 10px;
            font-weight: bold;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .cart-icon {
            position: relative;
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.02);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 100;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 10px 16px;
            color: #4a4a4a;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
            color: #c4a77d;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e5e5;
            margin: 4px 0;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 shadow-sm py-4 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <i class="fas fa-utensils text-2xl text-[#c4a77d]"></i>
                    <span class="text-2xl font-serif font-bold text-[#2c2c2c]">ATHREE CATERING</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">BERANDA</a>
                    <a href="{{ route('about') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">TENTANG KAMI</a>
                    <a href="{{ route('menu.index') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">MENU</a>
                    <a href="{{ route('gallery') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">GALERI</a>
                    <a href="{{ route('contact') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">KONTAK</a>
                </div>

                <!-- Auth Buttons & Cart -->
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Cart Icon -->
                    <a href="{{ route('cart') }}" class="cart-icon text-[#4a4a4a] hover:text-[#c4a77d] transition relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-badge" id="cartCount">0</span>
                    </a>

                    @auth('customer')
                        <!-- Dropdown dengan toggle click -->
                        <div class="relative" id="userDropdownContainer">
                            <button id="userDropdownBtn" class="flex items-center space-x-2 focus:outline-none">
                                <i class="fas fa-user-circle text-2xl text-[#c4a77d]"></i>
                                <span class="text-[#4a4a4a]">{{ Auth::guard('customer')->user()->nama }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" id="dropdownChevron"></i>
                            </button>

                            <div id="userDropdownMenu" class="dropdown-menu">
                                <a href="{{ route('customer.dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt w-5 mr-2 text-gray-400"></i> Dashboard
                                </a>
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="fas fa-user w-5 mr-2 text-gray-400"></i> Profil
                                </a>
                                <a href="{{ route('cart') }}" class="dropdown-item">
                                    <i class="fas fa-shopping-cart w-5 mr-2 text-gray-400"></i> Keranjang
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left">
                                        <i class="fas fa-sign-out-alt w-5 mr-2 text-red-400"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-[#4a4a4a] hover:text-[#c4a77d] transition">LOGIN</a>
                        <a href="{{ route('register') }}" class="btn-primary px-5 py-2 rounded-full text-sm">DAFTAR</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-[#4a4a4a]" id="mobileMenuBtn">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white border-t" id="mobileMenu">
            <div class="container mx-auto px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block py-2 text-[#4a4a4a]">BERANDA</a>
                <a href="{{ route('about') }}" class="block py-2 text-[#4a4a4a]">TENTANG KAMI</a>
                <a href="{{ route('menu.index') }}" class="block py-2 text-[#4a4a4a]">MENU</a>
                <a href="{{ route('gallery') }}" class="block py-2 text-[#4a4a4a]">GALERI</a>
                <a href="{{ route('contact') }}" class="block py-2 text-[#4a4a4a]">KONTAK</a>
                <a href="{{ route('cart') }}" class="block py-2 text-[#4a4a4a]">
                    <i class="fas fa-shopping-cart mr-2"></i> Keranjang
                    <span id="mobileCartCount" class="text-[#c4a77d]">(0)</span>
                </a>
                <hr>
                @auth('customer')
                    <a href="{{ route('customer.dashboard') }}" class="block py-2 text-[#4a4a4a]">Dashboard</a>
                    <a href="{{ route('profile') }}" class="block py-2 text-[#4a4a4a]">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-red-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-[#4a4a4a]">LOGIN</a>
                    <a href="{{ route('register') }}" class="block py-2 text-[#c4a77d]">DAFTAR</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#1a1a2e] text-white py-16 mt-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-utensils text-2xl text-[#c4a77d]"></i>
                        <span class="text-2xl font-serif font-bold">ATHREE</span>
                    </div>
                    <p class="text-gray-400 text-sm">Nikmati cita rasa kaya, suasana hangat, dan momen tak terlupakan dalam setiap gigitan.</p>
                </div>
                <div>
                    <h4 class="font-serif text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-[#c4a77d]">Tentang Kami</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-[#c4a77d]">Menu Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#c4a77d]">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif text-lg mb-4">Info Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-map-marker-alt w-5 text-[#c4a77d]"></i> Medan, Sumatera Utara</li>
                        <li><i class="fas fa-phone w-5 text-[#c4a77d]"></i> +62 813 6283 7973</li>
                        <li><i class="fas fa-envelope w-5 text-[#c4a77d]"></i> info@athree.com</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif text-lg mb-4">Jam Operasional</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>Senin - Sabtu: 09:00 - 21:00</li>
                        <li>Minggu: Libur</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; 2025 ATHREE Catering. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });

        // =============================================
        // DROPDOWN MENU DENGAN CLICK (BUKAN HOVER)
        // =============================================
        const dropdownBtn = document.getElementById('userDropdownBtn');
        const dropdownMenu = document.getElementById('userDropdownMenu');
        const dropdownChevron = document.getElementById('dropdownChevron');

        if (dropdownBtn && dropdownMenu) {
            // Toggle dropdown saat tombol diklik
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
                if (dropdownChevron) {
                    dropdownChevron.style.transform = dropdownMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                    if (dropdownChevron) {
                        dropdownChevron.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }

        // Update cart count function
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.getElementById('cartCount');
                    const mobileCartCount = document.getElementById('mobileCartCount');
                    if (cartCount) cartCount.textContent = data.count;
                    if (mobileCartCount) mobileCartCount.innerHTML = '(' + data.count + ')';
                })
                .catch(error => console.log('Error fetching cart count:', error));
        }

        // Call updateCartCount on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>
    @stack('scripts')
</body>
</html>
