<x-layouts.auth title="Login">
    <h2 class="text-2xl font-bold text-secondary-900 text-center mb-2">Selamat Datang</h2>
    <p class="text-secondary-500 text-center mb-6">Masuk ke akun Anda</p>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-form.input 
            label="Email"
            name="email"
            type="email"
            placeholder="nama@email.com"
            :required="true"
        />

        <x-form.input 
            label="Password"
            name="password"
            type="password"
            placeholder="••••••••"
            :required="true"
        />

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500">
                <span class="text-secondary-600">Ingat saya</span>
            </label>
        </div>

        <x-button type="submit" class="w-full">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk
        </x-button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-secondary-500">
            Hubungi admin jika lupa password
        </p>
    </div>
</x-layouts.auth>
