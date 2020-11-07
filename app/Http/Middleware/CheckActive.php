<?php

namespace App\Http\Middleware;

use Closure;

class CheckActive
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
        if (!auth()->user()->is_enabled)
            return response()->json(['error' => 1, 'message' => 'account is not active']);
        return $next($request);
    }
}
