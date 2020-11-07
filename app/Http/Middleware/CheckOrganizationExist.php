<?php

namespace App\Http\Middleware;

use Closure;

class CheckOrganizationExist
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
        if (!auth()->user()->organization_id) {
            response()->json([ 'error' => 1, 'message' => 'permission denied - you have any organization - ' ]);
        }
        return $next($request);
    }
}
