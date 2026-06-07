<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ATHREE Catering</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-black">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-black text-2xl"></i>
                    </div>
                </a>
                <h1 class="text-2xl font-bold text-white">Login Customer</h1>
                <p class="text-gray-500 mt-2">Masuk ke akun Anda</p>
            </div>

            <div class="bg-black/50 border border-gray-800 rounded-xl p-8 backdrop-blur-sm">
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6">
                        @foreach($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-300 mb-2 text-sm">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-gray-500 transition" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-300 mb-2 text-sm">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-gray-500 transition" required>
                    </div>

                    <button type="submit" class="w-full py-3 bg-white text-black rounded-lg font-semibold hover:bg-gray-200 transition">
                        Login
                    </button>
                </form>

                <p class="text-center text-gray-500 mt-6 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-white hover:underline">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
