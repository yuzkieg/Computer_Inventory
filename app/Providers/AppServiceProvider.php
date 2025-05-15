<?php

namespace App\Providers;
use App\Models\Supplier;
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
    public function boot()
{
    // Share suppliers with all views
    View::share('suppliers', Supplier::with('orders')->get());
}

}
