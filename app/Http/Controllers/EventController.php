<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = Event::query();

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        $query->when($search, function ($q) use ($search) {

            $q->where(
                'title',
                'like',
                '%' . $search . '%'
            );
        });

        /*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    */

        if ($filter === 'upcoming') {

            $query->where(function ($q) {

                $q->where('start_time', '>', now())

                    ->orWhere(function ($q2) {

                        $q2->where('start_time', '<=', now())
                            ->where('end_time', '>=', now());
                    });
            });
        } elseif ($filter === 'past') {

            $query->where('end_time', '<', now());
        }

        $events = $query
            ->orderBy('start_time', 'desc')
            ->get();

        $featuredEvent = $events->first();

        $events = $events->skip(1);

        return view(
            'livewire.pages.courses.events',
            compact(
                'featuredEvent',
                'events',
                'filter',
                'search'
            )
        );
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->firstOrFail();

        return view(
            'livewire.pages.courses.events-detail',
            compact('event')
        );
    }
}
