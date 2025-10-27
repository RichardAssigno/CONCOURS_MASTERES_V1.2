<?php

namespace App\Http\Controllers;

use App\Models\Choix;
use App\Models\Concours;
use App\Models\Document;
use App\Models\Formulaire;
use App\Models\Personne;
use App\Services\RedirecteurService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use ZipArchive;

class FicheController extends Controller
{

    protected $redirecteurService;

    public function __construct(RedirecteurService $redirecteurService)
    {
        $this->redirecteurService = $redirecteurService;
    }

    public function telecharger()
    {

        $resultat = $this->redirecteurService->redirecteur();

        if ($resultat['status'] === 'error') {
            return redirect()->route($resultat['route'])->with('error', $resultat['message']);
        }

        $personnes = Personne::getInfosCandidat(Auth::guard('personne')->id(), session('sessions'));

        $infos = Formulaire::getInfosMoyennesCandidat($personnes->idCandidat, session("sessions"));

        $typesmoyennes = $infos->pluck('libelleTypemoyenne', 'idTypemoyenne')->unique();

        $infos = $infos->groupBy('libelleDiscipline');

        $nbrdoc = 0;

        $documents = Document::getDocumentsCandidat($personnes->idCandidat);

        foreach ($documents as $document) {

            if (!is_null($document->filePath)) {

                $nbrdoc++;

            }

        }

        $pdf = PDF::setOptions([
            'isRemoteEnabled' => true, // 👈 autorise les images distantes
        ])->loadView('fiche.index', [
            'candidat' => $personnes,
            'qrcodeData' => self::creationQrCode($personnes),
            'candidatConcours' => Concours::getConcoursCandidat(Auth::guard('personne')->id(), session("sessions")),
            'listechoix' => Choix::getChoixCandidat(Auth::guard("personne")->id(), session("sessions")),
            'typesmoyennes' => $typesmoyennes,
            'infos' => $infos,
            "documentscandidat" => Document::getDocumentsCandidat($personnes->idCandidat),
            "nbrdoc" => $nbrdoc,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $nompdf = $personnes->matricule . "_" . Carbon::now()->timestamp;

        return $pdf->download($nompdf . '.pdf');
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
