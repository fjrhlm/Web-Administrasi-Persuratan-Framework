@extends('layouts.admin')

@section('title', 'Kelola Surat')
@section('page-title', 'Kelola Surat')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Header & Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Pengajuan Surat</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua pengajuan surat dari warga</p>
        </div>
    </div>

    {{-- Filter Buttons --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.kelola-surat.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
           {{ !request('status') ? 'bg-admin-800 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.kelola-surat.index', ['status' => 'Menunggu']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
           {{ request('status') == 'Menunggu' ? 'bg-amber-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Menunggu
        </a>
        <a href="{{ route('admin.kelola-surat.index', ['status' => 'Diproses']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
           {{ request('status') == 'Diproses' ? 'bg-blue-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Diproses
        </a>
        <a href="{{ route('admin.kelola-surat.index', ['status' => 'Selesai']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
           {{ request('status') == 'Selesai' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Selesai
        </a>
        <a href="{{ route('admin.kelola-surat.index', ['status' => 'Ditolak']) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
           {{ request('status') == 'Ditolak' ? 'bg-red-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Ditolak
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($pengajuans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100">
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama Pemohon</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Jenis Surat</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pengajuans as $index => $pengajuan)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-500 font-medium">{{ $pengajuans->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-gray-700 font-mono text-xs">{{ $pengajuan->user->nik ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $pengajuan->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700">
                                        {{ $pengajuan->jenis_surat }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'Menunggu' => ['bg-amber-50 text-amber-700 border-amber-200', 'Menunggu'],
                                            'Diproses' => ['bg-blue-50 text-blue-700 border-blue-200', 'Diproses'],
                                            'Selesai' => ['bg-green-50 text-green-700 border-green-200', 'Selesai'],
                                            'Ditolak' => ['bg-red-50 text-red-700 border-red-200', 'Ditolak'],
                                        ];
                                        $config = $statusConfig[$pengajuan->status] ?? ['bg-gray-50 text-gray-700 border-gray-200', $pengajuan->status];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $config[0] }}">
                                        {{ $config[1] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.kelola-surat.show', $pengajuan->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-admin-800 text-white text-xs font-medium rounded-lg hover:bg-admin-700 transition-colors duration-200 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pengajuans->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pengajuans->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Pengajuan Surat</h3>
                <p class="text-sm text-gray-500">Data pengajuan surat akan muncul di sini setelah warga mengajukan surat.</p>
            </div>
        @endif
    </div>

</div>
@endsection
