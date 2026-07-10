<x-guest-layout>
    <div class="w-full sm:max-w-md animate-fade-in-up">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">Layanan Persuratan Digital</h1>
            <p class="text-white/60 text-sm font-light">Desa Babakanmulya</p>
        </div>

        {{-- Glass Card --}}
        <div class="glass-card rounded-2xl p-8" style="background-color: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-green-500/20 border border-green-500/30 text-green-300 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- NIK / Username / Email --}}
                <div class="mb-5">
                    <label for="login" class="block text-sm font-medium text-white/80 mb-2">Email / NIK / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input id="login" type="text" name="login" value="{{ old('login') }}"
                               class="input-glass pl-12" placeholder="Masukkan Email, NIK, atau Username"
                               required autofocus autocomplete="username">
                    </div>
                    @error('login')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-white/80 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               class="input-glass pl-12" placeholder="Masukkan password"
                               required autocomplete="current-password">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-white/30 bg-white/10 text-indigo-500 shadow-sm focus:ring-indigo-500/50 focus:ring-offset-0">
                        <span class="ms-2 text-sm text-white/60">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-white/60 hover:text-white transition-colors duration-200" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Login Button --}}
                <button type="submit" class="btn-gradient w-full text-center">
                    Masuk
                </button>
            </form>

            {{-- Register Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-white/50">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-white font-medium hover:text-indigo-300 transition-colors duration-200">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-white/30 text-xs mt-8">&copy; {{ date('Y') }} Desa Babakanmulya. All rights reserved.</p>
    </div>
</x-guest-layout>
