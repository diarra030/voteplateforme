<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Candidat extends Model
{
    use HasFactory;

    protected $table = 'candidats';

    protected $fillable = [
        'nom',
        'prenom',
        'type_candidat',
        'photo',
    ];

    /**
     * Relation : Un candidat peut recevoir plusieurs votes.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'candidat_id');
    }
}
