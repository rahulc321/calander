<?php

namespace App\Http\Middleware;

use App\Modules\Accounting\Software;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckTokenLifeLine
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $services = [Software::XERO, Software::QUICKBOOK];

        foreach ($services as $service) {
            if (isTokenExpirySet($service) && isTokenDead($service)) {
                removeToken($service);
            }
        }

        return $next($request);
    }
}
