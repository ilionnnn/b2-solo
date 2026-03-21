<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciceRespiration extends Model
{
    protected $table      = 'exercice_respiration';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'nom',
        'description',
        'duree_inspiration',
        'duree_apnee',
        'duree_expiration',
        'duree_totale',
        'nombre_cycles',
        'type',
        'public',
        'date_creation',
        'user_id',
    ];

    protected $casts = [
        'public'        => 'boolean',
        'date_creation' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
