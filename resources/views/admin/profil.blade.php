@extends('layouts.admin')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-2xl space-y-6 animate-fade-in-up">
    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="flex items-center gap-5 mb-6 pb-6 border-b border-gray-100">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-admin-700 to-admin-900 flex items-center justify-center shadow-lg shadow-admin-800/20">
                <span class="text-white text-2xl font-bold">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</h3>
                <p class="text-sm text-gray-500">{{ Auth::user()->username ?? Auth::user()->email ?? '-' }}</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-admin-100 text-admin-700 mt-1">Administrator</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</label>
                <p class="mt-1 text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? '-' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Username</label>
                <p class="mt-1 text-sm font-semibold text-gray-800">{{ Auth::user()->username ?? Auth::user()->email ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-admin-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            Ganti Password
        </h3>

        <form action="{{ route('admin.profil.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Lama</label>
                    <input id="current_password" type="password" name="current_password"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Masukkan password lama">
                    @error('current_password')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <input id="password" type="password" name="password"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Masukkan password baru">
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Ulangi password baru">
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-admin-700 to-admin-800 text-white text-sm font-semibold rounded-xl hover:from-admin-600 hover:to-admin-700 shadow-md hover:shadow-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
