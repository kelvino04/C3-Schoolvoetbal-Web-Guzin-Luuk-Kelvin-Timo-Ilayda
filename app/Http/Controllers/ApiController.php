<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\MatchModel;
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

        return response()->json(['status'=>'error','message'=>'Invalid credentials'], 401);
    }

    public function matches()
    {
        $matches = MatchModel::with(['team1','team2'])
            ->whereNull('score')
            ->get()
            ->map(function($m){
                return [
                    'id' => $m->id,
                    'team1_id' => $m->team1->id,
                    'team1_name' => $m->team1->name,
                    'team2_id' => $m->team2->id,
                    'team2_name' => $m->team2->name,
                    'start_time' => $m->start_time
                ];
            });

        return response()->json($matches);
    }

    public function results()
    {
        $results = MatchModel::with(['team1','team2'])
            ->whereNotNull('score')
            ->get()
            ->map(function($m){
                return [
                    'id' => $m->id,
                    'team1_id' => $m->team1->id,
                    'team1_name' => $m->team1->name,
                    'team2_id' => $m->team2->id,
                    'team2_name' => $m->team2->name,
                    'score' => $m->score
                ];
            });

        return response()->json($results);
    }
}
