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
        $concoursId = DB::table('session')->where('id', $idSession)->value('concours_id');

        return DB::table(DB::raw("(SELECT DISTINCT f.disciplines_id, f.typesmoyennes_id, f.concours_id
                              FROM formulaires f
                              WHERE f.concours_id = $concoursId) as f"))
            ->join('disciplines as d', 'd.id', '=', 'f.disciplines_id')
            ->join('typesmoyennes as tm', 'tm.id', '=', 'f.typesmoyennes_id')
            ->join('session as s', 's.concours_id', '=', 'f.concours_id')
            ->join('candidats as c', 'c.sessions_id', '=', 's.id')
            ->leftJoin('moyennedossier as md', function($join) use ($idCandidat) {
                $join->on('md.typesmoyennes_id', '=', 'f.typesmoyennes_id')
                    ->on('md.disciplines_id', '=', 'f.disciplines_id')
                    ->on('md.candidats_id', '=', DB::raw($idCandidat));
            })
            ->where('c.id', $idCandidat)
            ->where('s.id', $idSession)
            ->select(
                'd.id as idDiscipline',
                'd.libelle as libelleDiscipline',
                'tm.id as idTypemoyenne',
                'tm.libelle as libelleTypemoyenne',
                'md.id as idMoyennedossier',
                'md.moyenne'
            )
            ->get();
    }

    public static function getInfosMoyennesCandidat($idCandidat, $idSession)
    {
        return DB::table(DB::raw('(
            SELECT DISTINCT f.disciplines_id, f.typesmoyennes_id, f.concours_id
            FROM formulaires f
            WHERE f.concours_id = (SELECT s.concours_id FROM session s WHERE s.id = '.$idSession.')
        ) as f'))
            ->join('disciplines as d', 'd.id', '=', 'f.disciplines_id')
            ->join('typesmoyennes as tm', 'tm.id', '=', 'f.typesmoyennes_id')
            ->leftJoin('moyennedossier as md', function ($join) use ($idCandidat) {
                $join->on('md.typesmoyennes_id', '=', 'tm.id')
                    ->on('md.disciplines_id', '=', 'f.disciplines_id') // 🔑 à ne pas oublier
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
            ->orderBy('tm.id')
            ->get();
    }



}
