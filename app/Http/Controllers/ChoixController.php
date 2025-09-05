<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Choix;
use App\Models\Concours;
use App\Models\Filiere;
use App\Models\Personne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChoixController extends Controller
{

    public function index(){

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), session("sessions"));



        if (session("notes") === 1) {

            $routeretour = "notes.index";

        }elseif (mb_strtoupper($candidatConcours->codeConcours) == "MSTAU"){

            $routeretour = "emploi.index";

        }else{

            $routeretour = "formation.index";

        }


        return view('choix.index', [
            "choix" => Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions")),
            "filieres" => Filiere::getConcoursFilieres(session('sessions')),
            "routeretour" => $routeretour,

        ]);

    }

    public function ajout(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'choix' => "required|array",
        ],[
            'choix.required' => 'Le choix est obligatoire.',
            'choix.array' => 'Le choix doit être un tableau.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        $choix = Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions"));

        $route = session("nombrefiliere") > 1 ? "choix.ordrechoix" : "documents.index";

        if ($choix->isNotEmpty()){

            $choix->each->delete();

        }

        foreach ($data['choix'] as $key => $choix) {

            $dataChoix = [

                'candidats_id' => $candidat->id,
                'filieres_id' => $choix,
                'choix' => $key + 1,
                'ordreChoix' => $key + 1,

            ];

            Choix::query()->create($dataChoix);

        }

        return response()->json([
            'success' => "Enrégistrement effectué avec succès",
            'redirect' => route($route)
        ]);

    }

    public function ordrechoix(){

        return view('choix.ordrechoix', [

            "choix" => Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions")),

        ]);

    }

    public function ajoutordrechoix(Request $request){

        $data = $request->except("_token");

        foreach ($data as $key => $choix) {

            $choixpersonne = Choix::query()->findOrFail($key);

            $dataChoix = [
                "ordreChoix" => $choix,
            ];

            //dd($choixpersonne,$dataChoix);

            $choixpersonne->update($dataChoix);
        }


        return response()->json(['success' => "Enrégistrement effectué avec succès"], 200);

    }

}
