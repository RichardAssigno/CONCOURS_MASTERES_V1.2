<?php

namespace App\Http\Controllers;

use App\Models\Choix;
use App\Models\Concours;
use App\Models\Document;
use App\Models\Formulaire;
use App\Models\Personne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableaudebordController extends Controller
{

    public function index(){

        $personnes = Personne::getInfosCandidat(Auth::guard('personne')->id(), session('sessions'));

        $infos = Formulaire::getInfosMoyennesCandidat($personnes->idCandidat, session("sessions"));

        // On récupère les types de moyennes distincts
        $typesmoyennes = $infos->pluck('libelleTypemoyenne', 'idTypemoyenne')->unique();

        // On groupe les infos par discipline
        $infos = $infos->groupBy('libelleDiscipline');

        $nbrdoc = 0;

        $documents = Document::getDocumentsCandidat($personnes->idCandidat);

        foreach ($documents as $document) {

            if (!is_null($document->filePath)) {

                $nbrdoc++;

            }

        }

        return view('tableaudebord.index', [

            "titre" => "Tableau de bord",
            "personne" => $personnes,
            "listeconcours" => Concours::ConcoursCandidats(Auth::guard('personne')->id()),
            "choix" => Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions")),
            "typesmoyennes" => $typesmoyennes,
            "infos" => $infos,
            "documentscandidat" => Document::getDocumentsCandidat($personnes->idCandidat),
            "documents" => Document::getDocuments(session("sessions")),
            "nbrdoc" => $nbrdoc,
        ]);

    }

}
