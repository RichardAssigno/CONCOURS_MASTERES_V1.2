<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmploiController extends Controller
{

    public function index(){

        return view('emplois.index', [

            "personnes" => Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions")),
            "titre" => "Emploi du candidat",

        ]);

    }

    public function ajout(Request $request){

        $validator = Validator::make($request->all(),[
            'professions' => "required",
            'employeurs' => "required",
            'experiences' => "required",
        ],[
            'professions.required' => 'Le champ professions est obligatoire.',
            'employeurs.required' => 'Le champ employeurs est obligatoire.',
            'experiences.required' => 'Le champ experiences est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());

        $route = session("notes") === 1 ? "notes.index" : "choix.index";

        $dataPersonnes = [
            'professions'=>mb_strtoupper($data['professions']),
            'employeurs'=>mb_strtoupper($data['employeurs']),
            'experiences'=>mb_strtoupper($data['experiences']),
        ];

        $personne->update($dataPersonnes);

        return response()->json([
            'success' => "Enrégistrement effectué avec succès",
            'redirect' => route($route)
        ], 200);

    }

}
