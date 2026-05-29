<?php

namespace App\Services;

use App\Models\Choix;
use App\Models\Document;
use App\Models\Formulaire;
use App\Models\Personne;
use Illuminate\Support\Facades\Auth;

class RedirecteurService
{
    public function redirecteur(): array
    {
        $candidat = Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions"));

        if (is_null($candidat)) {
            return $this->erreur('Aucune candidature active trouvee pour cette session.', 'tableaudebord.index');
        }

        if (!$this->infosPersonnellesCompletees($candidat)) {
            return $this->erreur("Veuillez renseigner toutes vos informations personnelles avant de continuer.", 'infos.index');
        }

        if (!$this->formationCompletee($candidat)) {
            return $this->erreur("Veuillez renseigner toutes vos informations de formation avant de continuer.", 'formation.index');
        }

        if ($this->emploiRequis() && !$this->emploiComplete($candidat)) {
            return $this->erreur("Veuillez renseigner vos informations d'emploi avant de continuer.", 'emploi.index');
        }

        if (!$this->notesAjoutees($candidat)) {
            return $this->erreur("Veuillez renseigner toutes vos notes avant de continuer.", 'notes.index');
        }

        if (!$this->choixConcoursValide($candidat)) {
            return $this->erreur("Veuillez choisir au moins une filiere avant de continuer.", 'choix.index');
        }

        if (!$this->ordreChoixValide($candidat)) {
            return $this->erreur("Veuillez ordonner vos choix avant de continuer.", 'choix.ordrechoix');
        }

        if (!$this->documentsCharges($candidat)) {
            return $this->erreur("Veuillez televerser tous les documents obligatoires avant de continuer.", 'documents.index');
        }

        return [
            'status' => 'ok',
            'message' => 'Dossier complet.',
            'route' => null,
        ];
    }

    public function premiereEtapeIncomplete(): ?array
    {
        $resultat = $this->redirecteur();

        return $resultat['status'] === 'ok' ? null : $resultat;
    }

    private function infosPersonnellesCompletees($candidat): bool
    {
        $champs = [
            'nom',
            'prenoms',
            'dateNaissance',
            'lieuNaissance',
            'telephone',
            'genre',
            'nomEtPrenomsDunProche',
            'telephoneDunProche',
            'idAnneebac',
        ];

        foreach ($champs as $champ) {
            if (!$this->renseigne($candidat->{$champ} ?? null)) {
                return false;
            }
        }

        if ($this->estConcoursMstau()) {
            return $this->renseigne($candidat->financements ?? null);
        }

        return true;
    }

    private function formationCompletee($candidat): bool
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

        if ($this->estConcoursMstau()) {
            return $this->renseigne($candidat->niveauetudes ?? null);
        }

        return true;
    }

    private function emploiComplete($candidat): bool
    {
        return $this->renseigne($candidat->professions ?? null)
            && $this->renseigne($candidat->employeurs ?? null)
            && $this->renseigne($candidat->experiences ?? null);
    }

    private function notesAjoutees($candidat): bool
    {
        if (!$this->notesRequises()) {
            return true;
        }

        $infos = Formulaire::getInfosMoyennesCandidat($candidat->idCandidat, session("sessions"));

        return $infos->isNotEmpty()
            && $infos->every(fn ($note) => $this->renseigne($note->moyenne ?? null));
    }

    private function choixConcoursValide($candidat): bool
    {
        return Choix::getChoixCandidat($candidat->idPersonne, session("sessions"))->isNotEmpty();
    }

    private function ordreChoixValide($candidat): bool
    {
        if ((int) session('nombrefiliere') <= 1) {
            return true;
        }

        $choix = Choix::getChoixCandidat($candidat->idPersonne, session("sessions"));

        return $choix->isNotEmpty()
            && $choix->every(fn ($item) => $this->renseigne($item->ordreChoix ?? null));
    }

    private function documentsCharges($candidat): bool
    {
        $documents = Document::getListeDocuments($candidat->idCandidat);
        $documentsRequis = Document::getDocuments(session("sessions"))
            ->filter(fn ($document) => (int) $document->requis === 1);

        if ($documentsRequis->isEmpty()) {
            return true;
        }

        foreach ($documentsRequis as $documentRequis) {
            $documentCandidat = $documents->firstWhere('idDossiercandidature', $documentRequis->idDossiercandidature);

            if (is_null($documentCandidat) || !$this->renseigne($documentCandidat->filePath ?? null)) {
                return false;
            }
        }

        return true;
    }

    private function notesRequises(): bool
    {
        return (string) session('notes') === '1';
    }

    private function emploiRequis(): bool
    {
        return $this->estConcoursMstau();
    }

    private function estConcoursMstau(): bool
    {
        return mb_strtoupper((string) session('codeconcours')) === 'MSTAU';
    }

    private function selectionValide($value, array $valeursInvalides): bool
    {
        return $this->renseigne($value) && !in_array((int) $value, $valeursInvalides, true);
    }

    private function renseigne($value): bool
    {
        return !is_null($value) && trim((string) $value) !== '';
    }

    private function erreur(string $message, string $route): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'route' => $route,
        ];
    }
}
