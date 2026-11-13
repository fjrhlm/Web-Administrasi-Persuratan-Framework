@extends('layouts.warga')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Surat')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('warga.pengajuan.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Riwayat Surat
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Pengajuan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-5">Informasi Pengajuan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50">
                        <label class="text-xs font-medium text-gray-500 uppercase">Jenis Surat</label>
                        <p class="mt-1 text-sm font-semibold text-gray-800">{{ $pengajuan->jenis_surat }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50">
                        <label class="text-xs font-medium text-gray-500 uppercase">Tanggal Pengajuan</label>
                        <p class="mt-1 text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 sm:col-span-2">
                        <label class="text-xs font-medium text-gray-500 uppercase">Keperluan</label>
                        <p class="mt-1 text-sm text-gray-800">{{ $pengajuan->keperluan }}</p>
                    </div>
                </div>
            </div>

            {{-- Berkas Dokumen --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-5">Berkas yang Diunggah</h3>
                <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 mb-4">
                    🔒 Berkas dilindungi — hanya Anda dan admin yang dapat melihatnya.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['label' => 'KTP', 'type' => 'ktp', 'file' => $pengajuan->file_ktp],
                        ['label' => 'Kartu Keluarga', 'type' => 'kk', 'file' => $pengajuan->file_kk],
                        ['label' => 'Surat Pengantar RT/RW', 'type' => 'pengantar', 'file' => $pengajuan->file_pengantar],
                        ['label' => 'Dokumen Tambahan', 'type' => 'tambahan', 'file' => $pengajuan->file_tambahan],
                    ] as $berkas)
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-2">{{ $berkas['label'] }}</p>
                            @if($berkas['file'])
                                <a href="{{ route('berkas.serve', ['id' => $pengajuan->id, 'type' => $berkas['type']]) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-3 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium hover:bg-emerald-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lihat Berkas
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">Tidak ada</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status & Catatan Admin --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pengajuan</h3>
                @php
                    $statusConfig = match($pengajuan->status) {
                        'Menunggu' => ['color' => 'bg-amber-100 text-amber-700 border-amber-200', 'icon' => '⏳'],
                        'Diproses' => ['color' => 'bg-blue-100 text-blue-700 border-blue-200',   'icon' => '🔄'],
                        'Selesai'  => ['color' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'icon' => '✅'],
                        'Ditolak'  => ['color' => 'bg-red-100 text-red-700 border-red-200',      'icon' => '❌'],
                        default    => ['color' => 'bg-gray-100 text-gray-700 border-gray-200',   'icon' => '📋'],
                    };
                @endphp
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border {{ $statusConfig['color'] }}">
                    {{ $statusConfig['icon'] }} {{ $pengajuan->status }}
                </span>

                @if($pengajuan->keterangan_admin)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <p class="text-xs font-semibold text-blue-600 mb-1">📝 Catatan dari Admin:</p>
                        <p class="text-sm text-gray-700">{{ $pengajuan->keterangan_admin }}</p>
                    </div>
                @endif

                @if($pengajuan->status === 'Selesai')
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-2">Surat Anda sudah siap. Silakan hubungi kantor desa untuk pengambilan.</p>
                    </div>
                @elseif($pengajuan->status === 'Ditolak')
                    <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-xl">
                        <p class="text-xs text-red-600">Pengajuan ditolak. Silakan buat pengajuan baru dengan melengkapi dokumen yang diperlukan.</p>
                    </div>
                @endif
            </div>

            {{-- Timeline Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Alur Proses</h3>
                @php
                    $steps = ['Menunggu', 'Diproses', 'Selesai'];
                    $currentIndex = array_search($pengajuan->status, $steps);
                    $isRejected = $pengajuan->status === 'Ditolak';
                @endphp
                <div class="space-y-3">
                    @foreach($steps as $i => $step)
                        @php
                            $done   = $currentIndex !== false && $i <= $currentIndex;
                            $active = $currentIndex !== false && $i === $currentIndex;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                                {{ $done ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                {{ $done ? '✓' : ($i + 1) }}
                            </div>
                            <span class="text-sm {{ $active ? 'font-semibold text-gray-800' : 'text-gray-500' }}">
                                {{ $step }}
                            </span>
                        </div>
                    @endforeach
                    @if($isRejected)
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 bg-red-500 text-white">✗</div>
                            <span class="text-sm font-semibold text-red-600">Ditolak</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
