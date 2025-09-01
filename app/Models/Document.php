<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Document extends Model
{

    protected $table = 'documents';

    protected $fillable = [

        "candidats_id",
        "dossiersCandidature_id",
        "filePath",
        "requis",

    ];

    public static function getDocuments($candidatId)
    {
        return DB::table('documentsdossiers as dd')
            ->join('dossierscandidatures as dc', 'dc.documentsdossiers_id', '=', 'dd.id')
            ->leftJoin('documents as d', 'd.dossiersCandidature_id', '=', 'dc.id')
            ->join('candidats as c', 'c.id', '=', 'd.candidats_id')
            ->join('session as s', 's.id', '=', 'c.sessions_id')
            ->where('c.id', $candidatId)
            ->groupBy('dd.id')
            ->select(
                'dd.id as idDocumentdossier',
                'dd.libelle as libelleDocumentdossier',
                'dd.code as codeDocumentdossier',
                'dd.requis',
                'dc.id as idDossiercandidature',
                'c.id as idCandidat',
                'd.id as idDocument',
                'd.filePath'
            )
            ->get();
    }



}
