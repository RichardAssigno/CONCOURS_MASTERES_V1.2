<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{

    protected $table = 'photos';

    protected $fillable = [
        'photo_path',
        'photo_type',
        'photo_nom',
    ];

}
