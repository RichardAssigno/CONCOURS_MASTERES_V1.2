<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CONVOCATION - CONCOURS ADMINISTRATIFS 2025</title>
    <style>
        @page { margin: 24mm 18mm 22mm 18mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1,h2,h3 { margin: 0; }
        .t-center{ text-align:center; } .t-right{ text-align:right; } .t-muted{ color:#444; }
        .hr{ height:1px; background:#000; margin:8px 0 6px; }
        .box{ border:1px solid #000; padding:10px 12px; margin-top:10px; }
        .head-ttl{ font-size:16px; font-weight:700; letter-spacing:.2px; }
        .subtitle{ font-size:13px; font-weight:700; margin:2px 0 4px; }
        table { width:100%; border-collapse: collapse; }
        .kv td{ padding:6px 8px; vertical-align: top; }
        .kv .k{ width:38%; font-weight:700; }
        .kv .v{ width:62%; }
        .split{ width:100%; table-layout: fixed; }
        .split td{ vertical-align:top; }
        .small{ font-size:11px; }
        .badge{ display:inline-block; padding:2px 6px; border:1px solid #000; font-size:10px; }
        .footer { position: fixed; left: 0; right: 0; bottom: 10mm; text-align: center; font-size: 10px; }
        .watermark{
            position: fixed; top: 40%; left: 14%;
            transform: rotate(-20deg); font-size: 80px; color: #000; opacity: .06; font-weight: 700;
        }
        .cap{ text-transform: uppercase; }
        .section-title{
            background:#f2f2f2; border:1px solid #000; padding:6px 8px; font-weight:700; margin-top:12px; text-transform: uppercase;
        }
        .list { padding-left: 16px; margin: 6px 0; }
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
        <td style="width:33%;">
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
    <h1 style="font-size:18px;">{{$candidatConcours->libelleConcours . " Session " . $candidatConcours->libelleAnnee}}</h1>
</div>

<div class="section-title">Informations personnelles du candidat</div>
<table class="kv">
    <tr>
        <td class="k">Matricule :</td>
        <td class="v"><b>{{$candidat->matricule}}</b></td>
    </tr>
    <tr>
        <td class="k">Nom et Prénom(s) :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->nom) . " " . mb_strtoupper("$candidat->prenoms")}}</b></td>
    </tr>
    <tr>
        <td class="k">Date et lieu de naissance :</td>
        <td class="v"><b> {{mb_strtoupper($candidat->genre) == "M" ? "Né " : "Née "}} le {{mb_strtoupper($candidat->dateNaissance)}} à {{mb_strtoupper($candidat->lieuNaissance)}}</b></td>
    </tr>
    <tr>
        <td class="k">Genre :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->genre) == "M" ? "MASCULIN" : "FEMININ"}}</b></td>
    </tr>
    <tr>
        <td class="k">Téléphone :</td>
        <td class="v"><b>{{$candidat->telephone}}</b></td>
    </tr>
    <tr>
        <td class="k">Email :</td>
        <td class="v"><b>{{$candidat->email}}</b></td>
    </tr>
    <tr>
        <td class="k">Nom et Prénoms d'un Proche :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->nomEtPrenomsDunProche)}}</b></td>
    </tr>
    <tr>
        <td class="k">Téléphone d'un Proche :</td>
        <td class="v"><b>{{$candidat->telephoneDunProche}}</b></td>
    </tr>
    <tr>
        <td class="k">Année du BAC :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleAnneebac)}}</b></td>
    </tr>

</table>

<div class="section-title">Informations de Formation</div>
<table class="kv">
    <tr>
        <td class="k">Lycée :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleLycee)}}</b></td>
    </tr>
    <tr>
        <td class="k">Série :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleSerie)}}</b></td>
    </tr>
    <tr>
        <td class="k">Diplôme :</td>
        <td class="v"><b>{{mb_strtoupper($candidat->libelleDiplome)}}</b></td>
    </tr>
</table>

<div class="section-title">Informations relatives au concours</div>
<table class="kv">
    @php $numero = 1 @endphp
    @if($listechoix->isNotEmpty())
        @foreach($listechoix as $concours)
            <tr>
                <td class="k">Filière {{$numero++}} :</td>
                <td class="v"><b>{{mb_strtoupper($candidat->libelleFiliere . " ( " . $candidat->codeFiliere . " )" )}}</b></td>
            </tr>
        @endforeach
    @endif
</table>

@if(session()->has("notes"))
    @if(session("notes") === 1)
        <div class="section-title">Informations des Notes</div>
        <table class="table table-striped">
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
                            <td>
                                {{ $note->moyenne ?? '' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endif

<div class="section-title">Consignes aux candidats (À lire absolument)</div>
{{--<div class="box">
    <div class="small t-muted" style="margin-bottom:6px;">
        M., Mme, Mlle nos félicitations pour avoir achevé votre inscription aux concours administratifs 2025.
        Vous avez le statut de candidat pendant toute la période des concours. Aussi devez-vous vous conformer scrupuleusement aux consignes ci-dessous.
    </div>
    <b>Accès au site de composition :</b>
    <ol class="list small">
        <li>Tenue correcte obligatoire (pas de foulard, casquette, chapeau, culotte, sandales, etc.).</li>
        <li>Être en possession de sa CNI / passeport / récépissé ONECI en cours de validité ainsi que de sa convocation.</li>
        <li>Sacs, trousses, cartables, serviettes strictement interdits au sein du site.</li>
        <li>Téléphone portable, appareil connecté ou tout autre appareil de communication strictement interdits.</li>
        <li>Après le contrôle à l’entrée, le candidat est tenu de ne plus ressortir du site.</li>
    </ol>
    <b>Déroulement de la composition :</b>
    <ol class="list small">
        <li>Vérifier l’intitulé de l’épreuve sur la feuille de composition, sous peine d’annulation.</li>
        <li>Toute sortie n’est autorisée qu’après 1h de composition.</li>
        <li>Remettre toutes les copies, brouillons et sujets aux surveillants avant de quitter.</li>
        <li>Interdiction de quitter la salle dans le dernier quart d’heure.</li>
        <li>Après remise des copies, il est interdit de revenir en salle.</li>
    </ol>
    <b>Cas de fraude :</b>
    <ul class="list small">
        <li>Possession d’un téléphone/appareil connecté (même éteint) dans l’enceinte.</li>
        <li>Documents non autorisés en salle.</li>
        <li>Tricherie.</li>
    </ul>
    <b>Sanctions :</b>
    <div class="small">
        Tout contrevenant est immédiatement exclu et s’expose aux poursuites pénales prévues à l’article 299 du code pénal.
        <br>NB : En cas de fraude ou d’irrégularités constatées, appeler le numéro vert : <b>1364</b>.
    </div>
</div>--}}

<div class="footer">
    Copyright © 2025 - DIRECTION DES CONCOURS. Tous Droits Réservés
</div>

</body>
</html>
