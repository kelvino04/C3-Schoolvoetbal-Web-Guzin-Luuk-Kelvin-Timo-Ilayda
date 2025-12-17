<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;

class TeamsController extends Controller
{
    public function index() {
        $teams = Team::with('players', 'creator')->get();
        return view('teams.index', compact('teams'));
    }

    public function create() {
        return view('teams.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'required|integer|min:0',
        ]);

        Team::create([
            'name' => $request->name,
            'points' => $request->points,
            'creator_id' => auth()->id(),
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created!');
    }

    public function edit(Team $team) {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team) {
        $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'required|integer|min:0',
        ]);

        $team->update($request->all());
        return redirect()->route('teams.index')->with('success', 'Team updated!');
    }

    public function destroy(Team $team) {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted!');
    }

    // -------- Player Methods --------
    public function addPlayerForm(Team $team) {
        return view('teams.add-player', compact('team'));
    }

    public function addPlayer(Request $request, Team $team) {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        Player::create([
            'name' => $request->name,
            'team_id' => $team->id,
        ]);

        return redirect()->route('teams.index')->with('success', 'Player added!');
    }

    public function removePlayer(Team $team, Player $player) {
        if(auth()->id() === $team->creator_id || auth()->user()->role === 'admin') {
            $player->delete();
            return redirect()->route('teams.index')->with('success', 'Player removed!');
        }
        return redirect()->route('teams.index')->with('error', 'Not authorized!');
    }
}
