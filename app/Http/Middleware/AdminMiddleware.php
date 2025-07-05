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
            if (auth()->user()->role === 'admin' || auth()->user()->role === 'teacher') {
                return $next($request);
            }

            if (auth()->user()->role === 'student') {
                return redirect()->route('filament.student.pages.dashboard');
            }
            
            // User is authenticated but doesn't have admin role
            abort(403, 'Unauthorized');
        }

        // User is not authenticated, redirect to main login page
        return redirect()->route('login');
    }
}
