<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheResponser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = request()->url();
        $queryParamaters = request()->query();
        $method = request()->getMethod();
        ksort($queryParamaters); // query() se array milega aur ksort sort karke dega according to key
        $queryString = http_build_query($queryParamaters);
        $fullUrl = "$method:{$url}?{$queryString}";

        if(Cache::has($fullUrl)) {
            return Cache::get($fullUrl);
        }
        return $next($request);
    }
}
