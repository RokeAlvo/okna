<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
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
        Carbon::setUTF8(true);
        setlocale(LC_TIME, config('app.locale'));
        Carbon::setLocale(config('app.locale'));
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        $city = getUrlPathFirstPart();
        $timezoneSettings = Config::get('database.connections')[$city]['timezoneSettings'] ?? null;
        if(!empty($timezoneSettings)) {
            date_default_timezone_set($timezoneSettings);
            Config::set('app.timezone', $timezoneSettings);
        }
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