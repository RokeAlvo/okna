<?php

namespace App\Http\Middleware;

use Closure;

class SelectDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = url()->current();
        $subdomain = getUrlPathFirstPart();
        $appUrl = env('APP_URL');
        if (!empty($subdomain) && !empty(\Config::get('database.connections')[$subdomain])) {
            \Config::set('app.subdomain', $subdomain);
            \Config::set('app.timezone', \Config::get('database.connections')[$subdomain]['timezoneSettings']);
            \Config::set('database.default', $subdomain);
        }
        //  elseif ($url != $appUrl) {
        //     return redirect($appUrl);
        // }

        return $next($request);
    }
}
