<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $leaders = User::topStudents()
            ->take(6)
            ->get();


        return view(
            'livewire.pages.courses.leaderboard',
            compact('leaders', 'user')
        );
    }
}
