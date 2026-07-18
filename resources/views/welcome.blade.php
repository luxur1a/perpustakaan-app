<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">
    <main class="flex-grow flex items-center justify-center">
        <div class="text-center px-6">
            <x-application-logo class="w-32 h-32 mx-auto text-indigo-600 mb-8" />
            <h1 class="text-4xl font-bold mb-4">Sistem Informasi Perpustakaan</h1>
            <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">Kelola data buku, anggota, dan peminjaman dengan mudah dan efisien.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-medium rounded-lg border border-indigo-600 hover:bg-indigo-50 transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </main>
    <footer class="py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'Perpustakaan') }}. All rights reserved.
    </footer>
</body>
</html>
