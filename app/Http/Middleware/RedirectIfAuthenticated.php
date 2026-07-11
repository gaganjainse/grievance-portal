<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'officer' => redirect()->route('officer.dashboard'),
                    default => redirect()->route('citizen.dashboard'),
                };
            }
        }

        return $next($request);
    }
}
