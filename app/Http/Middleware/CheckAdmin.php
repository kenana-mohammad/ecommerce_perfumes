<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                // (admin)،
                return $next($request);
            } else {
                // if user not  allowed
                return response()->json([
                    'error' => 'Only admins are allowed '
                ], 403);
            }
        }

        // اnauthorized
        return response()->json([
            'error' => 'Unauthenticated'
        ], 401);

    }
}
