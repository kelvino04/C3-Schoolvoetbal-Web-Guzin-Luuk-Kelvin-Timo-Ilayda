<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatchModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'balance' => $user->balance
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function matches()
    {
        $matches = MatchModel::with(['team1','team2'])
            ->whereNull('score')
            ->orderBy('start_time')
            ->get()
            ->map(function ($m) {
                return [
                    'match_id' => $m->id,
                    'team1' => [
                        'id' => $m->team1->id,
                        'name' => $m->team1->name,
                    ],
                    'team2' => [
                        'id' => $m->team2->id,
                        'name' => $m->team2->name,
                    ],
                    'start_time' => $m->start_time,
                ];
            });

        return response()->json($matches);
    }

    public function results()
    {
        $results = MatchModel::with(['team1','team2'])
            ->whereNotNull('score')
            ->orderBy('start_time')
            ->get()
            ->map(function ($m) {
                return [
                    'match_id' => $m->id,
                    'team1' => [
                        'id' => $m->team1->id,
                        'name' => $m->team1->name,
                    ],
                    'team2' => [
                        'id' => $m->team2->id,
                        'name' => $m->team2->name,
                    ],
                    'score' => $m->score,
                ];
            });

        return response()->json($results);
    }
}
