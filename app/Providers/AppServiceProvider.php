<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tinify\Tinify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Tinify\setKey(config("TINIFY_KEY", "Sh140SsqyhMqfvknbt8j1MKJhdPkGGLV"));
    }
}
