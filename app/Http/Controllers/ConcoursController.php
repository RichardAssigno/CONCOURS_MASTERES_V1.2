<?php

namespace App\Http\Controllers;

use App\Models\Concours;
use Illuminate\Http\Request;

class ConcoursController extends Controller
{

    public function recupererconcours(){

        $concours = Concours::listeconcoursouvert();

        return response()->json([
            'success' => true,
            'concours' => $concours
        ]);

    }

}
