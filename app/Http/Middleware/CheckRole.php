<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$roles)
    {
        // if (in_array($request->header('role'), $roles)) {
        //     return response()->json(['result' => 'access denied']);
        // }

        return $next($request);
    }
}
