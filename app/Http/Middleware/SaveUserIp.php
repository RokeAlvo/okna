<?php

namespace App\Http\Middleware;

use App\UserIp;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class SaveUserIp
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
        $userId = Auth::check() ? Auth::id() : null;
        $userIp = $request->getClientIp();
        $ip = UserIp::where('project', 2)
          ->where('user_id', $userId)
          ->where('ip', $userIp)
          ->where('created_at', '>', Carbon::now()->subHour()->toDateTimeString())
          ->latest()
          ->first();
        if (empty($ip)) {
            UserIp::create([
              'user_id' => $userId,
              'ip' => $userIp,
              'project' => 2
            ]);
        } else {
            $ip->requests++;
            $ip->save();
        }
        return $next($request);
    }
}
