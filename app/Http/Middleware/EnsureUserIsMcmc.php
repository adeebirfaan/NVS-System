<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMcmc
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isMcmc()) {
            return redirect('/')->with('error', 'Access denied. MCMC access required.');
        }

        return $next($request);
    }
}
