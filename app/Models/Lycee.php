<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lycee extends Model
{

    protected $table = "lycees";

    protected $fillable = [
        'codeLycee',
        'libelle',
    ];

}
