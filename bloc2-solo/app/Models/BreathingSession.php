<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreathingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'duration',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(BreathingExercise::class, 'exercise_id');
    }

}
