<?php

namespace App\Http\Middleware;

use Closure;

class CheckOrganizationEnabled
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
        if (!auth()->user()->organization->is_enabled)
            return response()->json(['error' => 1, 'message' => 'your organization is not enabled']);
        return $next($request);
    }
}
