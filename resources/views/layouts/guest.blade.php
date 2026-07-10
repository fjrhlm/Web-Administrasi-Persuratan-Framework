<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Web Desa Babakanmulya') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <style>
            .custom-bg {
                background-image: url('{{ asset('storage/img/Background_Foto2.png') }}');
                background-size: cover;
                background-position: right center;
                background-repeat: no-repeat;
            }
        </style>
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:py-0 relative overflow-hidden bg-slate-900 custom-bg">
            {{-- Dark Overlay to ensure white text is readable --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm pointer-events-none"></div>
            
            {{-- Decorative Elements --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500/30 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 w-full flex flex-col items-center">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
