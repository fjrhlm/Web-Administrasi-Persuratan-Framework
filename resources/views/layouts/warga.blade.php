<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - Web Desa Babakanmulya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        {{-- Sidebar Overlay (Mobile) --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"
             @click="sidebarOpen = false">
        </div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-warga-800 to-warga-900 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between h-16 px-5 bg-warga-900/50 border-b border-warga-700/30">
                <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-lg group-hover:shadow-emerald-500/25 transition-shadow duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21" />
                        </svg>
                    </div>
                    <div class="hidden lg:block">
                        <span class="text-sm font-bold leading-tight block">Web Desa</span>
                        <span class="text-[10px] text-warga-300/80 font-medium">Babakanmulya</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-warga-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <p class="px-3 text-[10px] font-semibold text-warga-400/70 uppercase tracking-wider mb-3">Menu Utama</p>

                {{-- Beranda --}}
                <a href="{{ route('warga.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('warga.dashboard') ? 'bg-white/15 text-white shadow-lg shadow-warga-900/20' : 'text-warga-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('warga.dashboard') ? 'text-emerald-300' : 'text-warga-400 group-hover:text-emerald-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Beranda</span>
                </a>

                {{-- Ajukan Surat --}}
                <a href="{{ route('warga.pengajuan.create') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('warga.pengajuan.create') ? 'bg-white/15 text-white shadow-lg shadow-warga-900/20' : 'text-warga-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('warga.pengajuan.create') ? 'text-emerald-300' : 'text-warga-400 group-hover:text-emerald-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Ajukan Surat</span>
                </a>

                {{-- Riwayat Surat --}}
                <a href="{{ route('warga.pengajuan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('warga.pengajuan.index') ? 'bg-white/15 text-white shadow-lg shadow-warga-900/20' : 'text-warga-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('warga.pengajuan.index') ? 'text-emerald-300' : 'text-warga-400 group-hover:text-emerald-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Riwayat Surat</span>
                </a>

                <p class="px-3 text-[10px] font-semibold text-warga-400/70 uppercase tracking-wider mb-3 mt-6">Akun</p>

                {{-- Profil --}}
                <a href="{{ route('warga.profil.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('warga.profil.*') ? 'bg-white/15 text-white shadow-lg shadow-warga-900/20' : 'text-warga-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('warga.profil.*') ? 'text-emerald-300' : 'text-warga-400 group-hover:text-emerald-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Profil</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-3 border-t border-warga-700/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-300 hover:bg-red-500/10 hover:text-red-200 transition-all duration-200 w-full group">
                        <svg class="w-5 h-5 text-red-400/70 group-hover:text-red-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-0">
            {{-- Top Navbar --}}
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200/80 h-16">
                <div class="flex items-center justify-between h-full px-4 sm:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <div class="hidden lg:block">
                        <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Beranda')</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-warga-50 border border-warga-100">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-warga-500 to-warga-700 flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name ?? 'W', 0, 1) }}</span>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Warga' }}</p>
                                <p class="text-[10px] text-gray-500">NIK: {{ Auth::user()->nik ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mx-4 sm:mx-6 mt-4">
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="mx-4 sm:mx-6 mt-4">
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Main Content Area --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
