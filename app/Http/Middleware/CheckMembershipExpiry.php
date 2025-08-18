<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMembershipExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'Member' && $user->membership_end_date < now()) {
            $user->update([
                'role' => 'Guest',
                'membership_type_id' => null
            ]);

            return redirect()->route('membership.select')
                ->with('info', 'Your membership has expired. Please renew.');
        }

        return $next($request);
    }
}
