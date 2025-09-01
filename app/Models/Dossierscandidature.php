<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossierscandidature extends Model
{

    protected $table = 'dossierscandidatures';

    protected $fillable = [

        "sessions_id",
        "documentsdossiers_id"

    ];

    public static function listedocumentcandidature($idSession){

        return static::query()->select('c.libelleConcours', 'c.codeConcours','dc.id as idDossierCandidature','d.libelle','d.code')
            ->from('documentsdossiers as d')
            ->join('dossierscandidatures as dc','dc.documentsdossiers_id','=','d.id')
            ->join('session as s','dc.sessions_id','=','s.id')
            ->join('concours as c','s.concours_id','=','c.id')
            ->where('s.id','=',$idSession)
            ->orderBy('d.libelle','ASC')
            ->get();
    }


}
