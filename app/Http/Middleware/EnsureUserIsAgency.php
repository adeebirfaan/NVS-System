<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAgency
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAgency()) {
            return redirect('/')->with('error', 'Access denied. Agency access required.');
        }

        return $next($request);
    }
}
