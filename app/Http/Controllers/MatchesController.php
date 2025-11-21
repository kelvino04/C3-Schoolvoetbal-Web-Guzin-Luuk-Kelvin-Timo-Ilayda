<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    public function index()
    {
        $matches = Matches::all();
        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'required|date',
            'score' => 'nullable|string',
        ]);

        Matches::create($request->all());
        return redirect()->route('matches.index')->with('success', 'Match created!');
    }

    public function edit(Matches $match)
    {
        $teams = Team::all();
        return view('matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, Matches $match)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'required|date',
            'score' => 'nullable|string',
        ]);

        $match->update($request->all());
        return redirect()->route('matches.index')->with('success', 'Match updated!');
    }

    public function destroy(Matches $match)
    {
        $match->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted!');
    }
}
