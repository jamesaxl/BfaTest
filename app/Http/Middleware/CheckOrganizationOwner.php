<?php

namespace App\Http\Middleware;

use Closure;

class CheckOrganizationOwner
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

        $id = $request->route('id');
        if (auth()->user()->organization_id != $id) {
            return response()->json(['error' => 1, 'message' => 'permission denied']);
        }
        return $next($request);
    }
}
