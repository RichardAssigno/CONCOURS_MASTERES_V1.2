<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Formulaire extends Model
{
    protected $table = "formulaires";

    protected $fillable = [
        "concours_id",
        "typesmoyennes_id",
        "disciplines_id",
    ];

    public static function getMoyennesCandidat($idCandidat, $idSession)
    {
        return self::getInfosMoyennesCandidat($idCandidat, $idSession);
    }

    public static function getInfosMoyennesCandidat($idCandidat, $idSession)
    {
        $concoursId = DB::table('session')->where('id', $idSession)->value('concours_id');

        if (is_null($concoursId)) {
            return collect();
        }

        $infos = self::requeteMoyennesDepuisFormulaires($idCandidat, $concoursId)->get();

        if ($infos->isNotEmpty()) {
            return $infos;
        }

        return self::requeteMoyennesDepuisDisciplines($idCandidat, $concoursId)->get();
    }

    private static function requeteMoyennesDepuisFormulaires($idCandidat, $concoursId)
    {
        $formulaires = DB::table('formulaires')
            ->select('disciplines_id', 'typesmoyennes_id', 'concours_id')
            ->where('concours_id', $concoursId)
            ->distinct();

        return DB::query()
            ->fromSub($formulaires, 'f')
            ->join('disciplines as d', 'd.id', '=', 'f.disciplines_id')
            ->join('typesmoyennes as tm', 'tm.id', '=', 'f.typesmoyennes_id')
            ->leftJoin('moyennedossier as md', function ($join) use ($idCandidat) {
                $join->on('md.typesmoyennes_id', '=', 'tm.id')
                    ->on('md.disciplines_id', '=', 'f.disciplines_id')
                    ->where('md.candidats_id', '=', $idCandidat);
            })
            ->select(
                'd.id as idDiscipline',
                'd.libelle as libelleDiscipline',
                'tm.id as idTypemoyenne',
                'tm.libelle as libelleTypemoyenne',
                'md.id as idMoyennedossier',
                'md.moyenne'
            )
            ->orderBy('d.id')
            ->orderBy('tm.id');
    }

    private static function requeteMoyennesDepuisDisciplines($idCandidat, $concoursId)
    {
        return DB::table('disciplines as d')
            ->crossJoin('typesmoyennes as tm')
            ->leftJoin('moyennedossier as md', function ($join) use ($idCandidat) {
                $join->on('md.typesmoyennes_id', '=', 'tm.id')
                    ->on('md.disciplines_id', '=', 'd.id')
                    ->where('md.candidats_id', '=', $idCandidat);
            })
            ->where('d.concours_id', $concoursId)
            ->select(
                'd.id as idDiscipline',
                'd.libelle as libelleDiscipline',
                'tm.id as idTypemoyenne',
                'tm.libelle as libelleTypemoyenne',
                'md.id as idMoyennedossier',
                'md.moyenne'
            )
            ->orderBy('d.id')
            ->orderBy('tm.id');
    }
}
