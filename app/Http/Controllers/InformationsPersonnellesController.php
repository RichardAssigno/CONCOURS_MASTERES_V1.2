<?php

namespace App\Http\Controllers;

use App\Models\AnneeBac;
use App\Models\Personne;
use App\Models\Photos;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InformationsPersonnellesController extends Controller
{

    public function index(){

        $anneebacs = AnneeBac::query()->orderBy("id", "desc")->get();

        $personne = Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions"));

        return view('informationspersonnelles.index', [

            "anneebacs" => $anneebacs,
            "personnes"  => $personne,
            "titre"  => "Informations Personnelles",

        ]);

    }

    public function ajoutphoto(Request $request){

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $path = $file->store('photos', 'public'); // sauvegarde dans storage/app/public/photos

            $photo = Photos::query()->create([
                'photo_path' => $path,
                'photo_type' => $file->getMimeType(),
                'photo_nom'  => $file->getClientOriginalName(),
            ]);

            $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());
            $personne->update(['photos_id' => $photo->id]);

            return response()->json([
                'fileName' => $path,
                'url' => asset("storage/".$path),
                'photo_nom' => $photo->photo_nom,
            ]);

        }

        return response()->json([
            'success' => false,
            'message' => 'Aucun fichier reçu'
        ], 400);

    }


    public function supprimerphoto(Request $request){

        $fileName = $request->fileName;

        $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());

        // Supprimer du storage
        if (\Storage::disk('public')->exists($fileName)) {

            \Storage::disk('public')->delete($fileName);
        }

        $photo = Photos::query()->findOrFail($personne->photos_id);

        Personne::where('photos_id', $personne->photos_id)->update(['photos_id' => null]);

        $photo->delete();

        return response()->json(['success' => true]);

    }


    public function ajout(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'nom' => "required|string|max:255",
            'prenoms' => "required|string|max:255",
            'dateNaissance' => "required|string|max:255",
            'lieuNaissance' => "required|string|max:255",
            'genre' => "required|string",
            'telephone' => "required|string|max:10",
            'nomEtPrenomsDunProche' => "required|string|max:255",
            'telephoneDunProche' => "required|string|max:255",
            'anneebacs_id' => "required|integer",
        ],[
            'nom.required' => 'Le nom est obligatoire.',
            'prenoms.required' => 'Le prénoms est obligatoire.',
            'dateNaissance.required' => 'La date de Naissance est obligatoire.',
            'lieuNaissance.required' => 'Le Lieu de Naissance est obligatoire.',
            'genre.required' => 'Le genre est obligatoire.',
            'telephone.required' => 'Le numéro de Téléphone est obligatoire.',
            'nomEtPrenomsDunProche.required' => 'Le Nom de votre Proche est obligatoire.',
            'telephoneDunProche.required' => 'Le Téléphone de votre Proche est obligatoire.',
            'anneebacs_id.required' => 'L\'Année du BAC est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $personne = Personne::query()->findOrFail(Auth::guard("personne")->id());

        $session = Session::query()->findOrFail(session("sessions"));

        $age = Carbon::parse($data["dateNaissance"])->age;

        $bac = AnneeBac::query()->findOrFail($data["anneebacs_id"]);

        $anneebac = Carbon::now()->year - $bac->libelle;

        if ($age <= $session->ageMaxPersonne) {

            if ($anneebac <= $session->ageMaxBac) {

                $dataPersonnes = [
                    'nom'=>mb_strtoupper($data['nom']),
                    'prenoms'=>mb_strtoupper($data['prenoms']),
                    'dateNaissance'=>$data['dateNaissance'],
                    'lieuNaissance'=>mb_strtoupper($data['lieuNaissance']),
                    'genre'=>mb_strtoupper($data['genre']),
                    'telephone'=>$data['telephone'],
                    'nomEtPrenomsDunProche'=>mb_strtoupper($data['nomEtPrenomsDunProche']),
                    'telephoneDunProche'=>$data['telephoneDunProche'],
                    'anneeBacs_id'=>$data['anneebacs_id'],
                ];

                $personne->update($dataPersonnes);

                $personnepourphoto = Personne::getInfosCandidat($personne->id, session("sessions"));

                session()->put('photo_path', $personnepourphoto->photo_path);

                return response()->json(['success' => "Enrégistrement effectué avec succès"], 200);

            }

          return response()->json([
                'errors' => [
                    'anneebac' => [
                        "Impossible de continuer votre inscription l'age ($anneebac) de votre BAC depasse l'âge maximum ($session->ageMaxBac) pour postuler à ce concours."
                    ]
                ]
            ], 422);


        }

        return response()->json([
            'errors' => [
                'age' => [
                    "Impossible de continuer votre inscription : votre âge ($age) dépasse l'âge maximum ($session->ageMaxPersonne) pour postuler à ce concours."
                ]
            ]
        ], 422);

    }

}
