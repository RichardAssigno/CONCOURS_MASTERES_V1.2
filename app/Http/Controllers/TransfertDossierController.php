<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TransfertDossierController extends Controller
{

    public function transfererDossiers()
    {

        // 🔹 Chemins des deux projets
        $source = '/home/concours/public_html/recrutements.concours.inphb.app/storage/app/public'; // <-- adapte ce chemin
        $destination = storage_path('public/documents'); // projet B

        // 🔹 Vérifie si le dossier source existe
        if (!File::exists($source)) {
            return "Le dossier source n'existe pas : $source";
        }

        // 🔹 Crée le dossier de destination s'il n'existe pas
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // 🔹 Copie tout le répertoire
        File::moveDirectory($source, $destination);

        return "✅ Tous les dossiers des candidats ont été copiés de Projet A vers Projet B avec succès !";


    }

}
