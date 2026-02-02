<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getPhotoByCandidatId($candidatId)
    {
        return DB::table('candidats as c')
            ->join('personnes as p', 'p.id', '=', 'c.personnes_id')
            ->leftJoin('photos as ph', 'ph.id', '=', 'p.photos_id')
            ->where('c.id', $candidatId)
            ->select('ph.id', 'ph.photo_path', 'ph.photo_type', 'ph.photo_nom', 'p.id as idPersonne', 'p.nom', 'p.prenoms')
            ->first(); // ou ->get() si tu veux plusieurs résultats
    }


    public static function getDocumentByCandidat($idCandidat, $idDocument)
    {
        return DB::table('candidats as c')
            ->join('documents as d', 'd.candidats_id', '=', 'c.id')
            ->where('c.id', $idCandidat)
            ->where('d.id', $idDocument)
            ->select('d.id as idDocument', 'd.filePath')
            ->first();
    }




}
