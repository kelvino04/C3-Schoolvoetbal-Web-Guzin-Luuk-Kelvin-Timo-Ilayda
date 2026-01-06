<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'duration',
        'score',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    public function team1() {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2() {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function getEndTimeAttribute()
    {
        return $this->start_time && $this->duration
            ? $this->start_time->copy()->addMinutes($this->duration)
            : null;
    }
}
