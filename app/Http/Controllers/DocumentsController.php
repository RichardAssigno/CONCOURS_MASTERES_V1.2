<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Document;
use App\Models\Personne;
use App\Services\RedirecteurService;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;


class DocumentsController extends Controller
{

    public function index(){

        $candidat = Candidat::getCandidat(Auth::guard("personne")->id(), session("sessions"));

        return view('documents.index', [

            "documents" => Document::getListeDocuments($candidat->id),
            "routeretour" => session("nombrefiliere") > 1 ? "choix.ordrechoix" : "choix.index",
            "titre" => "Documents",

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
       /* $document->update(['filePath'  => null,]);*/

        return response()->json(['success' => true]);
    }


    public function telechargerdossier($candidat_id)
    {
        /*$candidat_id = $request->query('candidat_id');*/

        $fichier = Document::getDocumentsPourTelecharger($candidat_id);

        $pattern = '#(?:public/)?([^/]+)/+([^/]+\.pdf)$#';
        if (!preg_match($pattern, $fichier->filePath, $matches)) {
            return response()->json(['success' => false, 'message' => 'Format de fichier non reconnu'], 422);
        }

        $nomDossier = $matches[1];
        $dossierPath = public_path("storage/documents/" . $nomDossier);

        if (!File::exists($dossierPath)) {
            return response()->json(['success' => false, 'message' => 'Dossier introuvable'], 404);
        }

        // Crée le ZIP
        $zip = new \ZipArchive;
        $tmpDir = storage_path('app/public/tmp');
        if (!File::exists($tmpDir)) File::makeDirectory($tmpDir, 0755, true);

        $zipFileName = $nomDossier . '.zip';
        $zipFullPath = $tmpDir . '/' . $zipFileName;

        if ($zip->open($zipFullPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['success' => false, 'message' => 'Erreur création ZIP'], 500);
        }

        $files = File::files($dossierPath);
        foreach ($files as $file) $zip->addFile($file, basename($file));
        $zip->close();

        // Lire le contenu du ZIP et le renvoyer en réponse binaire
        $content = File::get($zipFullPath);

        return response($content, 200, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => "attachment; filename=\"$zipFileName\"",
            'Access-Control-Allow-Origin' => 'https://admin.concours.inphb.app',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN',
            'Access-Control-Allow-Credentials' => 'true'
        ]);
    }

}
