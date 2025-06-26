<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return $next($request);
            }

            if (auth()->user()->role === 'student') {
                return redirect()->route('filament.student.pages.dashboard');
            }
        }

        abort(403, 'Unauthorized');
    }
}
