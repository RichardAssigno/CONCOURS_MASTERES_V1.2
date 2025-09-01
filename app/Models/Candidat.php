<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{

    protected $table = 'candidats';
    protected $fillable = [
        'sessions_id',
        'personnes_id',
        'matricule'
    ];

    public static function getCandidat($idPersonne, $idSession)
    {
        return static::query()
            ->select('c.*', 'p.nom', 'p.prenoms')
            ->from('candidats as c')
            ->join('personnes as p', 'p.id', '=', 'c.personnes_id')
            ->join('session as s', 's.id', '=', 'c.sessions_id')
            ->where('p.id', '=', $idPersonne)
            ->where('s.id', '=', $idSession)
            ->first();
    }


}
