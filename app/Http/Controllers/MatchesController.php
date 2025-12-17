<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\MatchModel;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class MatchesController extends Controller
{
    public function generateForm()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $teams = Team::all();

        if ($teams->count() < 2) {
            return redirect()->back()->with('error', 'You need at least 2 teams to generate matches.');
        }

        return view('matches.generate', compact('teams'));
    }

    public function generateMatches(Request $request)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $teamIds = $request->input('teams', []);
        $teamsQuery = Team::query();
        if (!empty($teamIds)) {
            $teamsQuery->whereIn('id', (array) $teamIds);
        }
        $teams = $teamsQuery->get();

        if ($teams->count() < 2) {
            return redirect()->back()->with('error', 'Not enough teams to generate matches.');
        }

        $startDate = $request->input('date') ? Carbon::parse($request->input('date'))->startOfDay() : now()->startOfDay();

        // Scheduling options from form
        $fieldsCount = (int) $request->input('fields_count', 4);
        $matchDuration = (int) $request->input('match_duration', 60); // minutes
        $gapMinutes = (int) $request->input('gap_minutes', 0); // minutes between matches on same field

        $created = 0;
        for ($i = 0; $i < $teams->count(); $i++) {
            for ($j = $i + 1; $j < $teams->count(); $j++) {
                // field assignment rotates across available fields
                $field = ($created % max(1, $fieldsCount)) + 1;

                // compute start time: increment by days so matches appear on sequential dates
                $start = (clone $startDate)->addDays($created)->startOfDay();

                $matchData = [
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id,
                    'start_time' => $start,
                    'end_time' => (clone $start)->addMinutes($matchDuration),
                    'field' => $field,
                ];

                // add score if column exists (migration might not be run yet)
                if (\Illuminate\Support\Facades\Schema::hasColumn('matches', 'score')) {
                    $matchData['score'] = null;
                }

                // prevent duplicates
                $exists = MatchModel::where(function ($q) use ($teams, $i, $j) {
                    $t1 = $teams[$i]->id;
                    $t2 = $teams[$j]->id;
                    $q->where('team1_id', $t1)->where('team2_id', $t2);
                })->orWhere(function ($q) use ($teams, $i, $j) {
                    $t1 = $teams[$i]->id;
                    $t2 = $teams[$j]->id;
                    $q->where('team1_id', $t2)->where('team2_id', $t1);
                })->exists();

                    if (!$exists) {
                        MatchModel::create($matchData);
                        $created++;
                }
            }
        }

        return redirect()->route('matches.generateForm')->with('success', "Generated {$created} matches.");
    }

    /**
     * Display a listing of matches.
     */
    public function index()
    {
        $matches = MatchModel::with('team1', 'team2')->orderBy('start_time')->get();
        return view('matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new match.
     */
    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('matches.create', compact('teams'));
    }

    /**
     * Store a newly created match in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'nullable|date',
            'field' => 'nullable|integer',
        ]);

        // Convert provided date (Y-m-d) into start_time timestamp
        if (!empty($data['date'])) {
            $data['start_time'] = Carbon::parse($data['date'])->startOfDay();
            $data['end_time'] = Carbon::parse($data['date'])->startOfDay()->addHour();
            unset($data['date']);
        }

        // set a default field if none provided
        if (empty($data['field'])) {
            $data['field'] = 1;
        }

        MatchModel::create($data);

        return redirect()->route('matches.index')->with('success', 'Match created.');
    }

    /**
     * Show the form for editing the specified match.
     */
    public function edit(MatchModel $match)
    {
        $teams = Team::orderBy('name')->get();
        return view('matches.edit', compact('match', 'teams'));
    }

    /**
     * Update the specified match in storage.
     */
    public function update(Request $request, MatchModel $match)
    {
        $data = $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'nullable|date',
            'field' => 'nullable|integer',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
        ]);

        if (!empty($data['date'])) {
            $data['start_time'] = Carbon::parse($data['date'])->startOfDay();
            $data['end_time'] = Carbon::parse($data['date'])->startOfDay()->addHour();
            unset($data['date']);
        }

        // if field is absent, don't overwrite it; if present, leave in data
        if (!array_key_exists('field', $data)) {
            unset($data['field']);
        }

        $match->update($data);

        return redirect()->route('matches.index')->with('success', 'Match updated.');
    }

    /**
     * Remove the specified match from storage.
     */
    public function destroy(MatchModel $match)
    {
        $match->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted.');
    }

    /**
     * Update just the score for a match.
     */
    public function scoreForm(MatchModel $match)
    {
        // Everyone can view the match score page; only admins can edit
        $homeScore = null;
        $awayScore = null;
        if (!empty($match->score) && preg_match('/^(\d+)-(\d+)$/', $match->score, $m)) {
            $homeScore = intval($m[1]);
            $awayScore = intval($m[2]);
        }

        return view('matches.score', compact('match', 'homeScore', 'awayScore'));
    }

    public function updateScore(Request $request, MatchModel $match)
    {
        // Only admins may update the score
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        // If the DB doesn't have the 'score' column, surface a helpful error instead of crashing
        if (!Schema::hasColumn('matches', 'score')) {
            return redirect()->route('matches.index')
                ->with('error', 'Database is missing the "score" column. Run `php artisan migrate` to add it (migration file exists).');
        }

        $data = $request->validate([
            'score_team1' => 'nullable|integer|min:0|required_with:score_team2',
            'score_team2' => 'nullable|integer|min:0|required_with:score_team1',
        ]);

        $s1 = array_key_exists('score_team1', $data) ? $data['score_team1'] : null;
        $s2 = array_key_exists('score_team2', $data) ? $data['score_team2'] : null;

        if (is_null($s1) && is_null($s2)) {
            $score = null;
        } else {
            $score = sprintf('%d-%d', $s1 ?? 0, $s2 ?? 0);
        }

        $match->update(['score' => $score]);
        $match->refresh();

        // Redirect back to the index so the admin sees the score in the table immediately
        return redirect()->route('matches.index')->with('success', 'Score updated.');
    }
}

