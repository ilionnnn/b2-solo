<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreathingExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'inhale_duration',
        'hold_duration',
        'exhale_duration',
        'cycles',
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function sessions()
    {
        return $this->hasMany(BreathingSession::class, 'exercise_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

}
