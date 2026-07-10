<x-guest-layout>
    <div class="w-full sm:max-w-md animate-fade-in-up">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">Verifikasi Email Anda</h1>
            <p class="text-white/60 text-sm font-light">Desa Babakanmulya</p>
        </div>

        {{-- Glass Card --}}
        <div class="glass-card rounded-2xl p-8 text-center" style="background-color: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div class="mb-6">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center">
                    <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z" />
                    </svg>
                </div>
                <p class="text-white/70 text-sm leading-relaxed">
                    Terima kasih telah mendaftar! Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang baru.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-3 rounded-xl bg-green-500/20 border border-green-500/30 text-green-300 text-sm">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-gradient w-full sm:w-auto text-center text-sm">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-white/50 hover:text-white transition-colors duration-200 underline underline-offset-4">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-white/30 text-xs mt-8">&copy; {{ date('Y') }} Desa Babakanmulya. All rights reserved.</p>
    </div>
</x-guest-layout>
