<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role === 'Guest') {
            return redirect()->route('membership.select')
                ->with('error', 'Please purchase a membership first');
        }

        // Allow access if role is being updated
        if (session()->has('membership_selection')) {
            return $next($request);
        }

        return $next($request);
    }
}
