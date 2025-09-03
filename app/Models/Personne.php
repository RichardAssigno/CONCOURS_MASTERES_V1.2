<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Personne extends Authenticatable
{
    protected $table = 'personnes';

    protected $fillable = [
        'lycees_id',
        'etablissements_id',
        'specialites_id',
        'diplomes_id',
        'matricule',
        'nom',
        'password',
        'prenoms',
        'dateNaissance',
        'lieuNaissance',
        'genre',
        'telephone',
        'email',
        'photos_id',
        'nomEtPrenomsDunProche',
        'telephoneDunProche',
        'anneeBacs_id',
        'etablissementOrigine',
        'etablissementSuperieurOrigine',
        'specialite',
        'serie',
        'series_id',
        'diplome',
        'photos_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public static function getInfosCandidat($idPersonne, $idSession)
    {
        return static::query()->select(
            'p.id as idPersonne',
            'p.nom',
            'p.prenoms',
            'p.dateNaissance',
            'p.lieuNaissance',
            'p.genre',
            'p.telephone',
            'p.email',
            'p.nomEtPrenomsDunProche',
            'p.telephoneDunProche',
            'p.etablissementOrigine',
            'p.etablissementSuperieurOrigine',
            'p.specialite',
            'p.diplome',
            'l.id as idLycee',
            'l.libelle as libelleLycee',
            'e.id as idEtablissement',
            'e.codeEtablissement',
            'e.libelleEtablissement',
            'd.id as idDiplome',
            'd.libelle as libelleDiplome',
            'sp.id as idSpecialite',
            'sp.libelleSpecialite',
            'sp.codeSpecialite',
            's.id as idSerie',
            's.libelleSerie',
            'ab.id as idAnneebac',
            'ab.libelle as libelleAnneebac',
            'c.id as idCandidat',
            'c.matricule',
            'c.valideDossier',
            'c.sessions_id',
            'ph.id as idPhoto',
            'ph.photo_path',
            'ph.photo_type',
            'ph.photo_nom',
        )
            ->from('personnes as p')
            ->join('anneebacs as ab', 'ab.id', '=', 'p.anneeBacs_id')
            ->join('lycees as l', 'l.id', '=', 'p.lycees_id')
            ->join('etablissement as e', 'e.id', '=', 'p.etablissements_id')
            ->join('diplomes as d', 'd.id', '=', 'p.diplomes_id')
            ->join('specialites as sp', 'sp.id', '=', 'p.specialites_id')
            ->leftJoin('photos as ph', 'ph.id', '=', 'p.photos_id')
            ->join('series as s', 's.id', '=', 'p.series_id')
            ->join('candidats as c', 'c.personnes_id', '=', 'p.id')
            ->where('p.id', '=', $idPersonne)
            ->where('c.sessions_id', '=', $idSession)
            ->first();
    }


}

