<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choix extends Model
{

    protected $table = 'choix';

    protected $fillable = [
        'choix',
        'candidats_id',
        'filieres_id',
        'ordreChoix',
        'moyenne',
        'repecher',
        'voeuxRetenu',
        'moyenneDossier',
        'moyenneConcours',
    ];


    public static function getChoixCandidat($idPersonne, $idSession)
    {
        return static::query()
            ->select(
                'ch.*',
                'c.id as idCandidat',
                'fi.id as idFiliere',
                'fi.libelleFiliere',
                'fi.codeFiliere'
            )
            ->from('personnes as p')
            ->join('candidats as c', 'c.personnes_id', '=', 'p.id')
            ->join('session as s', 's.id', '=', 'c.sessions_id')
            ->join('choix as ch', 'ch.candidats_id', '=', 'c.id')
            ->join('filieres as fi', 'fi.id', '=', 'ch.filieres_id')
            ->where('p.id', '=', $idPersonne)
            ->where('s.id', '=', $idSession)
            ->orderBy('ch.ordreChoix', "asc")
            ->groupBy('ch.id')
            ->get();
    }


}
