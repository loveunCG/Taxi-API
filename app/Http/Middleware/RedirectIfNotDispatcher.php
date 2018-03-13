<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotDispatcher
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'dispatcher')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('dispatcher/login');
	    }

	    return $next($request);
	}
}