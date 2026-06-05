<?php

namespace App\Http\Controllers;

use App\Models\PointHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $filter = request('filter', 'all');

        if ($filter === '7days') {

            $leaders = User::students()
                ->withSum(
                    ['pointHistories as period_points' => function ($q) {
                        $q->where(
                            'created_at',
                            '>=',
                            now()->subDays(7)
                        );
                    }],
                    'points'
                )
                ->orderByDesc('period_points')
                ->take(6)
                ->get();
        } elseif ($filter === '30days') {

            $leaders = User::students()
                ->withSum(
                    ['pointHistories as period_points' => function ($q) {
                        $q->where(
                            'created_at',
                            '>=',
                            now()->subDays(30)
                        );
                    }],
                    'points'
                )
                ->orderByDesc('period_points')
                ->take(6)
                ->get();
        } else {

            $leaders = User::students()
                ->orderByDesc('points')
                ->take(6)
                ->get();
        }

        return view(
            'livewire.pages.courses.leaderboard',
            compact(
                'leaders',
                'user',
                'filter'
            )
        );
    }
}
