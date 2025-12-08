<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        Schema::defaultStringLength(191);
        $this->loadHelpers();
        Carbon::setLocale('fr');
    }

    /**
     * Register helpers
     *
     * @return void
     */
    protected function loadHelpers()
    {
        foreach (glob(app_path('Helpers') . '/*.php') as $filename) 
        {
            require_once $filename;
        }
    }
}
