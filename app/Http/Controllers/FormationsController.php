<?php

namespace App\Http\Controllers;

use App\Models\Concours;
use App\Models\Diplome;
use App\Models\Etablissement;
use App\Models\Lycee;
use App\Models\Personne;
use App\Models\Serie;
use App\Models\Session;
use App\Models\Specialite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormationsController extends Controller
{

    public function index(){

        return view('formations.index', [
            "personnes" => Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions")),
            "diplomes" => Diplome::query()->orderBy("libelle", "asc")->get(),
            "series" => Serie::query()->orderBy("libelleSerie", "asc")->get(),
            "specialites" => Specialite::query()->orderBy("libelleSpecialite", "asc")->get(),
            "lycees" => Lycee::query()->orderBy("libelle", "asc")->get(),
            "etablissements" => Etablissement::query()->orderBy("libelleEtablissement", "asc")->get(),
        ]);

    }

    public function ajout(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'lycee' => "required",
            'serie' => "required",
            'diplome' => "required",
            'etablissementsuperieur' => "nullable",
            'specialite' => "nullable",
        ],[
            'lycee.required' => 'Le lycée est obligatoire.',
            'serie.required' => 'La série est obligatoire.',
            'diplome.required' => 'Le diplôme est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), session("sessions"));

        $route = session("notes") === 1 ? "notes.index" : "choix.index";

        //dd($route);

        if (mb_strtoupper($candidatConcours->libelleCycles) == "BACHELIER") {

            $dataPersonnes = [
                'series_id'=>$data['serie'],
                'diplomes_id'=>$data['diplome'],
                'lycees_id'=>$data['lycee'],
            ];

            $personne->update($dataPersonnes);

            return response()->json([
                'success' => "Enrégistrement effectué avec succès",
                'redirect' => route($route)
            ], 200);

        }

        if (!is_null($data["etablissementsuperieur"]) && !is_null($data["specialite"])) {

            $dataPersonnes = [
                'series_id'=>$data['serie'],
                'diplomes_id'=>$data['diplome'],
                'etablissements_id'=>$data['etablissementsuperieur'],
                'specialites_id'=>$data['specialite'],
                'lycees_id'=>$data['lycee'],
            ];

            $personne->update($dataPersonnes);

            return response()->json([
                'success' => "Enrégistrement effectué avec succès",
                'redirect' => route($route)
            ], 200);

        }
        return response()->json([
            'errors' => [
                'formation' => [
                    "Veillez remplir tous les champs obligatoires.",
                ]
            ]
        ], 422);


    }

}
