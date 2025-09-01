<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'session';

    protected $fillable = [
        'concours_id',
        'annees_id',
        'calendriers_id',
        'compteurMatricule',
        'ageMaxPersonne',
        'ageMaxBac',
        'userAdd',
        'userUpdate',
        'userDelete',
        'supprimer',
        'deleted_at',
    ];

    public static function infoSession($idSession){
        return static::query()->select('c.id as idConcours','c.libelleConcours','c.codeConcours','c.baseMatricule','s.compteurMatricule','s.id as idSession')
            ->from('concours as c')
            ->join('session as s','s.concours_id','=','c.id')
            ->where('s.id','=',$idSession)
            ->first();
    }

}
