<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

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
        View::composer('*', function ($view) {
            $phoneNumber = Setting::where('key', 'header_phone_number')->value('value') ?? '+7 (953) 555-33-32';
            $email = Setting::where('key', 'header_email')->value('value') ?? 'group.ru';
            $view->with('phoneNumber', $phoneNumber);
            $view->with('email', $email);
        });
    }
}