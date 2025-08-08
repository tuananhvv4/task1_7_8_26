<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


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
        $accountNumbers = ['UN1', 'UN2', 'UN3', 'UN4', 'UN5'];
        $services = ['Buy Mobile', 'Rent House', 'Buy Car', 'Buy Laptop'];
        $categories = ['company', 'hospital', 'home', 'school', 'other'];
        $states = ['pending', 'complete', 'refund', 'processing'];
        View::share([
            'accountNumbers' => $accountNumbers,
            'services' => $services,
            'categories' => $categories,
            'states' => $states
        ]);
    }
}