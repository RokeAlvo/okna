<?php

namespace App\Http\Middleware;

use Closure;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\DeviceDetector;

class StoreUtmMarks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $queryString = session('query-string');
        if(empty($queryString)) {
            session(['query-string' => $request->getQueryString()]);
        }

        return $next($request);
    }
}
