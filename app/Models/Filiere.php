<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{

    protected $table = 'filieres';



    public static function getConcoursFilieres($idSession)
    {
        return static::query()
            ->select(
                'co.id as idConcours',
                'co.libelleConcours',
                'co.codeConcours',
                'fi.id as idFiliere',
                'fi.libelleFiliere',
                'fi.codeFiliere'
            )
            ->from('session as s')
            ->join('annees as a','a.id','=','s.annees_id')
            ->join('concours as co', 'co.id', '=', 's.concours_id')
            ->join('filieres as fi', 'fi.concours_id', '=', 'co.id')
            ->where('s.id', '=', $idSession)
            ->where('s.statut', '=', 1)
            ->get();
    }


}
