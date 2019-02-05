<?php

namespace App\Providers;

use App\Stock;
use Illuminate\Support\Facades\View;
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
        $low_products = Stock::whereRaw('quantity_in_hand <= re_order_quantity')->orderBy('updated_at', 'desc')->get();
        View::share('low_products', $low_products);

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
