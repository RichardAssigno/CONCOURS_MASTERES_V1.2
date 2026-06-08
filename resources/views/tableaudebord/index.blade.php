<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['title' => 'Tableau de Bord'])
    @include("partials.css")
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body data-layout-scrollable="true" data-layout="horizontal">
<div id="layout-wrapper">
    @include("partials.top-bar")
    @include("partials.side-bar")

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid cm-dashboard">
                @if (session('echec'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('echec') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('succes'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('succes') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @php
                    $currentConcours = session('candidatConcours');
                    $photo = session()->has('photo_path') ? asset('storage/' . session('photo_path')) : asset('assets/images/avatar.png');
                    $nomComplet = trim(($personne->prenoms ?? '') . ' ' . ($personne->nom ?? ''));
                    $totalDocuments = $documents->count();
                    $sessionLabel = $anneeSelectionnee ? 'Session ' . $anneeSelectionnee : 'Session courante';
                @endphp

                <div class="cm-hero mb-4">
                    <div class="cm-hero-content">
                        <span class="cm-eyebrow">Espace candidat</span>
                        <h1>Bonjour {{ mb_strtoupper($personne->prenoms ?? 'Candidat') }}</h1>
                        <p>{{ $sessionLabel }}. Suivez votre inscription et retrouvez tous les concours ouverts.</p>
                        <div class="cm-hero-actions">
                            @if($prochaineEtape)
                                <a href="{{ $prochaineEtape['route'] }}" class="btn btn-light">
                                    <i class="mdi mdi-arrow-right-circle-outline me-1"></i>
                                    Continuer mon inscription
                                </a>
                            @else
                                <a href="{{ route('fiche.telecharger') }}" class="btn btn-light">
                                    <i class="mdi mdi-file-download-outline me-1"></i>
                                    Telecharger ma fiche
                                </a>
                            @endif
                            <a href="#concours-annee" class="btn btn-outline-light">
                                <i class="mdi mdi-plus-circle-outline me-1"></i>
                                Voir les concours
                            </a>
                        </div>
                    </div>
                    <div class="cm-hero-progress">
                        <div class="cm-progress-ring" style="--progress: {{ $progression }};">
                            <span>{{ $progression }}%</span>
                        </div>
                        <div>
                            <h5>Progression du dossier</h5>
                            <p class="mb-0">
                                {{ $etapes->filter(fn ($etape) => $etape['complete'])->count() }} etape(s) validee(s) sur {{ $etapes->count() }}.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="cm-stat-card cm-stat-blue">
                            <div>
                                <span>Concours postules</span>
                                <strong>{{ $listeconcours->count() }}</strong>
                            </div>
                            <i class="mdi mdi-clipboard-check-outline"></i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="cm-stat-card cm-stat-green">
                            <div>
                                <span>Concours ouverts</span>
                                <strong>{{ $concoursOuverts->count() }}</strong>
                            </div>
                            <i class="mdi mdi-bullhorn-outline"></i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="cm-stat-card cm-stat-amber">
                            <div>
                                <span>Documents charges</span>
                                <strong>{{ $nbrdoc }} / {{ $totalDocuments }}</strong>
                            </div>
                            <i class="mdi mdi-folder-upload-outline"></i>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="cm-stat-card cm-stat-rose">
                            <div>
                                <span>Choix enregistres</span>
                                <strong>{{ $choix->count() }}</strong>
                            </div>
                            <i class="mdi mdi-layers-outline"></i>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-8">
                        <section class="cm-section cm-contest-toggle-section" id="concours-annee">
                            <button class="cm-toggle-header" type="button" data-bs-toggle="collapse" data-bs-target="#concours-annee-content" aria-expanded="false" aria-controls="concours-annee-content">
                                <div>
                                    <span class="cm-eyebrow">Concours</span>
                                    <h2>{{ $sessionLabel }}</h2>
                                    <p>{{ $listeconcours->count() }} candidature(s) et {{ $concoursOuverts->count() }} concours ouvert(s)</p>
                                </div>
                                <span class="cm-toggle-icon">
                                    <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </button>

                            <div id="concours-annee-content" class="collapse">
                                <div class="cm-toggle-body">
                                    <div class="cm-section-header">
                                        <div>
                                            <span class="cm-eyebrow">Recherche</span>
                                            <h2>Liste des concours</h2>
                                        </div>
                                        <div class="cm-search">
                                            <i class="mdi mdi-magnify"></i>
                                            <input id="concours-filter" type="text" class="form-control" placeholder="Filtrer un concours">
                                        </div>
                                    </div>

                                    <div class="cm-subsection-title">
                                        <i class="mdi mdi-clipboard-check-outline"></i>
                                        <span>Mes concours postules</span>
                                    </div>

                                    <div class="cm-application-list mb-4">
                                        @forelse($listeconcours as $concours)
                                            @php
                                                $isCurrent = (int) $concours->idSession === (int) session('sessions');
                                            @endphp
                                            <div class="cm-application-item card-filter">
                                                <div class="cm-application-main">
                                                    <div class="cm-application-icon">
                                                        <i class="mdi mdi-school-outline"></i>
                                                    </div>
                                                    <div>
                                                        <h3>{{ $concours->libelleConcours }} - {{ $concours->codeConcours }}</h3>
                                                        <p>Session {{ $concours->libelleAnnee ?? '' }} - Matricule {{ $concours->matricule ?? 'en attente' }}</p>
                                                    </div>
                                                </div>
                                                <div class="cm-application-actions">
                                                    @if($isCurrent)
                                                        <span class="badge bg-primary">Session active</span>
                                                        @if($prochaineEtape)
                                                            <a href="{{ $prochaineEtape['route'] }}" class="btn btn-sm btn-primary">Continuer</a>
                                                        @else
                                                            <a href="{{ route('fiche.telecharger') }}" class="btn btn-sm btn-success">Imprimer</a>
                                                        @endif
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-outline-primary change-session" data-id="{{ $concours->idSession }}">
                                                            Changer de session
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="cm-empty-state">
                                                <i class="mdi mdi-clipboard-text-off-outline"></i>
                                                <p>Vous n'avez pas encore de candidature pour cette session.</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="cm-subsection-title">
                                        <i class="mdi mdi-bullhorn-outline"></i>
                                        <span>Concours ouverts</span>
                                    </div>

                                    <div class="row g-3">
                                        @forelse($concoursOuverts as $concours)
                                            @php
                                                $isCurrent = (int) $concours->idSession === (int) session('sessions');
                                            @endphp
                                            <div class="col-md-6 col-xxl-4 card-filter">
                                                <article class="cm-contest-card h-100">
                                                    <div class="cm-contest-logo">
                                                        <img src="{{ asset('assets/images/logoinphb.png') }}" alt="INP-HB">
                                                        <span>{{ $concours->libelleAnnee ?? '' }}</span>
                                                    </div>
                                                    <h3>{{ $concours->libelleConcours }}</h3>
                                                    <p>{{ $concours->codeConcours }} - {{ $concours->etapeConcours ?? 'Inscription ouverte' }}</p>
                                                    <div class="cm-contest-actions">
                                                        @if($concours->dejaPostule)
                                                            <span class="badge bg-success-subtle text-success">Deja postule</span>
                                                            @if($isCurrent)
                                                                @if($prochaineEtape)
                                                                    <a href="{{ $prochaineEtape['route'] }}" class="btn btn-sm btn-success">Continuer</a>
                                                                @else
                                                                    <a href="{{ route('fiche.telecharger') }}" class="btn btn-sm btn-success">Fiche</a>
                                                                @endif
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-outline-primary change-session" data-id="{{ $concours->idSession }}">
                                                                    Ouvrir
                                                                </button>
                                                            @endif
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-primary btnConnexionConcours" data-id="{{ $concours->idSession }}">
                                                                Postuler
                                                            </button>
                                                        @endif
                                                    </div>
                                                </article>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="cm-empty-state">
                                                    <i class="mdi mdi-calendar-remove-outline"></i>
                                                    <p>Aucun concours ouvert actuellement.</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="cm-section">
                            <div class="cm-section-header">
                                <div>
                                    <span class="cm-eyebrow">Suivi</span>
                                    <h2>Avancement de mon dossier</h2>
                                </div>
                                <strong class="cm-progress-label">{{ $progression }}%</strong>
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

                    <div class="col-xl-4">
                        <aside class="cm-profile-card">
                            <div class="cm-profile-cover"></div>
                            <div class="cm-profile-body">
                                <img src="{{ $photo }}" alt="Photo du candidat" class="cm-profile-avatar">
                                <h2>{{ mb_strtoupper($nomComplet ?: 'Candidat') }}</h2>
                                <p>{{ $personne->email ?? '' }}</p>
                                <div class="cm-profile-stats">
                                    <div>
                                        <strong>{{ $personne->matricule ?? '-' }}</strong>
                                        <span>Matricule</span>
                                    </div>
                                    <div>
                                        <strong>{{ $nbrdoc }}/{{ $totalDocuments }}</strong>
                                        <span>Docs</span>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <a href="{{ route('profil.index') }}" class="btn btn-outline-primary">
                                        <i class="mdi mdi-account-circle-outline me-1"></i>
                                        Voir mon profil
                                    </a>
                                    <a href="{{ route('fiche.telecharger') }}" class="btn btn-primary">
                                        <i class="mdi mdi-file-download-outline me-1"></i>
                                        Imprimer ma fiche
                                    </a>
                                </div>
                            </div>
                        </aside>

                        @if($infosPersonnellesCompletes)
                            <section class="cm-section cm-section-compact">
                                <div class="cm-section-header">
                                    <div>
                                        <span class="cm-eyebrow">Renseigne</span>
                                        <h2>Mes informations</h2>
                                    </div>
                                </div>
                                <ul class="cm-detail-list">
                                    <li><span>Nom complet</span><strong>{{ mb_strtoupper(($personne->nom ?? '') . ' ' . ($personne->prenoms ?? '')) }}</strong></li>
                                    <li><span>Naissance</span><strong>{{ \Carbon\Carbon::parse($personne->dateNaissance)->format('d/m/Y') }} a {{ mb_strtoupper($personne->lieuNaissance ?? '') }}</strong></li>
                                    <li><span>Telephone</span><strong>{{ $personne->telephone ?? '' }}</strong></li>
                                    <li><span>Proche</span><strong>{{ mb_strtoupper($personne->nomEtPrenomsDunProche ?? '') }}</strong></li>
                                </ul>
                            </section>
                        @endif

                        @if($formationComplete)
                            <section class="cm-section cm-section-compact">
                                <div class="cm-section-header">
                                    <div>
                                        <span class="cm-eyebrow">Renseignee</span>
                                        <h2>Ma formation</h2>
                                    </div>
                                </div>
                                <ul class="cm-detail-list">
                                    <li><span>Annee du BAC</span><strong>{{ mb_strtoupper($personne->libelleAnneebac ?? '') }}</strong></li>
                                    <li><span>Lycee</span><strong>{{ mb_strtoupper($personne->libelleLycee ?? '') }}</strong></li>
                                    <li><span>Serie</span><strong>{{ mb_strtoupper($personne->libelleSerie ?? '') }}</strong></li>
                                    <li><span>Diplome</span><strong>{{ mb_strtoupper($personne->libelleDiplome ?? '') }}</strong></li>
                                    @if(mb_strtoupper((string) session('cycles')) !== 'BACHELIER')
                                        <li><span>Etablissement</span><strong>{{ mb_strtoupper($personne->libelleEtablissement ?? '') }}</strong></li>
                                        <li><span>Specialite</span><strong>{{ mb_strtoupper($personne->libelleSpecialite ?? '') }}</strong></li>
                                    @endif
                                </ul>
                            </section>
                        @endif

                        @if($documentscandidat->isNotEmpty())
                            <section class="cm-section cm-section-compact">
                                <div class="cm-section-header">
                                    <div>
                                        <span class="cm-eyebrow">Charges</span>
                                        <h2>Mes documents</h2>
                                    </div>
                                    <span class="badge bg-primary">{{ $nbrdoc }} fichier(s)</span>
                                </div>
                                <ul class="cm-document-list">
                                    @foreach($documentscandidat as $document)
                                        <li>
                                            <i class="mdi mdi-file-document-check-outline"></i>
                                            <span>{{ mb_strtoupper($document->libelleDocumentdossier) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
</div>

@include("partials.js")

<script>
    const DashboardToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        icon: 'success',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#concours-filter').on('input', function () {
        const filter = $(this).val().toLowerCase().trim();

        $('.card-filter').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });

    $(document).on('click', '.btnConnexionConcours', function (e) {
        e.preventDefault();

        const sessionId = $(this).data('id');

        if (typeof showLoader === 'function') {
            showLoader('Inscription en cours...');
        }

        $.ajax({
            url: `/inscription-concours/${sessionId}`,
            method: 'GET',
            success: function (response) {
                if (typeof hideLoader === 'function') {
                    hideLoader();
                }

                DashboardToast.fire({
                    title: response.success || 'Inscription ouverte',
                    icon: 'success'
                });

                setTimeout(function () {
                    window.location.href = response.redirect || "{{ route('tableaudebord.index') }}";
                }, 900);
            },
            error: function (xhr) {
                if (typeof hideLoader === 'function') {
                    hideLoader();
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Impossible de postuler',
                    text: xhr.responseJSON?.errors || xhr.responseJSON?.message || 'Une erreur est survenue.'
                });
            }
        });
    });
</script>

</body>
</html>
