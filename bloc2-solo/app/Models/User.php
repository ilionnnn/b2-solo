<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'consent_rgpd'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'consent_rgpd' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function pages()
    {
        return $this->hasMany(Page::class, 'created_by');
    }

    public function emotionLogs()
    {
        return $this->hasMany(EmotionLog::class);
    }

    public function breathingSessions()
    {
        return $this->hasMany(BreathingSession::class);
    }

    public function exercises()
    {
        return $this->hasMany(BreathingExercise::class, 'created_by');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

}
