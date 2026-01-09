<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MatchModel;

class MatchApiController extends Controller
{
    public function results()
    {
        $matches = MatchModel::with(['team1','team2'])
            ->whereNotNull('score')
            ->get()
            ->map(function ($m) {

                [$s1, $s2] = explode('-', $m->score);

                $winnerTeamId = null;
                if ($s1 > $s2) $winnerTeamId = $m->team1_id;
                elseif ($s2 > $s1) $winnerTeamId = $m->team2_id;

                return [
                    'match_id' => $m->id,
                    'team1' => $m->team1->name,
                    'team2' => $m->team2->name,
                    'score1' => (int)$s1,
                    'score2' => (int)$s2,
                    'winner_team_id' => $winnerTeamId,
                ];
            });

        return response()->json($matches);
    }
}
