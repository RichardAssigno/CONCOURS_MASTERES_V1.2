<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FICHE DE PREINSCRIPTION</title>
    <style>

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 0.6em;
            color: #111;
        }
        h1,h2,h3 {
            margin: 0;
        }


        .t-center{
            text-align:center;
            border: 1.5px solid white;
            background-color: darkgreen;
            color: white;
            border-radius: 5px;
            padding: 10px;
        }
        .t-right{
            text-align:right;
        }

        .head-ttl{
            font-size:16px;
            font-weight:700;
            letter-spacing:.2px;
        }


        table {
            width:100%;
            border-collapse: collapse;
        }
        .kv td{
            padding:2px 8px;
            vertical-align: top;
        }

        .kv .k{
            width:38%;
            font-weight:700;
        }
        .kv .v{
            width:62%;
        }

        .split td{
            vertical-align:top;
        }

        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 10px;
            text-align: center;
            font-size: 10px;
        }

        .section-title{
            background:#cccccc;
            border:0.5px solid #cccccc;
            padding:8px 6px;
            font-weight:700;
            text-transform: uppercase;
        }

        .kvi {
            width: 100%;
            border-collapse: collapse;
            padding: 5px;
        }

        .kvi th, .kvi td {
            border: 0.5px solid #cccccc;
            padding: 4px 6px;
            text-align: left;
        }

        .kvi th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }


    </style>
</head>
<body>
<table>
    <tr>
        <td style="width:33%;">
            <div class="head-ttl">
                @php
                    $path = public_path('assets/images/logo.png');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp

                <img src="{{ $base64 }}" alt="logo" height="80" width="80">
            </div>
        </td>
        <td style="width:33%; text-align:center; vertical-align:middle;">
            @if(mb_strtoupper($candidatConcours->path) != "INDEFINIE")
                <img src="https://a.concours.inphb.app/storage/{{$candidatConcours->path}}" alt="Mon logo" height="80">
            @endif
        </td>
        <td class="t-right" style="width:33%;">
            <img src="data:{{ $qrcodeData['mime_type'] }};base64,{{ base64_encode($qrcodeData['qr_code']) }}" alt="QR Code" style="width: 80px; height: 80px;">
        </td>
    </tr>
</table>

<div class="t-center" style="margin:10px 0 6px;">
    <h1 style="font-size:0.9em;">{{$candidatConcours->libelleConcours . " SESSION " . $candidatConcours->libelleAnnee}}</h1>
</div>

<div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">

    <div class="section-title">Informations personnelles du candidat</div>
    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <!-- Colonne des infos -->
            <td style="vertical-align: top; width: 70%;">
                <table class="kv" style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <td class="k">Matricule :</td>
                        <td class="v"><b>{{$candidat->matricule ?? ""}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Nom et Prénom(s) :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->nom ?? "") . " " . mb_strtoupper($candidat->prenoms ?? "")}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Date et lieu de naissance :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->genre ?? "") == "M" ? "Né " : "Née "}} le {{mb_strtoupper(\Carbon\Carbon::parse($candidat->dateNaissance)->format('d/m/Y') ?? "")}} à {{mb_strtoupper($candidat->lieuNaissance ?? "")}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Genre :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->genre ?? "") == "M" ? "MASCULIN" : "FEMININ"}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Téléphone :</td>
                        <td class="v"><b>{{$candidat->telephone ?? ""}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Email :</td>
                        <td class="v"><b>{{$candidat->email ?? ""}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Nom et Prénoms d'un Proche :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->nomEtPrenomsDunProche ?? "")}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Téléphone d'un Proche :</td>
                        <td class="v"><b>{{$candidat->telephoneDunProche ?? ""}}</b></td>
                    </tr>
                    <tr>
                        <td class="k">Année du BAC :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->libelleAnneebac ?? "")}}</b></td>
                    </tr>
                    @if(session()->has("codeconcours"))
                        @if(mb_strtoupper(session("codeconcours")) == "MSTAU")
                            <tr>
                                <td class="k">Source de Financement :</td>
                                <td class="v"><b>{{mb_strtoupper($candidat->financements ?? "")}}</b></td>
                            </tr>
                        @endif
                    @endif
                </table>
            </td>

            <!-- Colonne de la photo -->
            <td style="vertical-align: top; width: 30%; text-align: center;">
                <div style="margin-top: 41px;">
                    <img src="{{ session()->has("photo_path") ? asset('storage/'.session("photo_path")) : asset("assets/images/avatar.png")}}"
                     alt="Photo du candidat"
                     style="width:100px; height:auto; ">
                </div>
            </td>
        </tr>
    </table>

</div>

<div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">
    <div class="section-title">Informations de Formation</div>
    <table class="kv">
    <tr>
        <td class="k">Lycée :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleLycee ?? "")}}</b></td>
    </tr>
    <tr>
        <td class="k">Série :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleSerie ?? "")}}</b></td>
    </tr>
    <tr>
        <td class="k">Diplôme :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleDiplome ?? "")}}</b></td>
    </tr>
    @if(session()->has("cycles"))
        @if(mb_strtoupper(session("cycles")) != "BACHELIER")
            <tr>
                <td class="k">Spécialité :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->libelleSpecialite ?? "")}}</b></td>
            </tr>
            <tr>
                <td class="k">Etablissement Superieur d'Origine :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->libelleEtablissement ?? "")}}</b></td>
            </tr>
            @if(session()->has("codeconcours"))
                @if(mb_strtoupper(session("codeconcours")) == "MSTAU")
                    <tr>
                        <td class="k">Niveau d'Etude :</td>
                        <td class="v"><b>{{mb_strtoupper($candidat->niveauetudes ?? "")}}</b></td>
                    </tr>
                @endif
            @endif
        @endif
    @endif
</table>
</div>

@if(session()->has("codeconcours"))
    @if(mb_strtoupper(session("codeconcours")) == "MSTAU")

        <div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">
        <div class="section-title">Informations sur l'Emploi</div>
        <table class="kv">
            <tr>
                <td class="k">Profession :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->professions)}}</b></td>
            </tr>
            <tr>
                <td class="k">Employeur :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->employeurs)}}</b></td>
            </tr>
            <tr>
                <td class="k">Experience :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->experiences)}}</b></td>
            </tr>

        </table>
    </div>

    @endif

@endif

<div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">
    <div class="section-title">Informations relatives au concours</div>
    <table class="kv">
        @php $numero = 1 @endphp
        @if($listechoix->isNotEmpty())
            @foreach($listechoix as $concours)
                <tr>
                    <td class="k">Filière {{$numero++}} :</td>
                    <td class="v"><b>{{mb_strtoupper($concours->libelleFiliere . " ( " . $concours->codeFiliere . " )" )}}</b></td>
                </tr>
            @endforeach
        @endif
    </table>
</div>

@if(session()->has("notes"))
    @if(session("notes") === "1")
        <div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">
            <div class="section-title">Informations des Notes</div>
            <table class="kvi" style="margin-top: 3px">
                <thead>
                <tr>
                    <th>Matière</th>
                    @foreach($typesmoyennes as $idType => $libelleType)
                        <th>{{ $libelleType }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($infos as $discipline => $notes)
                    <tr>
                        <td>{{ $discipline }}</td>
                        @foreach($typesmoyennes as $idType => $libelleType)
                            @php
                                $note = $notes->firstWhere('idTypemoyenne', $idType);
                            @endphp
                            <td style="text-align: center">{{ $note->moyenne ?? '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    @endif
@endif

<div style="border: 1px solid #cccccc; margin-bottom: 12px; padding: 5px">
    <div class="section-title">Documents du Candidat</div>
    <ul class="list-unstyled ps-0 mb-0 mt-3">
        @php $numero = 1 @endphp
        @if($documentscandidat->isNotEmpty())
            @foreach($documentscandidat as $document)
                <li style="margin-bottom:1px; line-height:1.2;">
                    <p class="text-muted" style="font-size:1em; margin:0;">
                        <i class="mdi mdi-circle-medium align-middle me-1"></i>
                        <strong>Document N° {{$numero++}} : </strong> {{ mb_strtoupper($document->libelleDocumentdossier) }}
                    </p>
                </li>
            @endforeach
        @endif
    </ul>

</div>


<div class="footer">
    Copyright © 2025 - BUREAU CENTRAL DES CONCOURS INP-HB. Tous Droits Réservés
</div>

</body>
</html>
