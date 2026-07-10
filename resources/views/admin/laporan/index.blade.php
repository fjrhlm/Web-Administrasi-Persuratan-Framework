@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan Surat')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Laporan Surat Selesai</h2>
            <p class="text-sm text-gray-500 mt-0.5">Rekap surat yang telah selesai diproses</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1.5">Bulan</label>
                <select id="bulan" name="bulan" class="rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (request('bulan', now()->month) == $i) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, $i)->locale('id')->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun</label>
                <select id="tahun" name="tahun" class="rounded-xl border-gray-300 shadow-sm focus:border-admin-500 focus:ring-admin-500 text-sm">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ (request('tahun', now()->year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-800 text-white text-sm font-medium rounded-xl hover:bg-admin-700 shadow-md transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                Filter
            </button>
            <a href="{{ route('admin.cetak-laporan', ['bulan' => request('bulan', now()->month), 'tahun' => request('tahun', now()->year)]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 shadow-md transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m0 0a48.497 48.497 0 0110.5 0m-10.5 0V4.875c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125V6.93" />
                </svg>
                Cetak Laporan
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($pengajuans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100">
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Jenis Surat</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Keperluan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pengajuans as $index => $pengajuan)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-gray-700 font-mono text-xs">{{ $pengajuan->user->nik ?? '-' }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $pengajuan->user->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700">
                                        {{ $pengajuan->jenis_surat }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-xs max-w-xs truncate">{{ $pengajuan->keperluan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <p class="text-sm text-gray-600">
                    Total Surat Selesai: <span class="font-bold text-gray-800">{{ $pengajuans->count() }}</span> surat
                </p>
            </div>
        @else
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Tidak Ada Data</h3>
                <p class="text-sm text-gray-500">Tidak ada surat selesai untuk periode yang dipilih.</p>
            </div>
        @endif
    </div>
</div>
@endsection
