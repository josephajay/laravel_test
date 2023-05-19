<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckAccessToken
{
    public function handle($request, Closure $next)
    {
        // Check if the access token is present in the session or any other storage
        if (! $request->session()->has('access_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
