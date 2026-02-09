<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{


    protected $table = 'calendriers';

    protected $fillable = [

        'dateDebut',
        'dateFin',
        'userAdd',
        'userUpdate',
        'userDelete',
    ];



}
