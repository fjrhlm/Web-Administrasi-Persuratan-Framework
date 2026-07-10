@extends('layouts.admin')

@section('title', 'Detail Pengajuan Surat')
@section('page-title', 'Detail Pengajuan Surat')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.kelola-surat.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Surat
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- LEFT Column: Applicant Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Applicant Information --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-admin-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Data Pemohon
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</label>
                        <p class="mt-1 text-sm font-semibold text-gray-800 font-mono">{{ $pengajuan->user->nik ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="mt-1 text-sm font-semibold text-gray-800">{{ $pengajuan->user->name ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</label>
                        <p class="mt-1 text-sm font-semibold text-gray-800">
                            @if($pengajuan->user->no_hp ?? false)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pengajuan->user->no_hp) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-700 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.75.75 0 00.917.918l4.462-1.494A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.387 0-4.592-.832-6.32-2.222l-.44-.362-2.632.88.88-2.632-.362-.44A9.935 9.935 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                    </svg>
                                    {{ $pengajuan->user->no_hp }}
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $pengajuan->jenis_surat }}
                            </span>
                        </p>
                    </div>
                    <div class="sm:col-span-2 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</label>
                        <p class="mt-1 text-sm text-gray-800">{{ $pengajuan->keperluan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Uploaded Documents --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-admin-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                    Dokumen Pendukung
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{ lightbox: null }">
                    {{-- KTP --}}
                    <div class="group relative">
                        <p class="text-xs font-medium text-gray-500 mb-2">Foto KTP</p>
                        @if($pengajuan->file_ktp)
                            <div @click="lightbox = '{{ asset('storage/uploads/' . $pengajuan->file_ktp) }}'"
                                 class="cursor-pointer rounded-xl overflow-hidden border-2 border-gray-100 hover:border-admin-300 transition-all duration-300 aspect-[4/3]">
                                <img src="{{ asset('storage/uploads/' . $pengajuan->file_ktp) }}" alt="Foto KTP"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="rounded-xl border-2 border-dashed border-gray-200 aspect-[4/3] flex items-center justify-center bg-gray-50">
                                <p class="text-xs text-gray-400">Tidak ada file</p>
                            </div>
                        @endif
                    </div>

                    {{-- Pengantar RT/RW --}}
                    <div class="group relative">
                        <p class="text-xs font-medium text-gray-500 mb-2">Pengantar RT/RW</p>
                        @if($pengajuan->file_pengantar)
                            <div @click="lightbox = '{{ asset('storage/uploads/' . $pengajuan->file_pengantar) }}'"
                                 class="cursor-pointer rounded-xl overflow-hidden border-2 border-gray-100 hover:border-admin-300 transition-all duration-300 aspect-[4/3]">
                                <img src="{{ asset('storage/uploads/' . $pengajuan->file_pengantar) }}" alt="Pengantar RT/RW"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="rounded-xl border-2 border-dashed border-gray-200 aspect-[4/3] flex items-center justify-center bg-gray-50">
                                <p class="text-xs text-gray-400">Tidak ada file</p>
                            </div>
                        @endif
                    </div>

                    {{-- Dokumen Tambahan --}}
                    <div class="group relative">
                        <p class="text-xs font-medium text-gray-500 mb-2">Dokumen Tambahan</p>
                        @if($pengajuan->file_tambahan)
                            <div @click="lightbox = '{{ asset('storage/uploads/' . $pengajuan->file_tambahan) }}'"
                                 class="cursor-pointer rounded-xl overflow-hidden border-2 border-gray-100 hover:border-admin-300 transition-all duration-300 aspect-[4/3]">
                                <img src="{{ asset('storage/uploads/' . $pengajuan->file_tambahan) }}" alt="Dokumen Tambahan"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="rounded-xl border-2 border-dashed border-gray-200 aspect-[4/3] flex items-center justify-center bg-gray-50">
                                <p class="text-xs text-gray-400">Tidak ada file</p>
                            </div>
                        @endif
                    </div>

                    {{-- Lightbox Modal --}}
                    <div x-show="lightbox" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="lightbox = null"
                         class="fixed inset-0 z-[60] bg-black/80 flex items-center justify-center p-4 sm:col-span-3">
                        <img :src="lightbox" alt="Preview" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl" @click.stop>
                        <button @click="lightbox = null" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT Column: Status Update --}}
        <div class="space-y-6">
            {{-- Current Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-admin-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Status Surat
                </h3>

                {{-- Current Status Display --}}
                <div class="mb-6">
                    <p class="text-xs text-gray-500 mb-2">Status Saat Ini:</p>
                    @php
                        $statusStyles = [
                            'Menunggu' => 'bg-amber-100 text-amber-800 border-amber-300',
                            'Diproses' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'Selesai' => 'bg-green-100 text-green-800 border-green-300',
                            'Ditolak' => 'bg-red-100 text-red-800 border-red-300',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold border {{ $statusStyles[$pengajuan->status] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
                        {{ $pengajuan->status }}
                    </span>
                </div>

                {{-- Update Form --}}
                <form action="{{ route('admin.kelola-surat.update', $pengajuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        {{-- Status Dropdown --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Ubah Status</label>
                            <select id="status" name="status"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm">
                                <option value="Menunggu" {{ $pengajuan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diproses" {{ $pengajuan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Admin Notes --}}
                        <div>
                            <label for="keterangan_admin" class="block text-sm font-medium text-gray-700 mb-1.5">Catatan Admin</label>
                            <textarea id="keterangan_admin" name="keterangan_admin" rows="4"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm resize-none"
                                      placeholder="Tambahkan catatan...">{{ old('keterangan_admin', $pengajuan->keterangan_admin) }}</textarea>
                            @error('keterangan_admin')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-admin-700 to-admin-800 text-white font-semibold py-2.5 px-4 rounded-xl hover:from-admin-600 hover:to-admin-700 shadow-md hover:shadow-lg transition-all duration-300 text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Print Button (if Selesai) --}}
            @if($pengajuan->status == 'Selesai')
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-500/25">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m0 0a48.497 48.497 0 0110.5 0m-10.5 0V4.875c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125V6.93" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-semibold text-green-800 mb-1">Surat Siap Dicetak</h4>
                        <p class="text-xs text-green-600 mb-4">Surat telah disetujui dan bisa dicetak</p>
                        <a href="{{ route('admin.cetak-surat', $pengajuan->id) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-semibold rounded-xl hover:from-green-400 hover:to-emerald-500 shadow-md hover:shadow-lg transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m0 0a48.497 48.497 0 0110.5 0m-10.5 0V4.875c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125V6.93" />
                            </svg>
                            Cetak Surat
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
