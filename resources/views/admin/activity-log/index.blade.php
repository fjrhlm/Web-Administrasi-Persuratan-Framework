@extends('layouts.admin')

@section('title', 'Activity Log')
@section('page-title', 'Activity Log & Audit Trail')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Audit Trail</h2>
            <p class="text-gray-500 text-sm mt-1">Riwayat seluruh aktivitas keamanan pada sistem</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-xl">
            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            <span class="text-sm font-medium text-amber-700">Total: {{ $logs->total() }} log</span>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <select name="aksi"
                    class="flex-1 px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-admin-500 focus:border-admin-500 bg-gray-50">
                <option value="">Semua Jenis Aksi</option>
                @foreach($jenisAksi as $jenis)
                    <option value="{{ $jenis }}" {{ request('aksi') === $jenis ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $jenis)) }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari keterangan / IP Address..."
                   class="flex-[2] px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-admin-500 focus:border-admin-500 bg-gray-50">
            <button type="submit"
                    class="px-5 py-2 bg-admin-700 text-white rounded-xl text-sm font-medium hover:bg-admin-600 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['aksi', 'search']))
                <a href="{{ route('admin.activity-log.index') }}"
                   class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Log Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ in_array($log->aksi, ['login_gagal', 'akses_ditolak']) ? 'bg-red-50/30' : '' }}">
                            <td class="py-3 px-4 text-xs text-gray-500 whitespace-nowrap font-mono">
                                {{ $log->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $log->badge_color }}">
                                    {{ $log->icon }} {{ ucfirst(str_replace('_', ' ', $log->aksi)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                @if($log->user)
                                    <div class="font-medium">{{ $log->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ ucfirst($log->user->role) }}</div>
                                @else
                                    <span class="text-gray-400 italic text-xs">Tamu / Tidak diketahui</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600 max-w-md">
                                {{ $log->keterangan }}
                            </td>
                            <td class="py-3 px-4 text-xs text-gray-500 font-mono">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                                    </svg>
                                    <p class="text-sm">Belum ada log aktivitas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-4 py-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
