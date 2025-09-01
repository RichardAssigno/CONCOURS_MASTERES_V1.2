<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Concours extends Model
{

    protected $table = 'concours';
    public $timestamps = false;
    protected $fillable = [
        'libelleConcours',
        'codeConcours',
        'ordre',
        'ponderationMoyenneTest',
        'nouveauBachelier',
        'notes',
    ];


    public static function ConcoursCandidats($idCandidat){

        //INNER JOIN annees a ON a.id = s.annees_id

        return static::query()->select('co.id as idConcours', 'co.libelleConcours', 'co.codeConcours','co.afficheNouveauBac','co.ponderationMoyenneTest','co.notes','co.nouveauBachelier', 's.id as idSession', 'a.libelle as libelleAnnee', 'c.id as idCandidat', 'c.matricule', 'p.id as idPersonne', 'p.nom', 'p.prenoms', 'p.email', 'p.dateNaissance', 'p.lieuNaissance', 'p.genre', 'p.telephone',
            'p.nomEtPrenomsDunProche', 'p.telephoneDunProche','ab.id as idAnneeBac', 'ab.libelle as libelleAnneeBac', 'p.etablissementOrigine', 'p.etablissementSuperieurOrigine', 'p.specialite', 'p.serie', 'p.diplome', 'cy.id as idCycle')
            ->from('concours as co')
            ->join('concourscycles as cc','cc.concours_id','=','co.id')
            ->join('cycles as cy','cy.id','=','cc.cycles_id')
            ->join("session as s", "s.concours_id", "=", "co.id")
            ->join("annees as a", "a.id", "=", "s.annees_id")
            ->join("candidats as c", "c.sessions_id", "=", "s.id")
            ->join("personnes as p", "p.id", "=", "c.personnes_id")
            ->join("anneebacs as ab", "ab.id", "=", "p.anneebacs_id")
            ->where('p.id', '=', $idCandidat)
            /*->where('a.statut', '=', 1)*/
            ->orderBy('s.id','desc')
            ->get();
    }

    public static function getConcoursCandidat($idPersonne, $idSessionConcours)
    {
        return DB::table('concours as co')
            ->select(
                'co.id as idConcours',
                'co.libelleConcours',
                'co.codeConcours',
                'co.afficheNouveauBac',
                'co.ponderationMoyenneTest',
                'co.notes',
                'co.nouveauBachelier',
                'cy.id as idCycles',
                'cy.libelle as libelleCycles',
                'cc.id as idConcoursCycles',
                's.id as idSession',
                'c.id as idCandidat',
                'c.matricule',
                'p.id as idPersonne',
                'p.nom',
                'p.prenoms',
                'p.email',
                'p.dateNaissance',
                'p.lieuNaissance',
                'p.genre',
                'p.telephone',
                'p.nomEtPrenomsDunProche',
                'p.telephoneDunProche',
                'ab.id as idAnneeBac',
                'ab.libelle as libelleAnneeBac',
                'p.etablissementOrigine',
                'p.etablissementSuperieurOrigine',
                'p.specialite',
                'p.serie',
                'p.diplome',
                DB::raw('COUNT(fi.id) as nombrefiliere') // Ajout du COUNT
            )
            ->join('filieres as fi', 'fi.concours_id', '=', 'co.id')
            ->join('concourscycles as cc', 'cc.concours_id', '=', 'co.id')
            ->join('cycles as cy', 'cy.id', '=', 'cc.cycles_id')
            ->join('session as s', 's.concours_id', '=', 'co.id')
            ->join('candidats as c', 'c.sessions_id', '=', 's.id')
            ->join('personnes as p', 'p.id', '=', 'c.personnes_id')
            ->join('anneebacs as ab', 'ab.id', '=', 'p.anneebacs_id')
            ->where('p.id', $idPersonne)
            ->where('s.id', $idSessionConcours)
            ->groupBy(
                'co.id',
                'co.libelleConcours',
                'co.codeConcours',
                'co.afficheNouveauBac',
                'co.ponderationMoyenneTest',
                'co.notes',
                'co.nouveauBachelier',
                'cy.id',
                'cy.libelle',
                'cc.id',
                's.id',
                'c.id',
                'c.matricule',
                'p.id',
                'p.nom',
                'p.prenoms',
                'p.email',
                'p.dateNaissance',
                'p.lieuNaissance',
                'p.genre',
                'p.telephone',
                'p.nomEtPrenomsDunProche',
                'p.telephoneDunProche',
                'ab.id',
                'ab.libelle',
                'p.etablissementOrigine',
                'p.etablissementSuperieurOrigine',
                'p.specialite',
                'p.serie',
                'p.diplome'
            )
            ->first();
    }


    public static function listeconcoursouvert(){

        return static::query()->select('c.id as idConcours','s.id as idSession','a.id as idAnnee','sec.id as idSessionEtape',
            'e.id as idEtape','c.libelleConcours','c.codeConcours','e.libelle as etapeConcours', 'a.libelle as libelleAnnee')
            ->from('concours as c')
            ->join('session as s','s.concours_id','=','c.id')
            ->join('annees as a','a.id','=','s.annees_id')
            ->join('sessionetapesconcours as sec','sec.session_id','=','s.id')
            ->join('etapesconcours as e','e.id','=','sec.etapesConcours_id')
            ->where('a.statut','=',1)
            ->where('sec.statut','=',1)
            ->where('e.code','=','E2')
            ->orderBy('c.libelleConcours')
            ->get();
    }

    public static function concoursaveccode($code){

        return static::query()->select('c.id as idConcours','s.id as idSession','a.id as idAnnee','sec.id as idSessionEtape',
            'e.id as idEtape','c.libelleConcours','c.codeConcours','e.libelle as etapeConcours', 'a.libelle as libelleAnnee')
            ->from('concours as c')
            ->join('session as s','s.concours_id','=','c.id')
            ->join('annees as a','a.id','=','s.annees_id')
            ->join('sessionetapesconcours as sec','sec.session_id','=','s.id')
            ->join('etapesconcours as e','e.id','=','sec.etapesConcours_id')
            ->where('c.codeConcours','=',$code)
            ->where('a.statut','=',1)
            ->where('sec.statut','=',1)
            ->where('e.code','=','E2')
            ->first();
    }

}
