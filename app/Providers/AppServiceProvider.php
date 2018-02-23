<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //购物车数量

        view()->composer('mcy.footer', function ($view) {
            $cartTotal = session('cart')?count(session('cart')):'';
            $view->with('cartTotal',$cartTotal);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
