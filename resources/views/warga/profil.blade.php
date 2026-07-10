@extends('layouts.warga')

@section('title', 'Profil Warga')

@section('content')
<div class="animate-fade-in-up">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Profil Saya</h2>
        <p class="text-gray-600 text-sm mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>

    @if (session('status') === 'password-updated')
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Password berhasil diperbarui!
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Profile Info Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $user->nik }}</p>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Akun Warga Terverifikasi
                </span>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">Detail Informasi</h4>
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-gray-500 mb-1">Email</dt>
                        <dd class="font-medium text-gray-800">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 mb-1">No. HP</dt>
                        <dd class="font-medium text-gray-800">{{ $user->no_hp ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 mb-1">Tempat, Tanggal Lahir</dt>
                        <dd class="font-medium text-gray-800">{{ $user->tempat_tgl_lahir ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 mb-1">Agama</dt>
                        <dd class="font-medium text-gray-800">{{ $user->agama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 mb-1">Pekerjaan</dt>
                        <dd class="font-medium text-gray-800">{{ $user->pekerjaan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 mb-1">Alamat</dt>
                        <dd class="font-medium text-gray-800">{{ $user->alamat ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Right: Update Password Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Ubah Password</h3>
                    <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                </div>

                <form method="POST" action="{{ route('warga.profil.password') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                        <input id="current_password" type="password" name="current_password" 
                               class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm shadow-sm">
                        @error('current_password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input id="password" type="password" name="password" 
                               class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm shadow-sm">
                        @error('password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" 
                               class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm shadow-sm">
                        @error('password_confirmation', 'updatePassword')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition-colors duration-200">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
