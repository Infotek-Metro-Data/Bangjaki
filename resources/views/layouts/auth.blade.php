<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} - BangJaki</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">BangJaki</h1>
            <p class="text-primary-100 mt-1">Sistem Manajemen Iuran Sampah</p>
        </div>

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6 md:p-8 animate-slide-up">
            {{ $slot }}
        </div>

        <p class="mt-8 text-sm text-primary-100">
            &copy; {{ date('Y') }} BangJaki. All rights reserved.
        </p>
    </div>
</body>
</html>
