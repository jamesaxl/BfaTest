<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Role;
use App\User;

class CheckAdmin
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
        if (auth()->user()->role->type != 'admin')
            return response()->json([
                'error' => 1,
                'message' => 'permission denied - admin'
            ]);
        return $next($request);
    }
}
