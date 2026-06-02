<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureInstructorProfileAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->is('admin/my-profile') &&
            auth()->user()?->role !== 'instructor'
        ) {
            abort(403);
        }

        return $next($request);
    }
}
