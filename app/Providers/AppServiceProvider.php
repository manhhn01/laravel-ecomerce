<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use View;

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
        /* VIEW SHARE */
        View::share('user_avatar', optional(auth()->user())->avatar ?: 'images/users/default-user.png');

        /* PAGINATOR */
        Paginator::useBootstrap();
    }
}
