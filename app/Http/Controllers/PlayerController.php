<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Team;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        Player::create([
            'name' => $request->name,
            'team_id' => $request->team_id,
        ]);

        return back()->with('success', 'Player added to team!');
    }
}

