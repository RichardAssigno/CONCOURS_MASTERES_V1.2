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

        //dd(Serie::query()->orderBy("libelle", "asc")->get());

        return view('formations.index', [
            "personnes" => Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions")),
            "diplomes" => Diplome::query()->orderBy("libelle", "asc")->get(),
            "series" => Serie::query()->orderBy("libelle", "asc")->get(),
            "specialites" => Specialite::query()->orderBy("libelle", "asc")->get(),
            "lycees" => Lycee::query()->orderBy("libelle", "asc")->get(),
            "etablissements" => Etablissement::query()->orderBy("libelle", "asc")->get(),
            "titre" => "Formation du candidat",
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
            'niveauetudes' => session("codeconcours") == "MSTAU"  ? "required|string|max:255" : "nullable",
        ],[
            'lycee.required' => 'Le lycée est obligatoire.',
            'serie.required' => 'La série est obligatoire.',
            'diplome.required' => 'Le diplôme est obligatoire.',
            'niveauetudes.required' =>session("codeconcours") == "MSTAU"  ? 'Veillez selectionner un niveau d\'etude.' : "",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), session("sessions"));

        if(mb_strtoupper($candidatConcours->codeConcours) == "MSTAU"){

            $route = "emploi.index";

        }elseif(session("notes") === "1") {

            $route = "notes.index";

        }else{

            $route =  "choix.index";

        }

        $lycee   = $this->createOrUpdateIfFilled($request, 'lycee_autre', Lycee::class);
        $serie   = $this->createOrUpdateIfFilled($request, 'serie_autre', Serie::class);
        $diplome = $this->createOrUpdateIfFilled($request, 'diplome_autre', Diplome::class);

        if (mb_strtoupper($candidatConcours->libelleCycles) == "BACHELIER") {

            $dataPersonnes = [
                'series_id'=>$serie ?? $data['serie'],
                'diplomes_id'=>$diplome ?? $data['diplome'],
                'lycees_id'=>$lycee ?? $data['lycee'],
                'niveauetudes'=> session("codeconcours") == "MSTAU"  ? $data['niveauetudes'] : null,
            ];

            $personne->update($dataPersonnes);

            return response()->json([
                'success' => "Enrégistrement effectué avec succès",
                'redirect' => route($route)
            ], 200);

        }

        if (!is_null($data["etablissementsuperieur"]) && !is_null($data["specialite"])) {

            $etablissement   = $this->createOrUpdateIfFilled($request, 'etablissement_autre', Etablissement::class);
            $specialite   = $this->createOrUpdateIfFilled($request, 'specialite_autre', Specialite::class);

            $dataPersonnes = [
                'series_id'=>$serie ?? $data['serie'],
                'diplomes_id'=>$diplome ?? $data['diplome'],
                'etablissements_id'=>$etablissement ?? $data['etablissementsuperieur'],
                'specialites_id'=>$specialite ?? $data['specialite'],
                'lycees_id'=>$lycee ?? $data['lycee'],
                'niveauetudes'=> session("codeconcours") == "MSTAU"  ? $data['niveauetudes'] : null,
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

    protected function createOrUpdateIfFilled($request, $field, $model)
    {
        if ($request->filled($field)) {

            $element = $model::updateOrCreate(
                ['libelle' => $request->$field],
                ['libelle' => mb_strtoupper($request->$field)]
            );

            return $element->id;
        }

        return null;
    }


}
