<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * If the user is authenticated, continue the request. Otherwise
	 * redirect to the auth login route.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if (Auth::check()) {
			return $next($request);
		}

		// Keep the intended url so after login we can redirect back
		$request->session()->put('url.intended', $request->fullUrl());

		return redirect()->route('auth.login');
	}
}

