<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaders = User::where('role', 'student')
            ->orderByDesc('points')
            ->take(10)
            ->get();

        return view(
            'livewire.pages.courses.leaderboard',
            compact('leaders')
        );
    }
}
