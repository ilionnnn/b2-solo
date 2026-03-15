<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmotionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'emotion_id',
        'intensity',
        'note',
        'logged_at'
    ];

    protected $casts = [
        'logged_at' => 'datetime',
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

    public function emotion()
    {
        return $this->belongsTo(Emotion::class);
    }

}
