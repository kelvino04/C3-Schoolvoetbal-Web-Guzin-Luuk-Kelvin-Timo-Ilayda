<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatchModel;

class ApiController extends Controller
{
    // GET /api/matches - returns matches WITHOUT scores (for betting)
    public function matches()
    {
        try {
            // Get matches WITHOUT scores (only future matches or no score yet)
            $matches = MatchModel::with(['team1', 'team2'])
                ->whereNull('score')  // Only matches without scores
                ->where('start_time', '>', now())  // Only future matches
                ->orderBy('start_time', 'asc')
                ->get()
                ->map(function ($match) {
                    return [
                        'match_id' => $match->id,
                        'team1' => [
                            'id' => $match->team1->id,
                            'name' => $match->team1->name,
                        ],
                        'team2' => [
                            'id' => $match->team2->id,
                            'name' => $match->team2->name,
                        ],
                        'start_time' => $match->start_time->format('Y-m-d H:i:s'),
                        'field' => $match->field,
                        'referee' => $match->referee,
                    ];
                });

            return response()->json($matches);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch matches',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/results - returns matches WITH scores (for admin to process bets)
    public function results()
    {
        try {
            // Get matches WITH scores
            $matches = MatchModel::with(['team1', 'team2'])
                ->whereNotNull('score')  // Only matches with scores
                ->orderBy('start_time', 'desc')
                ->get()
                ->map(function ($match) {
                    [$score1, $score2] = explode('-', $match->score);
                    
                    $winnerTeamId = 0; // 0 = draw
                    if ($score1 > $score2) {
                        $winnerTeamId = $match->team1_id;
                    } elseif ($score2 > $score1) {
                        $winnerTeamId = $match->team2_id;
                    }

                    return [
                        'match_id' => $match->id,
                        'team1' => $match->team1->name,
                        'team2' => $match->team2->name,
                        'score1' => (int)$score1,
                        'score2' => (int)$score2,
                        'winner_team_id' => $winnerTeamId,
                    ];
                });

            return response()->json($matches);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch results',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}