<?php

namespace App\Providers;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $view->with('whereami', \Session::get('whereami'));
        });

        Gate::define('viewWebTinker', function ($user) {
            return in_array($user->email, ['elms@sksu.edu.ph']);
        });
    }
}
