<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;
    
    protected $table = 'matches';

    protected $primaryKey = 'id';

    protected $fillable = [
        'team1_id',
        'team2_id',
        'field',
        'start_time',
        'end_time',
        'score', 
    ];      
    public function team1() {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2() {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
