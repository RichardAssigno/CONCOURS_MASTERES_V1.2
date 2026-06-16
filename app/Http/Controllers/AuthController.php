<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Concour;
use App\Models\Concours;
use App\Models\Document;
use App\Models\Dossierscandidature;
use App\Models\Personne;
use App\Models\Session;
use App\Services\MatriculeService;
use Carbon\Carbon;
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

    public function login($code = null){

        return view('auth.login', [

            'codeConcours' => $code,

        ]);

    }

    public function inscription($code = null){

        if(!is_null($code)){

            $concours = Concours::concoursaveccode($code);

            if(!is_null($concours)){

                return view('auth.register', [
                    "concours" => $concours,
                    "codeConcours" => $code,
                ]);

            }


        }

        $concoursouvert = Concours::listeconcoursouvert();

        return view('auth.register', [

            "concoursouvert" => $concoursouvert,
            "codeConcours" => $code,

        ]);

    }

    public function ajoutinscription(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:personnes,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required', // 🔹 nom correct
            'sessions_id' => 'required|integer',
        ], [
            'email.required' => 'L\'Email est obligatoire',
            'email.email' => 'L\'Email doit être valide',
            'email.unique' => 'Votre email existe déjà dans la base de donnée. Si vous voulez postuler à un autre concours, veillez vous connectez, puis choisissez le concours souhaité',
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

        $calendrier = Session::getCalendrierBySession($data['sessions_id']);

        $dateDebut = $this->parseDateSmart($calendrier->dateDebut);
        $dateFin   = $this->parseDateSmart($calendrier->dateFin);

        $today     = Carbon::today();

        if (!($today->between($dateDebut, $dateFin))) {

            $session = Session::query()->findOrFail($data['sessions_id']);

            $date = Carbon::parse($dateFin)->format('d/m/Y');

            $session->update([

                "statut" => 0,

            ]);

            return response()->json(['errors' => "Les inscriptions pour ce concours ont pris fin le $date"], 422);

        }

        $personne = Personne::query()->where("email", "=", $data["email"])->first();

        $documentacharger = Dossierscandidature::listedocumentcandidature($data['sessions_id']);

        if(is_null($personne)){

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



    }

    public function inscriptionconcours($idSession)
    {
        $calendrier = Session::getCalendrierBySession($idSession);
        $dateDebut = $this->parseDateSmart($calendrier->dateDebut);
        $dateFin   = $this->parseDateSmart($calendrier->dateFin);

        $today = Carbon::today();

        if (!($today->between($dateDebut, $dateFin))) {

            $session = Session::query()->findOrFail($idSession);

            $date = Carbon::parse($dateFin)->format('d/m/Y');

            $session->update([

                "statut" => 0,

            ]);

            return response()->json(['errors' => "Les inscriptions pour ce concours ont pris fin le $date"], 422);

        }

        $personne = Personne::query()->findOrFail(Auth::guard('personne')->id());

        $documentacharger = Dossierscandidature::listedocumentcandidature($idSession);

        $candidatConcours = Concours::getConcoursCandidat($personne->id, $idSession);

        if (is_null($candidatConcours)){

            $candidat = $this->creercandidat($personne, $idSession);

            $candidatConcours = Concours::getConcoursCandidat($candidat->personnes_id, $idSession);

            $this->miseensession($candidatConcours, $idSession);

            if ($documentacharger->isNotEmpty()){

                foreach ($documentacharger as $value){

                    $dataDocument = [

                        "candidats_id" =>  $candidat->id,
                        "dossiersCandidature_id" =>  $value->idDossierCandidature,

                    ];

                    Document::query()->create($dataDocument);

                }

            }

            $redirectUrl = redirect()->intended(route('home'))->getTargetUrl();

            return response()->json([
                'success' => "Connexion réussie",
                'redirect' => $redirectUrl
            ], 200);

        }

        return response()->json(['errors' => "Vous êtes déjà inscrit à ce concours, veillez vous connectez"], 422);

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

        $remember = $request->boolean('remember');

        if (Auth::guard('personne')->attempt($credentials, $remember)) {

            $request->session()->regenerate();

            $concours = Concours::ConcoursCandidats(Auth::guard('personne')->id());

            if ($concours->isEmpty()) {
                Auth::guard('personne')->logout();

                return response()->json(['errors' => "Aucune candidature active n'est rattachee a ce compte."], 422);
            }

            $sessionId = $concours->first()->idSession;
            $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), $sessionId);

            if (is_null($candidatConcours)) {
                return response()->json(['errors' => "Impossible de charger la session du candidat."], 422);
            }

            $this->synchroniserDocumentsCandidat($candidatConcours, $sessionId);
            $this->miseensession($candidatConcours, $sessionId);

            return response()->json([
                'success' => true,
                'redirect' => route('tableaudebord.index')
            ]);
        }

        return response()->json(['errors' => "Mot de passe ou email incorrect."], 422);

    }

    public function index($idSession)
    {

        $candidatConcours = Concours::getConcoursCandidat(Auth::guard('personne')->id(), $idSession);

        $documentsCandidat = Document::where('candidats_id', $candidatConcours->idCandidat)
            ->pluck('dossiersCandidature_id')
            ->toArray();

        $documentsACharger = Dossierscandidature::where('sessions_id', $idSession)
            ->pluck('id')
            ->toArray();

        // On cherche les documents manquants
        $documentsManquants = array_diff($documentsACharger, $documentsCandidat);

        // S'il y a des documents à ajouter
        if (!empty($documentsManquants)) {

            foreach ($documentsManquants as $idDossier) {

                Document::create([
                    'candidats_id' => $candidatConcours->idCandidat,
                    'dossiersCandidature_id' => $idDossier,
                ]);
            }
        }


        if(!is_null($candidatConcours)){

            $this->miseensession($candidatConcours, $idSession);

            /*$redirectUrl = redirect()->intended(route('home'))->getTargetUrl();*/
            $redirectUrl = session()->pull('url.intended', route('home'));


            return response()->json([
                'success' => htmlspecialchars("Connexion réussie"),
                'redirect' => $redirectUrl
            ], 200);

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

        $documentsCandidat = Document::where('candidats_id', $candidatConcours->idCandidat)
            ->pluck('dossiersCandidature_id')
            ->toArray();

        $documentsACharger = Dossierscandidature::where('sessions_id', $data['idSession'])
            ->pluck('id')
            ->toArray();

        // On cherche les documents manquants
        $documentsManquants = array_diff($documentsACharger, $documentsCandidat);

        // S'il y a des documents à ajouter
        if (!empty($documentsManquants)) {

            foreach ($documentsManquants as $idDossier) {

                Document::create([
                    'candidats_id' => $candidatConcours->idCandidat,
                    'dossiersCandidature_id' => $idDossier,
                ]);
            }
        }

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

        return redirect()->route('login');

    }

    private function synchroniserDocumentsCandidat($candidatConcours, $idSession): void
    {
        $documentsCandidat = Document::where('candidats_id', $candidatConcours->idCandidat)
            ->pluck('dossiersCandidature_id')
            ->toArray();

        $documentsACharger = Dossierscandidature::where('sessions_id', $idSession)
            ->pluck('id')
            ->toArray();

        $documentsManquants = array_diff($documentsACharger, $documentsCandidat);

        foreach ($documentsManquants as $idDossier) {
            Document::create([
                'candidats_id' => $candidatConcours->idCandidat,
                'dossiersCandidature_id' => $idDossier,
            ]);
        }
    }

    private function creercandidat($personne, $idsession)
    {

        $matricule = $this->matriculeService->genererMatricule($idsession);

        $dataCandidat = [

            "matricule" => $matricule,
            "personnes_id" => $personne->id,
            "sessions_id" => $idsession,

        ];

        $candidat = Candidat::query()->create($dataCandidat);

        return $candidat;

    }

    public function recupererphoto($idCandidat)
    {

        $candidat = Candidat::getPhotoByCandidatId($idCandidat);

        // Génère une URL complète vers la photo
        $photoUrl = url('/storage/' . $candidat->photo_path);

        return response()->json([
            'success' => true,
            'photo_url' => $photoUrl
        ]);

    }
    public function recupererpdf($idCandidatDocument)
    {
        $elements = explode("_", $idCandidatDocument);

        $idCandidat = $elements[0];
        $idDocument = $elements[1];

        $document = Candidat::getDocumentByCandidat($idCandidat, $idDocument);

        // Chemin physique du fichier
        $file = storage_path('app/public/' . $document->filePath);

        $parts = explode('/public/public/', $file);

        if (count($parts) >= 2) {
            // Remplacer uniquement la DERNIÈRE occurrence de /public/
            $newPath = preg_replace('/public\/(?!.*public)/', 'documents/', $file);
        } else {
            // Une seule occurrence → on ne change rien
            $newPath = $file;
        }

        if (!file_exists($newPath)) {
            abort(404, "Fichier introuvable.");
        }

        // Retourne le PDF directement dans le navigateur
        return response()->file($newPath);
    }


    public function connecteretudiant($idCandidatSession)
    {

        $elements = explode("_", $idCandidatSession);

        $idCandidat = $elements[0];

        $idSession = $elements[1];

        $candidat = Candidat::getPhotoByCandidatId($idCandidat);

        $candidatConcours = Concours::getConcoursCandidat($candidat->idPersonne, $idSession);

        $documentsCandidat = Document::where('candidats_id', $candidatConcours->idCandidat)
            ->pluck('dossiersCandidature_id')
            ->toArray();

        $documentsACharger = Dossierscandidature::where('sessions_id', $idSession)
            ->pluck('id')
            ->toArray();

        // On cherche les documents manquants
        $documentsManquants = array_diff($documentsACharger, $documentsCandidat);

        // S'il y a des documents à ajouter
        if (!empty($documentsManquants)) {

            foreach ($documentsManquants as $idDossier) {

                Document::create([
                    'candidats_id' => $candidatConcours->idCandidat,
                    'dossiersCandidature_id' => $idDossier,
                ]);
            }
        }

        if (Auth::guard('personne')->loginUsingId($candidatConcours->idPersonne)) {

            $this->miseensession($candidatConcours, $idSession);

            return redirect()->route('tableaudebord.index', ['idSession' => $idSession])
                ->with('succes', 'Vous êtes connectés à la plateforme du candidat !');

        }

        return redirect()->route('login.index')->with('echec', 'Impossible de se connecter !');


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

    private function parseDateSmart($date)
    {

        // Déjà un Carbon → on retourne
        if ($date instanceof Carbon) {
            return $date;
        }

        if (empty($date)) {
            return null;
        }

        $date = trim($date);



        // Format FR : 14/07/2025
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return Carbon::createFromFormat('d/m/Y', $date);
        }

        // Format FR avec heure : 14/07/2025 00:00:00
        if (preg_match('/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2}$/', $date)) {
            return Carbon::createFromFormat('d/m/Y H:i:s', $date);
        }

        // Format ISO : 2025-11-10 ou 2025-11-10 00:00:00
        return Carbon::parse($date);
    }


}
