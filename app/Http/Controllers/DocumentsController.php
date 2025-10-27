<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Document;
use App\Models\Personne;
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

            "documents" => Document::getDocumentsCandidat($candidat->id),
            "routeretour" => session("nombrefiliere") > 1 ? "choix.ordrechoix" : "choix.index",
            "titre" => "Documents du candidat",

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


    public function telechargerdossier(Request $request)
    {
        $candidat_id = $request->query('candidat_id');

        // Récupération du fichier (par exemple le premier document du candidat)
        $fichier = Document::getDocumentsPourTelecharger($candidat_id);

        // Chemin trouvé dans la BD (ex: "documents/MSTAU250004_NGUESSAN_KOUAME_LEONARD/monfichier.pdf")
        $pattern = '#(?:public/)?documents/([A-Za-z0-9_\-]*)/([^/]+\.pdf)$#';


        $nomDossier = null;
        $matricule = null;

        if (preg_match($pattern, $fichier->filePath, $matches)) {
            // $matches[1] = "MSTAU250004_NGUESSAN_KOUAME_LEONARD"
            // $matches[2] = "nomdufichier.pdf"
            $nomDossier = $matches[1];

        } else {
            return redirect()->back()->with("echec", "Le format du fichier n'est pas reconnu.");
        }

        // Le dossier à zipper (dans public/documents)
        $dossierPath = public_path("storage/documents/" . $nomDossier);

        if (!File::exists($dossierPath)) {
            return redirect()->back()->with("echec", "Le dossier du candidat n'existe pas.");
        }

        // Création d’un dossier temporaire pour le zip
        $tmpDir = storage_path('app/public/tmp');
        if (!File::exists($tmpDir)) {
            File::makeDirectory($tmpDir, 0755, true);
        }

        // Nom du fichier ZIP
        $zipFileName = $nomDossier . '.zip';
        $zipFullPath = $tmpDir . '/' . $zipFileName;

        $zip = new ZipArchive;

        if ($zip->open($zipFullPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::files($dossierPath);

            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();

            // Téléchargement et suppression du zip après envoi
            return response()->download($zipFullPath)->deleteFileAfterSend(true);
        }

        return redirect()->back()->with("echec", "Échec de la création du fichier ZIP.");
    }

}
