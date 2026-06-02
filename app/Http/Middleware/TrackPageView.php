<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is('admin*') && ! $request->is('livewire*')) {
            PageView::create([

                'user_id' => Auth::id(),
                'url' => $request->path(),
                'route_name' => $request->route()?->getName(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $next($request);
    }
}
