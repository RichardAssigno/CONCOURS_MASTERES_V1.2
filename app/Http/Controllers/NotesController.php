<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Formulaire;
use App\Models\Moyennedossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Prompts\Note;

class NotesController extends Controller
{

    public function index(){

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        $infos = Formulaire::getInfosMoyennesCandidat($candidat->id, session("sessions"));

        // On récupère les types de moyennes distincts
        $typesmoyennes = $infos->pluck('libelleTypemoyenne', 'idTypemoyenne')->unique();

        // On groupe les infos par discipline
        $infos = $infos->groupBy('libelleDiscipline');


        return view('notes.index', [

            "infos" => $infos,
            "typesmoyennes" => $typesmoyennes,

        ]);

    }

    public function ajouter(Request $request){

        $data = $request->except("_token");

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        $i = 0; $j = 0;

        if (count($data) > 0 ){

            foreach ($data as $key => $value) {

                $discipline = $key;

                foreach ($value as $key2 => $value2) {

                    $typemoyenne = $key2;

                    $moyenne = $value2;

                    Moyennedossier::updateOrCreate(
                        [
                            'candidats_id' => $candidat->id,
                            'disciplines_id' => $discipline,
                            'typesmoyennes_id' => $typemoyenne
                        ],
                        [
                            'moyenne' => $moyenne
                        ]
                    );



                }

            }

            return response()->json(['success' => "Enrégistrement des notes effectués avec succès"], 200);


        }

        return response()->json([
            'errors' => [
                'notes' => [
                    "Veillez remplir tous les champs.",
                ]
            ]
        ], 422);


    }

}
