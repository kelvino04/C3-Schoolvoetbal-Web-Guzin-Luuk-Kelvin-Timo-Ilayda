<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamsController extends Controller
{
    public function index() {
        $teams = Team::all();
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
}
