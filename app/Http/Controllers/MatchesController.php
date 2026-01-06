<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\MatchModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class MatchesController extends Controller
{
    public function generateForm()
    {
        if (!auth()->user()?->isAdmin()) abort(403);
        $teams = Team::all();
        if ($teams->count() < 2) return redirect()->back()->with('error', 'You need at least 2 teams to generate matches.');
        return view('matches.generate', compact('teams'));
    }

    public function generateMatches(Request $request)
    {
        if (!auth()->user()?->isAdmin()) abort(403);

        $teamIds = $request->input('teams', []);
        $teamsQuery = Team::query();
        if (!empty($teamIds)) $teamsQuery->whereIn('id', $teamIds);
        $teams = $teamsQuery->get();
        if ($teams->count() < 2) return redirect()->back()->with('error', 'Not enough teams to generate matches.');

        MatchModel::truncate();

        $startDate = $request->input('date') ? Carbon::parse($request->input('date'))->startOfDay() : now()->startOfDay();
        $tournamentStartHour = (int) $request->input('start_hour', 9);
        $tournamentEndHour = 20;
        $matchDuration = (int) $request->input('match_duration', 60);
        $gapMinutes = (int) $request->input('gap_minutes', 10);
        $fieldsCount = (int) $request->input('fields_count', 4);

        $created = 0;
        $currentTime = $startDate->copy()->setHour($tournamentStartHour)->setMinute(0);

        for ($i = 0; $i < $teams->count(); $i++) {
            for ($j = $i + 1; $j < $teams->count(); $j++) {

                if ($currentTime->hour + intdiv($matchDuration, 60) > $tournamentEndHour) {
                    $currentTime->addDay()->setHour($tournamentStartHour)->setMinute(0);
                }

                $field = ($created % max(1, $fieldsCount)) + 1;

                MatchModel::create([
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id,
                    'start_time' => $currentTime,
                    'end_time' => (clone $currentTime)->addMinutes($matchDuration),
                    'duration' => $matchDuration,
                    'field' => $field,
                    'score' => Schema::hasColumn('matches', 'score') ? null : null,
                    'referee' => null,
                ]);

                $created++;
                $currentTime->addMinutes($matchDuration + $gapMinutes);
            }
        }

        return redirect()->route('matches.generateForm')->with('success', "Generated {$created} matches.");
    }



    public function index()
    {
        $matches = MatchModel::with(['team1','team2'])->orderBy('start_time')->get();
        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'nullable|date',
            'start_time' => 'nullable|date',
            'field' => 'nullable|integer',
            'duration' => 'nullable|integer|min:1',
            'score' => 'nullable|string',
            'referee' => 'nullable|string',
        ]);

        if (!empty($data['date']) && empty($data['start_time'])) {
            $data['start_time'] = Carbon::parse($data['date'])->startOfDay();
        }
        if (!empty($data['start_time'])) {
            $data['start_time'] = Carbon::parse($data['start_time']);
        }

        $data['duration'] = $data['duration'] ?? 60;
        $data['field'] = $data['field'] ?? 1;

        MatchModel::create($data);

        return redirect()->route('matches.index')->with('success','Match created.');
    }

    public function edit(MatchModel $match)
    {
        $teams = Team::orderBy('name')->get();
        return view('matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, MatchModel $match)
    {
        $data = $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'date' => 'nullable|date',
            'start_time' => 'nullable|date',
            'field' => 'nullable|integer',
            'duration' => 'nullable|integer|min:1',
            'score' => 'nullable|string',
            'referee' => 'nullable|string',
        ]);

        if (!empty($data['date'])) {
            $data['start_time'] = Carbon::parse($data['date'])->startOfDay();
            $data['end_time'] = Carbon::parse($data['date'])->startOfDay()->addMinutes($data['duration'] ?? 60);
            unset($data['date']);
        }
        if (!empty($data['start_time'])) {
            $data['start_time'] = Carbon::parse($data['start_time']);
        }

        $match->update($data);

        return redirect()->route('matches.index')->with('success', 'Match updated.');
    }

    public function destroy(MatchModel $match)
    {
        $match->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted.');
    }

    public function scoreForm(MatchModel $match)
    {
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
        if (!auth()->user()?->isAdmin()) abort(403);

        if (!Schema::hasColumn('matches', 'score')) {
            return redirect()->route('matches.index')->with('error', 'Database missing "score" column.');
        }

        $data = $request->validate([
            'score_team1' => 'nullable|integer|min:0|required_with:score_team2',
            'score_team2' => 'nullable|integer|min:0|required_with:score_team1',
        ]);

        $s1 = $data['score_team1'] ?? null;
        $s2 = $data['score_team2'] ?? null;

        $score = is_null($s1) && is_null($s2) ? null : sprintf('%d-%d', $s1 ?? 0, $s2 ?? 0);

        $match->update(['score' => $score]);
        $match->refresh();

        return redirect()->route('matches.index')->with('success', 'Score updated.');
    }
}
