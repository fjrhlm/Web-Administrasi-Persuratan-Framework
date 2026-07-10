@extends('layouts.warga')

@section('title', 'Dashboard Warga')

@section('content')
<div class="animate-fade-in-up">
    {{-- Welcome Message --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600 mt-1">NIK: {{ Auth::user()->nik }}</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Pengajuan Aktif --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Pengajuan Aktif</p>
                    <h3 class="text-3xl font-bold">{{ $activePengajuan }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <a href="{{ route('warga.pengajuan.index') }}" class="text-sm text-emerald-50 hover:text-white flex items-center gap-1 transition-colors">
                    Lihat detail
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Surat Selesai --}}
        <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium mb-1">Surat Selesai</p>
                    <h3 class="text-3xl font-bold">{{ $completedSurat }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <a href="{{ route('warga.pengajuan.index') }}" class="text-sm text-teal-50 hover:text-white flex items-center gap-1 transition-colors">
                    Lihat detail
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('warga.pengajuan.create') }}" class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <div>
                <h4 class="font-medium text-gray-800 group-hover:text-emerald-700 transition-colors">Ajukan Surat Baru</h4>
                <p class="text-sm text-gray-500 mt-0.5">Buat pengajuan surat SKTM, SKU, dll</p>
            </div>
        </a>

        <a href="{{ route('warga.pengajuan.index') }}" class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <h4 class="font-medium text-gray-800 group-hover:text-teal-700 transition-colors">Lihat Riwayat</h4>
                <p class="text-sm text-gray-500 mt-0.5">Cek status pengajuan surat Anda</p>
            </div>
        </a>
    </div>
</div>
@endsection
