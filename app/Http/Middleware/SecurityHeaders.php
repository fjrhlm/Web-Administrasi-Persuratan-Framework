<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and inject HTTP security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mencegah Clickjacking — halaman tidak boleh di-embed di iframe pihak lain
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mencegah MIME-type sniffing exploit oleh browser
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Mengontrol informasi Referer yang dikirim ke server tujuan
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Menonaktifkan akses ke fitur browser yang tidak diperlukan
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // Memaksa HTTPS (hanya aktif jika koneksi HTTPS / di production)
        if ($request->isSecure() || app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Content Security Policy — membatasi sumber resource yang boleh dimuat
        // Mengizinkan Google Fonts, Vite dev server (localhost), dan sumber yang sama
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'", // unsafe-inline diperlukan Alpine.js
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com",
            "img-src 'self' data: blob:",
            "connect-src 'self' ws: wss:", // ws/wss diperlukan Vite HMR
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
