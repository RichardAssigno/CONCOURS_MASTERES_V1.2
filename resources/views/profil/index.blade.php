<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['title' => 'Profil'])
    @include("partials.css")
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body data-layout-scrollable="true" data-layout="horizontal">
<div id="layout-wrapper">
    @include("partials.top-bar")
    @include("partials.side-bar")

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid cm-profile-page">
                @php
                    $photo = session()->has('photo_path') ? asset('storage/' . session('photo_path')) : asset('assets/images/avatar.png');
                    $nomComplet = trim(($personne->prenoms ?? '') . ' ' . ($personne->nom ?? ''));
                    $totalDocuments = $documents->count();
                @endphp

                <div class="cm-profile-summary mb-4">
                    <aside class="cm-profile-card mb-0">
                        <div class="cm-profile-cover"></div>
                        <div class="cm-profile-body">
                            <img src="{{ $photo }}" alt="Photo du candidat" class="cm-profile-avatar">
                            <h2>{{ mb_strtoupper($nomComplet ?: 'Candidat') }}</h2>
                            <p>{{ $personne->email ?? '' }}</p>
                            <div class="cm-profile-stats">
                                <div>
                                    <strong>{{ $listeconcours->count() }}</strong>
                                    <span>Concours</span>
                                </div>
                                <div>
                                    <strong>{{ $progression }}%</strong>
                                    <span>Dossier</span>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <section class="cm-section mb-0">
                        <div class="cm-section-header">
                            <div>
                                <span class="cm-eyebrow">Profil candidat</span>
                                <h2>Vue generale</h2>
                            </div>
                            @if($prochaineEtape)
                                <a href="{{ $prochaineEtape['route'] }}" class="btn btn-primary">
                                    <i class="mdi mdi-arrow-right-circle-outline me-1"></i>
                                    Continuer
                                </a>
                            @else
                                <a href="{{ route('fiche.telecharger') }}" class="btn btn-success">
                                    <i class="mdi mdi-file-download-outline me-1"></i>
                                    Ma fiche
                                </a>
                            @endif
                        </div>
                        <div class="progress cm-linear-progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progression }}%;" aria-valuenow="{{ $progression }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="cm-step-grid">
                            @foreach($etapes as $etape)
                                <a href="{{ $etape['route'] }}" class="cm-step {{ $etape['complete'] ? 'is-done' : '' }}">
                                    <span class="cm-step-icon">
                                        <i class="icon" data-eva="{{ $etape['icon'] }}" data-eva-width="20" data-eva-height="20"></i>
                                    </span>
                                    <span>
                                        <strong>{{ $etape['label'] }}</strong>
                                        <small>{{ $etape['complete'] ? 'Complete' : $etape['hint'] }}</small>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="row g-4">
                    <div class="col-xl-6">
                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Identite</span>
                                    <h2>Informations personnelles</h2>
                                </div>
                                <a href="{{ route('infos.index') }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            </div>
                            <ul class="cm-detail-list">
                                <li><span>Nom</span><strong>{{ mb_strtoupper($personne->nom ?? 'A completer') }}</strong></li>
                                <li><span>Prenoms</span><strong>{{ mb_strtoupper($personne->prenoms ?? 'A completer') }}</strong></li>
                                <li><span>Date de naissance</span><strong>{{ $personne->dateNaissance ? \Carbon\Carbon::parse($personne->dateNaissance)->format('d/m/Y') : 'A completer' }}</strong></li>
                                <li><span>Lieu de naissance</span><strong>{{ mb_strtoupper($personne->lieuNaissance ?? 'A completer') }}</strong></li>
                                <li><span>Telephone</span><strong>{{ $personne->telephone ?? 'A completer' }}</strong></li>
                                <li><span>Proche</span><strong>{{ mb_strtoupper($personne->nomEtPrenomsDunProche ?? 'A completer') }}</strong></li>
                            </ul>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Parcours</span>
                                    <h2>Formation</h2>
                                </div>
                                <a href="{{ route('formation.index') }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            </div>
                            <ul class="cm-detail-list">
                                <li><span>Annee du BAC</span><strong>{{ mb_strtoupper($personne->libelleAnneebac ?? 'A completer') }}</strong></li>
                                <li><span>Lycee</span><strong>{{ mb_strtoupper($personne->libelleLycee ?? 'A completer') }}</strong></li>
                                <li><span>Serie</span><strong>{{ mb_strtoupper($personne->libelleSerie ?? 'A completer') }}</strong></li>
                                <li><span>Diplome</span><strong>{{ mb_strtoupper($personne->libelleDiplome ?? 'A completer') }}</strong></li>
                                <li><span>Etablissement</span><strong>{{ mb_strtoupper($personne->libelleEtablissement ?? 'A completer') }}</strong></li>
                                <li><span>Specialite</span><strong>{{ mb_strtoupper($personne->libelleSpecialite ?? 'A completer') }}</strong></li>
                            </ul>
                        </section>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Candidatures</span>
                                    <h2>Sessions postulees</h2>
                                </div>
                            </div>
                            <div class="cm-application-list">
                                @foreach($listeconcours as $concours)
                                    @php $isCurrent = (int) $concours->idSession === (int) session('sessions'); @endphp
                                    <div class="cm-application-item">
                                        <div class="cm-application-main">
                                            <div class="cm-application-icon">
                                                <i class="mdi mdi-school-outline"></i>
                                            </div>
                                            <div>
                                                <h3>{{ $concours->libelleConcours }} - {{ $concours->codeConcours }}</h3>
                                                <p>Session {{ $concours->libelleAnnee ?? '' }} - {{ $concours->matricule ?? 'Matricule en attente' }}</p>
                                            </div>
                                        </div>
                                        <div class="cm-application-actions">
                                            @if($isCurrent)
                                                <span class="badge bg-primary">Active</span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-primary change-session" data-id="{{ $concours->idSession }}">Ouvrir</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-5">
                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Securite</span>
                                    <h2>Mot de passe</h2>
                                </div>
                            </div>
                            <form id="passwordForm" action="{{ route('profil.password.update') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                                </div>
                                <button type="submit" class="btn btn-primary" id="passwordSubmitButton">
                                    <i class="mdi mdi-lock-reset me-1"></i>
                                    Modifier le mot de passe
                                </button>
                            </form>
                        </section>

                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Pieces</span>
                                    <h2>Documents charges</h2>
                                </div>
                                <span class="badge bg-primary">{{ $nbrdoc }} / {{ $totalDocuments }}</span>
                            </div>
                            @if($documentscandidat->isNotEmpty())
                                <ul class="cm-document-list">
                                    @foreach($documentscandidat as $document)
                                        <li>
                                            <i class="mdi mdi-file-document-check-outline"></i>
                                            <span>{{ mb_strtoupper($document->libelleDocumentdossier) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="cm-empty-state">
                                    <i class="mdi mdi-folder-upload-outline"></i>
                                    <p>Aucun document charge pour cette session.</p>
                                </div>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
</div>

@include("partials.js")
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        icon: "success",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    $('#passwordForm').on('submit', function (e) {
        e.preventDefault();

        showLoader("Modification en cours...");

        let form = $(this);
        let submitButton = $('#passwordSubmitButton');

        submitButton.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                hideLoader();
                submitButton.prop('disabled', false);

                if (response.success) {
                    Toast.fire({
                        title: response.success,
                        position: "top-end",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    form[0].reset();
                } else {
                    Swal.fire({
                        title: "Echec",
                        text: response.message || "Impossible de modifier le mot de passe.",
                        icon: "error"
                    });
                }
            },
            error: function (xhr) {
                hideLoader();
                submitButton.prop('disabled', false);

                let errorHtml = "Une erreur est survenue.";

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    errorHtml = Object.values(xhr.responseJSON.errors).map(e => e.join("\n")).join("\n");
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorHtml = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: "Erreur!",
                    text: errorHtml,
                    icon: "error"
                });
            }
        });
    });
</script>
</body>
</html>
