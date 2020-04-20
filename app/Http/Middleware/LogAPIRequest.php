<?php

namespace App\Http\Middleware;

use App\APIRequestLog;
use Closure;

class LogAPIRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $apiRequestLog = new APIRequestLog();
        $apiRequestLog->ip = $request->ip();
        $apiRequestLog->url = $request->fullUrl();
        $apiRequestLog->request = json_encode($request->all());
        $apiRequestLog->save();
    }
}
