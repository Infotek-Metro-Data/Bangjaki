<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - BangJaki</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .input-glow:focus-within {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.3);
            border-color: #F97316;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex items-center justify-center p-4">

    <div
        class="w-full max-w-[800px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row relative z-10 border border-gray-100">

        <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center relative z-20 bg-white">
            <div class="flex items-center justify-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="BangJaki Logo" class="h-32 w-auto object-contain">
            </div>

            <div class="w-full">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-900 mb-2">
                        Masuk Akun<span class="text-orange-500">.</span>
                    </h1>

                    @if (session('error'))
                        <div
                            class="mt-4 p-3 rounded-lg bg-red-50 text-red-600 text-xs flex items-center gap-2 border border-red-100">
                            <span class="material-icons-outlined text-sm">error_outline</span>
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <form action="{{ route('login') }}" class="space-y-4" method="POST">
                    @csrf

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 ml-1" for="email">Email Address</label>
                        <div
                            class="relative group input-glow rounded-xl transition-all duration-200 bg-gray-50 border border-gray-100">
                            <input
                                class="w-full bg-transparent text-gray-900 border-none rounded-xl py-2.5 px-4 pl-4 pr-10 focus:ring-0 placeholder-gray-400 text-sm transition-colors"
                                id="email" name="email" placeholder="nama@email.com" type="email"
                                value="{{ old('email') }}" required autofocus />
                            <span
                                class="material-icons-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-lg">email</span>
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-xs font-medium text-gray-500" for="password">Password</label>
                            <a class="text-xs text-orange-500 hover:text-orange-600 font-medium" href="#">Lupa
                                Password?</a>
                        </div>
                        <div
                            class="relative group input-glow rounded-xl transition-all duration-200 bg-gray-50 border border-gray-100">
                            <input
                                class="w-full bg-transparent text-gray-900 border-none rounded-xl py-2.5 px-4 pl-4 pr-10 focus:ring-0 placeholder-gray-400 text-sm"
                                id="password" name="password" placeholder="••••••••" type="password" required />
                            <button
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 focus:outline-none transition-colors"
                                type="button" onclick="togglePassword()">
                                <span class="material-icons-outlined text-lg" id="eyeIcon">visibility_off</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center ml-1">
                        <input id="remember" name="remember" type="checkbox"
                            class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                        <label for="remember" class="ml-2 block text-xs text-gray-500">Ingat saya</label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button
                            class="px-4 py-2.5 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition-all w-full text-sm flex items-center justify-center gap-2 group"
                            type="submit">
                            Masuk
                            <span
                                class="material-icons-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden md:block w-1/2 relative bg-slate-900 overflow-hidden">
            <img alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-50"
                src="{{ asset('images/home.jpeg') }}" />
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/60 via-transparent to-slate-900/60"></div>

            <svg class="absolute top-0 left-0 h-full w-auto text-white transform -translate-x-1/2 scale-y-110"
                preserveAspectRatio="none" viewBox="0 0 100 100">
                <path d="M0 0 C 40 10 60 30 50 50 C 40 70 60 90 0 100 Z" fill="currentColor"></path>
            </svg>

            <svg class="absolute top-0 left-0 h-full w-full pointer-events-none opacity-20" style="left: -10%;">
                <path d="M150 0 Q 250 300 150 800" fill="none" stroke="white" stroke-dasharray="10,10"
                    stroke-width="2"></path>
            </svg>

            <div class="absolute bottom-10 right-10 z-20">
                <div class="text-white text-4xl font-black tracking-tighter opacity-90 flex items-center">
                    <span>BangJaki</span>
                    <div class="w-2 h-2 bg-orange-500 rounded-full ml-1 mt-3 shadow-lg shadow-orange-500/50"></div>
                </div>
                <p class="text-orange-200/60 mt-1 text-right text-xs tracking-wide">SISTEM IURAN SAMPAH</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.innerText = 'visibility';
            } else {
                password.type = 'password';
                eyeIcon.innerText = 'visibility_off';
            }
        }
    </script>
</body>

</html>
