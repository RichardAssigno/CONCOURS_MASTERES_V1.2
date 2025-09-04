<?php

namespace App\Http\Controllers;

use App\Models\Choix;
use App\Models\Concours;
use App\Models\Formulaire;
use App\Models\Personne;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FicheController extends Controller
{
    public function telecharger()
    {

        $personnes = Personne::getInfosCandidat(Auth::guard('personne')->id(), session('sessions'));

        $infos = Formulaire::getInfosMoyennesCandidat($personnes->idCandidat, session("sessions"));

        // On récupère les types de moyennes distincts
        $typesmoyennes = $infos->pluck('libelleTypemoyenne', 'idTypemoyenne')->unique();

        // On groupe les infos par discipline
        $infos = $infos->groupBy('libelleDiscipline');

        $html = view('fiche.index', [

            'candidat' => $personnes,
            'qrcodeData' => self::creationQrCode($personnes),
            'candidatConcours' => Concours::getConcoursCandidat(Auth::guard('personne')->id(), session("sessions")),
            "listechoix" => Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions")),
            "typesmoyennes" => $typesmoyennes,
            "infos" => $infos,

        ])->render();

        $pdf = Pdf::loadHTML($html);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('convocation_concours_2025.pdf');
    }

    public static function creationQrCode($candidat)
    {
        $infoQrCode = $candidat->matricule ?? uniqid();

        $infoQrCode =   $candidat->matricule ." - " . Hash::make($candidat->matricule) ;

        $logoPath = public_path('assets/images/logo.png'); // Chemin du logo
        $fileName = "qrcode_" . $candidat->matricule . ".png"; // Nom du QR code

        $writer = new PngWriter();

        // Création du QR code
        $qrCode = new \Endroid\QrCode\QrCode(
            data: $infoQrCode,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        // Ajout du logo
        $logo = new Logo(
            path: $logoPath,
            resizeToWidth: 80,
            punchoutBackground: true
        );

        // Génération du QR code avec logo et label
        $result = $writer->write($qrCode, $logo);

        // ❌ Suppression de la validation automatique
        // $writer->validateResult($result, $infoQrCode);

       // session()->flush();

        // Retourner les informations du QR Code
        return [
            'file_name' => $fileName,
            'qr_code' => $result->getString(), // Contenu de l'image (base64)
            'mime_type' => $result->getMimeType()
        ];
    }

}
