<?php

namespace App\Http\Controllers;

use App\Models\Choix;
use App\Models\Concours;
use App\Models\Document;
use App\Models\Formulaire;
use App\Models\Personne;
use App\Services\RedirecteurService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TableaudebordController extends Controller
{
    protected $redirecteurService;

    public function __construct(RedirecteurService $redirecteurService)
    {
        $this->redirecteurService = $redirecteurService;
    }

    public function index()
    {
        return view('tableaudebord.index', $this->dashboardPayload("Tableau de bord"));
    }

    public function profil()
    {
        return view('profil.index', $this->dashboardPayload("Profil"));
    }

    public function modifierMotDePasse(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'Veuillez confirmer le nouveau mot de passe correctement.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caracteres.',
        ]);

        $personne = Personne::query()->findOrFail(Auth::guard('personne')->id());

        if (!Hash::check($data['current_password'], $personne->password)) {
            return back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $personne->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('succes', 'Mot de passe modifie avec succes.');
    }

    public function recupererconcours(Request $request)
    {
        $concours = Concours::listeconcoursouvert();

        return response()->json([
            'success' => true,
            'concours' => $concours
        ]);
    }

    private function dashboardPayload(string $titre): array
    {
        $idPersonne = Auth::guard('personne')->id();
        $tousLesConcoursPostules = Concours::ConcoursCandidats($idPersonne);
        $tousLesConcoursOuverts = Concours::listeconcoursouvert();
        $anneesDisponibles = $this->anneesDisponibles($tousLesConcoursPostules, $tousLesConcoursOuverts);
        $anneeSelectionnee = $this->anneeSelectionnee($anneesDisponibles);

        $listeconcours = $tousLesConcoursPostules
            ->filter(fn ($concours) => (string) $concours->libelleAnnee === (string) $anneeSelectionnee)
            ->values();

        if ($listeconcours->isNotEmpty() && !$listeconcours->pluck('idSession')->contains((int) session('sessions'))) {
            $sessionParDefaut = $listeconcours->first()->idSession;
            $candidatConcours = Concours::getConcoursCandidat($idPersonne, $sessionParDefaut);

            if (!is_null($candidatConcours)) {
                $this->mettreConcoursEnSession($candidatConcours, $sessionParDefaut);
            }
        }

        if (!session()->has('sessions') && $tousLesConcoursPostules->isNotEmpty()) {
            $sessionParDefaut = $tousLesConcoursPostules->first()->idSession;
            $candidatConcours = Concours::getConcoursCandidat($idPersonne, $sessionParDefaut);

            if (!is_null($candidatConcours)) {
                $this->mettreConcoursEnSession($candidatConcours, $sessionParDefaut);
            }
        }

        $sessionId = session('sessions');
        $personnes = Personne::getInfosCandidat($idPersonne, $sessionId);

        if (is_null($personnes)) {
            abort(404, "Aucune candidature active trouvee pour cette session.");
        }

        $notesBrutes = Formulaire::getInfosMoyennesCandidat($personnes->idCandidat, $sessionId);
        $typesmoyennes = $notesBrutes->pluck('libelleTypemoyenne', 'idTypemoyenne')->unique();
        $infos = $notesBrutes->groupBy('libelleDiscipline');
        $choix = Choix::getChoixCandidat($idPersonne, $sessionId);
        $documentscandidat = Document::getDocumentsCandidat($personnes->idCandidat);
        $documents = Document::getDocuments($sessionId);
        $concoursOuverts = $tousLesConcoursOuverts->values();

        $sessionsPostulees = $tousLesConcoursPostules->pluck('idSession')->unique()->values();
        $concoursOuverts = $concoursOuverts->map(function ($concours) use ($sessionsPostulees) {
            $concours->dejaPostule = $sessionsPostulees->contains($concours->idSession);
            return $concours;
        });

        $infosPersonnellesCompletes = $this->infosPersonnellesCompletes($personnes);
        $formationComplete = $this->formationComplete($personnes);
        $emploiComplete = $this->emploiComplete($personnes);
        $notesCompletes = $this->notesCompletes($notesBrutes);
        $choixComplets = $choix->isNotEmpty();
        $documentsComplets = $this->documentsComplets($documents, Document::getListeDocuments($personnes->idCandidat));

        $etapes = collect([
            [
                'label' => 'Infos personnelles',
                'complete' => $infosPersonnellesCompletes,
                'route' => route('infos.index'),
                'icon' => 'person-outline',
                'hint' => 'Completer votre identite',
            ],
            [
                'label' => 'Formation',
                'complete' => $formationComplete,
                'route' => route('formation.index'),
                'icon' => 'book-open-outline',
                'hint' => 'Renseigner votre parcours',
            ],
        ]);

        if (mb_strtoupper((string) session('codeconcours')) === 'MSTAU') {
            $etapes->push([
                'label' => 'Emploi',
                'complete' => $emploiComplete,
                'route' => route('emploi.index'),
                'icon' => 'briefcase-outline',
                'hint' => "Renseigner votre emploi",
            ]);
        }

        if ($this->notesAttendues()) {
            $etapes->push([
                'label' => 'Notes',
                'complete' => $notesCompletes,
                'route' => route('notes.index'),
                'icon' => 'edit-2-outline',
                'hint' => 'Saisir les moyennes demandees',
            ]);
        }

        $etapes->push([
            'label' => 'Choix',
            'complete' => $choixComplets,
            'route' => route('choix.index'),
            'icon' => 'layers-outline',
            'hint' => 'Choisir la ou les filieres',
        ]);

        if ((int) session('nombrefiliere') > 1) {
            $etapes->push([
                'label' => 'Ordre des choix',
                'complete' => $choix->isNotEmpty() && $choix->every(fn ($item) => !is_null($item->ordreChoix)),
                'route' => route('choix.ordrechoix'),
                'icon' => 'list-outline',
                'hint' => 'Classer vos choix',
            ]);
        }

        $etapes->push([
            'label' => 'Documents',
            'complete' => $documentsComplets,
            'route' => route('documents.index'),
            'icon' => 'folder-outline',
            'hint' => 'Televerser les pieces demandees',
        ]);

        $etapesValidees = $etapes->filter(fn ($etape) => $etape['complete'])->count();
        $progression = $etapes->isEmpty() ? 0 : (int) round(($etapesValidees / $etapes->count()) * 100);
        $prochaineEtape = $etapes->first(fn ($etape) => !$etape['complete']);

        return [
            'titre' => $titre,
            'personne' => $personnes,
            'anneeSelectionnee' => $anneeSelectionnee,
            'anneesDisponibles' => $anneesDisponibles,
            'anneeEstCourante' => $this->anneeEstCourante($anneeSelectionnee),
            'listeconcours' => $listeconcours,
            'concoursOuverts' => $concoursOuverts,
            'choix' => $choix,
            'typesmoyennes' => $typesmoyennes,
            'infos' => $infos,
            'documentscandidat' => $documentscandidat,
            'documents' => $documents,
            'nbrdoc' => $documentscandidat->count(),
            'infosPersonnellesCompletes' => $infosPersonnellesCompletes,
            'formationComplete' => $formationComplete,
            'emploiComplete' => $emploiComplete,
            'notesCompletes' => $notesCompletes,
            'choixComplets' => $choixComplets,
            'documentsComplets' => $documentsComplets,
            'etapes' => $etapes,
            'progression' => $progression,
            'prochaineEtape' => $prochaineEtape,
        ];
    }

    private function anneesDisponibles($concoursPostules, $concoursOuverts)
    {
        return $concoursPostules
            ->pluck('libelleAnnee')
            ->merge($concoursOuverts->pluck('libelleAnnee'))
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();
    }

    private function anneeSelectionnee($anneesDisponibles): ?string
    {
        $anneeDemandee = request('annee');

        if ($anneeDemandee && $anneesDisponibles->contains($anneeDemandee)) {
            session()->put('annee_selectionnee', $anneeDemandee);
            return $anneeDemandee;
        }

        if (session()->has('annee_selectionnee') && $anneesDisponibles->contains(session('annee_selectionnee'))) {
            return session('annee_selectionnee');
        }

        $anneeCourante = (string) now()->year;
        $anneeParDefaut = $anneesDisponibles->first(fn ($annee) => str_contains((string) $annee, $anneeCourante))
            ?? $anneesDisponibles->first();

        if ($anneeParDefaut) {
            session()->put('annee_selectionnee', $anneeParDefaut);
        }

        return $anneeParDefaut;
    }

    private function anneeEstCourante(?string $annee): bool
    {
        if (is_null($annee)) {
            return false;
        }

        return str_contains((string) $annee, (string) now()->year);
    }

    private function infosPersonnellesCompletes($candidat): bool
    {
        $champs = [
            'nom',
            'prenoms',
            'dateNaissance',
            'lieuNaissance',
            'genre',
            'telephone',
            'nomEtPrenomsDunProche',
            'telephoneDunProche',
            'idAnneebac',
        ];

        foreach ($champs as $champ) {
            if (!$this->valeurRenseignee($candidat->{$champ} ?? null)) {
                return false;
            }
        }

        if (mb_strtoupper((string) session('codeconcours')) === 'MSTAU') {
            return $this->valeurRenseignee($candidat->financements ?? null);
        }

        return true;
    }

    private function formationComplete($candidat): bool
    {
        if (!$this->selectionValide($candidat->idLycee ?? null, [1])
            || !$this->selectionValide($candidat->idSerie ?? null, [1])
            || !$this->selectionValide($candidat->idDiplome ?? null, [0, 1])) {
            return false;
        }

        if (mb_strtoupper((string) session('cycles')) !== 'BACHELIER') {
            if (!$this->selectionValide($candidat->idEtablissement ?? null, [2])
                || !$this->selectionValide($candidat->idSpecialite ?? null, [1])) {
                return false;
            }
        }

        if (mb_strtoupper((string) session('codeconcours')) === 'MSTAU') {
            return $this->valeurRenseignee($candidat->niveauetudes ?? null);
        }

        return true;
    }

    private function notesCompletes($notes): bool
    {
        if (!$this->notesAttendues()) {
            return true;
        }

        return $notes->isNotEmpty() && $notes->every(fn ($note) => $this->valeurRenseignee($note->moyenne ?? null));
    }

    private function emploiComplete($candidat): bool
    {
        if (mb_strtoupper((string) session('codeconcours')) !== 'MSTAU') {
            return true;
        }

        return $this->valeurRenseignee($candidat->professions ?? null)
            && $this->valeurRenseignee($candidat->employeurs ?? null)
            && $this->valeurRenseignee($candidat->experiences ?? null);
    }

    private function documentsComplets($documentsAttendus, $documentsCandidat): bool
    {
        $documentsRequis = $documentsAttendus->filter(fn ($document) => (int) $document->requis === 1);

        if ($documentsRequis->isEmpty()) {
            return true;
        }

        foreach ($documentsRequis as $documentRequis) {
            $documentCandidat = $documentsCandidat->firstWhere('idDossiercandidature', $documentRequis->idDossiercandidature);

            if (is_null($documentCandidat) || !$this->valeurRenseignee($documentCandidat->filePath ?? null)) {
                return false;
            }
        }

        return true;
    }

    private function notesAttendues(): bool
    {
        return (string) session('notes') === '1';
    }

    private function valeurRenseignee($value): bool
    {
        return !is_null($value) && trim((string) $value) !== '';
    }

    private function selectionValide($value, array $valeursInvalides): bool
    {
        if (!$this->valeurRenseignee($value)) {
            return false;
        }

        return !in_array((int) $value, $valeursInvalides, true);
    }

    private function mettreConcoursEnSession($candidatConcours, $sessions): void
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
