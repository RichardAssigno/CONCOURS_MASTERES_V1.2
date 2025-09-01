<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moyennedossier extends Model
{

    protected $table = 'moyennedossier';

    protected $fillable = [

        'candidats_id',
        'disciplines_id',
        'typesmoyennes_id',
        'moyenne',

    ];

}
