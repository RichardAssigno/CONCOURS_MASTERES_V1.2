<?php
namespace App\Services;

use App\Models\Candidat;
use App\Models\Choix;
use App\Models\Document;
use App\Models\Equivalence;
use App\Models\Formulaire;
use App\Models\Note;
use App\Models\Personne;
use App\Models\Supportsmd;
use Illuminate\Support\Facades\Auth;

class RedirecteurService
{
    public function redirecteur()
    {

        $infosCandidats = Personne::getInfosCandidat(Auth::guard("personne")->id(), session("sessions"));

        $v = '1';


        if (is_null($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Matricule inconnu',
                'route' => 'home' // route à rediriger si besoin
            ];
        }

        if (!$this->ajoutinfopersonnelles($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Une ou plusieurs informations personnelles n\'ont pas été ajoutées',
                'route' => 'infos.index'
            ];
        }

        if (!$this->ajoutformation($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Une ou plusieurs informations de formation n\'ont pas été ajoutées',
                'route' => 'formation.index'
            ];
        }

        if (!$this->notesajouter($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Une ou plusieurs notes n\'ont pas été ajoutées',
                'route' => 'notes.index'
            ];
        }

        if (!$this->verifchoixconcours($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Le candidat n\'a pas choisi de concours',
                'route' => 'choix.index'
            ];
        }

        if (!$this->verifdocumentcharger($infosCandidats)) {
            return [
                'status' => 'error',
                'message' => 'Veillez téléverser tous les documents',
                'route' => 'documents.index'
            ];
        }

        return [
            'status' => 'ok'
        ];

    }

    private function ajoutinfopersonnelles($candidat)
    {

        $values = collect([$candidat->nom, $candidat->prenoms,$candidat->dateNaissance, $candidat->lieuNaissance, $candidat->telephone, $candidat->genre, $candidat->nomEtPrenomsDunProche, $candidat->telephoneDunProche]);

        if ($values->contains(null)) {
            return false;
        } else {

            return true;
        }

    }

    private function ajoutformation($candidat)
    {
        if (session()->has('cycles')) {

            if (mb_strtoupper(session('cycles')) === 'BACHELIER'){

                return $candidat->idLycee != 1 &&
                    $candidat->idDiplome != 1 &&
                    $candidat->idSerie != 1
                    ;

            }

            return $candidat->idLycee != 1 &&
                $candidat->idEtablissement != 2 &&
                $candidat->idDiplome != 1 &&
                $candidat->idSpecialite != 1 &&
                $candidat->idSerie != 1
                ;

        }

    }

    private function notesajouter($infosCandidats)
    {

        $infos = Formulaire::getInfosMoyennesCandidat($infosCandidats->idCandidat, session("sessions"));

        if (session()->has('notes')) {

            if (session("notes") === 1){

                foreach ($infos as $value) {

                    if (is_null($value->moyenne)) {

                        return false;

                    }

                }

            }else{

                return true;
            }

        }



        return true;


    }

    private function verifchoixconcours($infosCandidats)
    {

        $choixcandidat = Choix::getChoixCandidat($infosCandidats->idPersonne, session("sessions"));

        return $choixcandidat->isNotEmpty();

    }

    private function verifdocumentcharger($infosCandidats)
    {

        $document =Document::getDocumentsCandidat($infosCandidats->idCandidat);

        if ($document->isNotEmpty()) {

            foreach ($document as $value) {

                if (is_null($value->filePath) && $value->requis == 1) {

                    return false;

                }

            }

        }

        return true;

    }


}
