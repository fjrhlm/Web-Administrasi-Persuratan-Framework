@extends('layouts.warga')

@section('title', 'Riwayat Pengajuan Surat')

@section('content')
<div class="animate-fade-in-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Pengajuan</h2>
            <p class="text-gray-600 text-sm mt-1">Daftar semua surat yang pernah Anda ajukan</p>
        </div>
        <a href="{{ route('warga.pengajuan.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-xl shadow-sm transition-colors duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Ajukan Surat Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan Admin</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pengajuans as $index => $pengajuan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->translatedFormat('d M Y') }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $pengajuan->jenis_surat }}</td>
                            <td class="py-4 px-6 text-sm text-gray-600 max-w-xs truncate">{{ $pengajuan->keperluan }}</td>
                            <td class="py-4 px-6">
                                @php
                                    $statusColor = match($pengajuan->status) {
                                        'Menunggu' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'Diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusColor }}">
                                    {{ $pengajuan->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600 italic">
                                {{ $pengajuan->keterangan_admin ?: '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('warga.pengajuan.show', $pengajuan->id) }}"
                                   class="inline-flex items-center gap-1 text-xs text-emerald-600 hover:text-emerald-800 font-medium transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 0l3 3m-3-3l-3 3M8.25 6v12m6-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a2.25 2.25 0 002.25-2.25V6.75m0 8.25v-4.5m0 4.5h-2.25m2.25 0v2.25M12 18.75v-1.5m0 1.5H9m3 0h3" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada riwayat pengajuan surat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pengajuans->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
