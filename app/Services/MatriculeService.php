<?php

namespace App\Services;

use App\Models\Concours;
use App\Models\Session;

class MatriculeService
{
    /**
     * Génère un matricule unique
     */
    public function genererMatricule($idSession)
    {
        $infoSessionConcours = Session::infoSession($idSession);

        $infoSession = Session::query()->findOrFail($idSession);

        if (!empty($infoSessionConcours)) {

            $data = [ "compteurMatricule" => $infoSession->compteurMatricule + 1];

            $infoSession->update($data);

            return mb_strtoupper($infoSessionConcours->baseMatricule . date("y") . str_pad(dechex($infoSession->compteurMatricule), 4, "0", STR_PAD_LEFT));
        }

    }
}
