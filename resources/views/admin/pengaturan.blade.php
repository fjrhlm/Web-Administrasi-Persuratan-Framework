@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
<div class="max-w-2xl animate-fade-in-up">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Pengaturan Umum</h2>
        <p class="text-sm text-gray-500 mt-0.5">Konfigurasi data desa untuk keperluan surat-menyurat</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                {{-- Nama Kepala Desa --}}
                <div>
                    <label for="nama_kades" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kepala Desa</label>
                    <input id="nama_kades" type="text" name="nama_kades" value="{{ old('nama_kades', $pengaturan->nama_kades ?? '') }}"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Masukkan nama kepala desa">
                    @error('nama_kades')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label for="nip_kades" class="block text-sm font-medium text-gray-700 mb-1.5">NIP</label>
                    <input id="nip_kades" type="text" name="nip_kades" value="{{ old('nip_kades', $pengaturan->nip_kades ?? '') }}"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Masukkan NIP">
                    @error('nip_kades')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jabatan --}}
                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan</label>
                    <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan', $pengaturan->jabatan ?? 'Kepala Desa') }}"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm"
                           placeholder="Masukkan jabatan">
                    @error('jabatan')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Save Button --}}
                <div class="pt-4 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-admin-700 to-admin-800 text-white text-sm font-semibold rounded-xl hover:from-admin-600 hover:to-admin-700 shadow-md hover:shadow-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
