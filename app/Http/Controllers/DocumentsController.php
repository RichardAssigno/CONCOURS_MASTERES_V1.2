<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Document;
use App\Models\Personne;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DocumentsController extends Controller
{

    public function index(){

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        return view('documents.index', [

            "documents" => Document::getDocumentsCandidat($candidat->id),
            "routeretour" => session("nombrefiliere") > 1 ? "choix.ordrechoix" : "choix.index",

        ]);

    }

    public function ajouter(Request $request, $id, $idDossiercandidature)
    {

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $noms = $candidat->nom . ' ' . $candidat->prenoms;

            $document = Document::query()->findOrFail($id);

            $noms = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $noms);

            $noms = str_replace("'", "", $noms);

            $noms = str_replace(" ", "_", $noms);

            $noms = strtoupper($noms);

            // On définit un dossier au nom du matricule du candidat
            $folderName = 'documents/' . $candidat->matricule . '_' . $noms;

            // On stocke le fichier dans ce dossier
            $path = $file->store($folderName, 'public');

            // Enregistrement en base
            $dataDocument = [
                'candidats_id' => $candidat->id,
                'dossiersCandidature_id' => $idDossiercandidature,
                'filePath'  => $path,
            ];

            $document->update($dataDocument);

            return response()->json([
                'fileName' => $file->getClientOriginalName(),
                'url' => asset("storage/" . $path),
                'filePath' => $path,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Aucun fichier reçu'
        ], 400);


    }

    public function supprimerdocument(Request $request)
    {
        // Récupérer le document à partir de son ID
        $document = Document::query()->findOrFail($request->id);

        // Vérifier si le fichier existe dans le storage et le supprimer
        if (\Storage::disk('public')->exists($document->filePath)) {
            \Storage::disk('public')->delete($document->filePath);
        }

        // Supprimer l'enregistrement du document dans la base
        $document->update(['filePath'  => null,]);

        return response()->json(['success' => true]);
    }




}
