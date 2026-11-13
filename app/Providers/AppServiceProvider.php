<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce strong password policy globally
        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()   // Harus ada huruf besar & huruf kecil
                ->numbers()     // Harus ada angka
                ->symbols()     // Harus ada simbol (! @ # $ dll)
                ->uncompromised(); // Cek apakah password pernah bocor di haveibeenpwned.com
        });
    }
}
