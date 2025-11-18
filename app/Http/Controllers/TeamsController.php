<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $teams = Team::where('creator_id', auth()->id())->get();
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'nullable|integer|min:0',
        ]);

        Team::create([
            'name' => $request->name,
            'points' => $request->points ?? 0,
            'creator_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $team = Team::where('id', $id)->where('creator_id', auth()->id())->firstOrFail();
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $team = Team::where('id', $id)->where('creator_id', auth()->id())->firstOrFail();
        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $team = Team::where('id', $id)->where('creator_id', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'nullable|integer|min:0',
        ]);

        $team->update([
            'name' => $request->name,
            'points' => $request->points ?? 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $team = Team::where('id', $id)->where('creator_id', auth()->id())->firstOrFail();
        $team->delete();

        return redirect()->route('dashboard')->with('success', 'Team deleted successfully.');
    }
}
