<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()?->role !== 'instructor') {
            abort(403);
        }

        return $next($request);
    }
}
