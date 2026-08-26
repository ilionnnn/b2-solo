<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';

    public $timestamps = false;

    protected $fillable = [
        'titre',
        'contenu',
        'statut',
        'date_creation',
        'date_modification',
        'user_id',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_modification' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPublished(): bool
    {
        return $this->statut === 'publié';
    }
}
