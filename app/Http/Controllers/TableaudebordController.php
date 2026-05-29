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
        $listeconcours = Concours::ConcoursCandidats($idPersonne);

        if (!session()->has('sessions') && $listeconcours->isNotEmpty()) {
            $sessionParDefaut = $listeconcours->first()->idSession;
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
        $concoursOuverts = Concours::listeconcoursouvert();

        $sessionsPostulees = $listeconcours->pluck('idSession')->unique()->values();
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
