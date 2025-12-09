<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_home_id',
        'team_away_id',
        'match_date',
        'score_home',
        'score_away',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'team_home_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'team_away_id');
    }
}
