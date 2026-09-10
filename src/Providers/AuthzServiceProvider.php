<?php

namespace Bsadeknet\AuthzClient\Providers;

use Illuminate\Support\ServiceProvider;

class AuthzServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Menggabungkan config default package agar tetap bisa dibaca 
        // meskipun pengguna belum melakukan publish config.
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/authz_client.php', 'authz_client'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Daftarkan file config agar bisa di-publish ke project Laravel utama
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/authz_client.php' => config_path('authz_client.php'),
            ], 'authz_client-config'); // Tag 'authz_client-config' digunakan sebagai penanda saat publish
        }
    }
}