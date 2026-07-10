<x-guest-layout>
    <div class="w-full sm:max-w-2xl animate-fade-in-up">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">Pendaftaran Warga Baru</h1>
            <p class="text-white/60 text-sm font-light">Desa Babakanmulya — Kecamatan Cigugur</p>
        </div>

        {{-- Glass Card --}}
        <div class="glass-card rounded-2xl p-8" style="background-color: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-white/80 mb-2">NIK <span class="text-red-400">*</span></label>
                        <input id="nik" type="text" name="nik" value="{{ old('nik') }}"
                               class="input-glass" placeholder="16 digit NIK" pattern="\d{16}" maxlength="16"
                               required>
                        @error('nik')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-white/80 mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               class="input-glass" placeholder="Nama sesuai KTP"
                               required autofocus>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email <span class="text-red-400">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="input-glass" placeholder="contoh@email.com"
                               required>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-white/80 mb-2">Tempat, Tanggal Lahir</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                   class="input-glass" placeholder="Tempat lahir">
                            <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                   class="input-glass">
                        </div>
                        @error('tempat_lahir')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        @error('tanggal_lahir')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pekerjaan --}}
                    <div>
                        <label for="pekerjaan" class="block text-sm font-medium text-white/80 mb-2">Pekerjaan</label>
                        <input id="pekerjaan" type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                               class="input-glass" placeholder="Pekerjaan saat ini">
                        @error('pekerjaan')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label for="agama" class="block text-sm font-medium text-white/80 mb-2">Agama</label>
                        <select id="agama" name="agama" class="input-glass">
                            <option value="" class="bg-gray-800">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }} class="bg-gray-800">Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }} class="bg-gray-800">Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }} class="bg-gray-800">Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }} class="bg-gray-800">Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }} class="bg-gray-800">Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }} class="bg-gray-800">Konghucu</option>
                        </select>
                        @error('agama')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-white/80 mb-2">No. HP</label>
                        <input id="no_hp" type="tel" name="no_hp" value="{{ old('no_hp') }}"
                               class="input-glass" placeholder="08xxxxxxxxxx">
                        @error('no_hp')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-white/80 mb-2">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="input-glass">
                            <option value="" class="bg-gray-800">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }} class="bg-gray-800">Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }} class="bg-gray-800">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-white/80 mb-2">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="input-glass resize-none" placeholder="RT/RW, Dusun, Desa, Kecamatan, Kabupaten">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-white/80 mb-2">Password <span class="text-red-400">*</span></label>
                        <input id="password" type="password" name="password"
                               class="input-glass" placeholder="Minimal 8 karakter"
                               required autocomplete="new-password">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white/80 mb-2">Konfirmasi Password <span class="text-red-400">*</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="input-glass" placeholder="Ulangi password"
                               required autocomplete="new-password">
                        @error('password_confirmation')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Register Button --}}
                <div class="mt-8">
                    <button type="submit" class="btn-gradient w-full text-center">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            {{-- Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-white/50">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-white font-medium hover:text-indigo-300 transition-colors duration-200">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-white/30 text-xs mt-8">&copy; {{ date('Y') }} Desa Babakanmulya. All rights reserved.</p>
    </div>
</x-guest-layout>
