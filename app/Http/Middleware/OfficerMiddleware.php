<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !($request->user()->isOfficer() || $request->user()->isAdmin())) {
            abort(403, 'Access denied. Officer privileges required.');
        }
        return $next($request);
    }
}
