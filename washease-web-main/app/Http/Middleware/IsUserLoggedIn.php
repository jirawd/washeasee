<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()
                ->to(route('customer.login'))
                ->withErrors('error', 'You\'re not Logged In.');
        }

        if (Auth::user()->role !== 'Customer') {
            abort(403);
        }


        return $next($request);
    }
}
