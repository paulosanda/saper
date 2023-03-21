<?php

namespace App\Providers;

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
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) {
            return new \Illuminate\Validation\Validator($translator, $data, $rules, $messages);
        });
    }
}
