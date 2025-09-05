<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Concour;
use App\Models\Concours;
use App\Models\Document;
use App\Models\Dossierscandidature;
use App\Models\Personne;
use App\Services\MatriculeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $matriculeService;

    public function __construct(MatriculeService $matriculeService)
    {
        $this->matriculeService = $matriculeService;
    }

    public function index(){

        return view('auth.login');

    }

    public function inscription($code = null){

        if(!is_null($code)){

            $concours = Concours::concoursaveccode($code);

            if(!is_null($concours)){

                return view('auth.register', [

                    "concours" => $concours

                ]);

            }


        }

        $concoursouvert = Concours::listeconcoursouvert();

        return view('auth.register', [

            "concoursouvert" => $concoursouvert

        ]);

    }

    public function ajoutinscription(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required', // 🔹 nom correct
            'sessions_id' => 'required|integer',
        ], [
            'email.required' => 'L\'Email est obligatoire',
            'email.email' => 'L\'Email doit être valide',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Il faut au moins 8 caractères pour le mot de passe',
            'password.confirmed' => 'Veuillez confirmer le mot de passe correctement',
            'password_confirmation.required' => 'La confirmation du mot de passe est obligatoire',
            'sessions_id.required' => 'Le Concours est obligatoire',
            'sessions_id.integer' => 'Le concours doit être un nombre entier',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $personne = Personne::query()->where("email", "=", $data["email"])->first();

        $documentacharger = Dossierscandidature::listedocumentcandidature($data['sessions_id']);

        if(!is_null($personne)){
            $candidatConcours = Concours::getConcoursCandidat($personne->id, $data['sessions_id']);

            Auth::guard('personne')->login($personne);
            $request->session()->regenerate(); // conseillé après login (anti fixation)

            if (!is_null($candidatConcours)){

                $this->miseensession($candidatConcours, $data['sessions_id']);

                $dataUpdate = [

                    "email" => $data["email"],
                    "password" => Hash::make($data["password"]),

                ];

                $personne->update($dataUpdate);

                return response()->json(['success' => "Connexion réussie"], 200);

            }else{

                $candidat = $this->creercandidat($personne, $data['sessions_id']);

                $candidatConcours = Concours::getConcoursCandidat($personne->id, $data['sessions_id']);

                $this->miseensession($candidatConcours, $data['sessions_id']);

                if ($documentacharger->isNotEmpty()){

                    foreach ($documentacharger as $value){

                        $dataDocument = [

                            "candidats_id" =>  $candidat->id,
                            "dossiersCandidature_id" =>  $value->idDossierCandidature,

                        ];

                        Document::create($dataDocument);

                    }

                }

                Auth::guard('personne')->login($personne);
                $request->session()->regenerate(); // conseillé après login (anti fixation)

                return response()->json(['success' => "Inscription réussie"], 200);

            }


        }

        $dataPersonne = [

            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "series_id" => 1,
            "diplomes_id" => 1,
            "specialites_id" => 1,
            "etablissements_id" => 2,
            "lycees_id" =>1,

        ];

        $personne = Personne::create($dataPersonne);

        $candidat = $this->creercandidat($personne, $data['sessions_id']);

        $candidatConcours = Concours::getConcoursCandidat($personne->id, $data['sessions_id']);

        $this->miseensession($candidatConcours, $data['sessions_id']);

        if ($documentacharger->isNotEmpty()){

            foreach ($documentacharger as $value){

                $dataDocument = [

                    "candidats_id" =>  $candidat->id,
                    "dossiersCandidature_id" =>  $value->idDossierCandidature,

                ];

                Document::create($dataDocument);

            }

        }

        Auth::guard('personne')->login($personne);
        $request->session()->regenerate(); // conseillé après login (anti fixation)


        return response()->json(['success' => "Inscription réussie"], 200);

    }

    public function recupererconcours(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [

            'email.required' => 'L\'Email est obligatoire',
            'password.required' => 'Le mot de passe est obligatoire',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        $remember = $request->filled('remember');

        if (Auth::guard('personne')->attempt($credentials, $remember)) {

            $concours = Concours::ConcoursCandidats(Auth::guard('personne')->id());

            return response()->json([
                'success' => true,
                'concours' => $concours
            ]);
        }

        return response()->json(['errors' => "Mot de passe ou email incorrect."], 422);

    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'sessions_id' => 'required|integer',
        ], [

            'email.required' => 'L\'Email est obligatoire',
            'password.required' => 'Le mot de passe est obligatoire',
            'sessions_id.required' => 'Le Concours est obligatoire',
            'sessions_id.integer' => 'Le concours doit être un nombre entier',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), $data['sessions_id']);

        if(!is_null($candidatConcours)){

            $this->miseensession($candidatConcours, $data['sessions_id']);

            $request->session()->regenerate();

            return response()->json(['success' => "Connexion réussie"], 200);

        }

        return response()->json(['errors' => "Impossible de se connecter. Veuillez réessayer."], 422);

    }

    public function connexionconcours(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'idSession' => 'required|integer'
        ], [

            "idSession.required" => "L'id de la session est obligatoire",

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validate();

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), $data['idSession']);

        $this->miseensession($candidatConcours, $data['idSession']);

        return response()->json([
            'success' => true,
            'message' => 'Concours changé avec succès !',
            'idSession' => $request->idSession
        ]);

    }

    public function logout(Request $request)
    {
        Auth::guard('personne')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.index');

    }

    private function creercandidat($personne, $idsession)
    {

        $matricule = $this->matriculeService->genererMatricule($idsession);

        $dataCandidat = [

            "matricule" => $matricule,
            "personnes_id" => $personne->id,
            "sessions_id" => $idsession,

        ];

        $candidat = Candidat::create($dataCandidat);

        return $candidat;

    }

    private function miseensession($candidatConcours, $sessions)
    {

        session()->put('candidatConcours', $candidatConcours);
        session()->put('sessions', $sessions);
        session()->put('notes', $candidatConcours->notes);
        session()->put('cycles', $candidatConcours->libelleCycles);
        session()->put('nombrefiliere', $candidatConcours->nombrefiliere);
        session()->put('photo_path', $candidatConcours->photo_path);
        session()->put('photo_type', $candidatConcours->photo_type);
        session()->put('photo_nom', $candidatConcours->photo_nom);
        session()->put('codeconcours', $candidatConcours->codeConcours);


    }


}
