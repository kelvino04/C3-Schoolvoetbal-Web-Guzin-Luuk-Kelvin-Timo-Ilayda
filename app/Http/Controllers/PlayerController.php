<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;

class PlayerController extends Controller
{
    public function index(Team $team)
    {
        $players = $team->players;
        return view('players.index', compact('team', 'players'));
    }

    public function create(Team $team)
    {
        return view('players.create', compact('team'));
    }

    public function store(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        Player::create([
            'name' => $request->name,
            'team_id' => $team->id,
        ]);

        return redirect()->route('players.index', $team->id)->with('success', 'Player added!');
    }

    public function edit(Team $team, Player $player)
    {
        return view('players.edit', compact('team', 'player'));
    }

    public function update(Request $request, Team $team, Player $player)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        $player->update($request->only('name'));
        return redirect()->route('players.index', $team->id)->with('success', 'Player updated!');
    }

    public function destroy(Team $team, Player $player)
    {
        $player->delete();
        return redirect()->route('players.index', $team->id)->with('success', 'Player deleted!');
    }
}
