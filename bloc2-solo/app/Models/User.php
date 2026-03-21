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
        'consent_rgpd',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'consent_rgpd'      => 'boolean',
    ];

    public function ressources()
    {
        return $this->hasMany(Ressources::class, 'user_id');
    }

    public function exercices()
    {
        return $this->hasMany(ExerciceRespiration::class, 'user_id');
    }

    public function informations()
    {
        return $this->hasMany(Information::class, 'user_id');
    }
}
