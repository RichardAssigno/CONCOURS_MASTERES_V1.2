@php
    $topbarUser = Auth::guard('personne')->user();
    $topbarConcours = $topbarUser ? \App\Models\Concours::ConcoursCandidats($topbarUser->id) : collect();
    $currentConcours = session('candidatConcours');
    $pageTitle = $currentConcours
        ? $currentConcours->libelleConcours . ' - ' . $currentConcours->codeConcours . ' | ' . ($titre ?? 'Tableau de Bord')
        : ($titre ?? 'Tableau de Bord');
    $avatar = session()->has('photo_path') ? asset('storage/' . session('photo_path')) : asset('assets/images/avatar.png');
@endphp

<header class="ishorizontal-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('tableaudebord.index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset("assets/images/logo-dark-sm.png") }}" alt="Logo" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset("assets/images/logo-dark.png") }}" alt="Logo" height="22">
                    </span>
                </a>

                <a href="{{ route('tableaudebord.index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset("assets/images/logo-dark-sm.png") }}" alt="Logo" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset("assets/images/logo-dark.png") }}" alt="Logo" height="22">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="d-none d-sm-block ms-2 align-self-center">
                <h4 class="page-title">{{ mb_strtoupper($pageTitle) }}</h4>
            </div>
        </div>

        <div class="d-flex align-items-center">
            @if($topbarConcours->isNotEmpty())
                <div class="cm-topbar-session">
                    <label for="topbar-session">Session</label>
                    <select id="topbar-session" class="form-select form-select-sm js-session-switcher">
                        @foreach($topbarConcours as $concours)
                            <option value="{{ $concours->idSession }}" {{ (int) $concours->idSession === (int) session('sessions') ? 'selected' : '' }}>
                                {{ $concours->codeConcours }} - {{ $concours->libelleAnnee ?? 'Session' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ $avatar }}" alt="Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">{{ $topbarUser?->nom ?? 'Candidat' }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ $topbarUser?->email ?? '' }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('profil.index') }}">
                        <i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i>
                        <span class="align-middle">Profil</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route("logout") }}">
                        <i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i>
                        <span class="align-middle">Se deconnecter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->routeIs('tableaudebord.index') ? 'active' : '' }}">
                            <a class="nav-link arrow-none {{ request()->routeIs('tableaudebord.index') ? 'active' : '' }}" href="{{ route("tableaudebord.index") }}">
                                <i class="icon nav-icon" data-eva="grid-outline"></i>
                                <span>Tableau de Bord</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('infos.index') ? 'active' : '' }}">
                            <a class="nav-link arrow-none {{ request()->routeIs('infos.index') ? 'active' : '' }}" href="{{ route("infos.index") }}">
                                <i class="icon nav-icon" data-eva="person-outline"></i>
                                <span>Mes Infos</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('formation.index') ? 'active' : '' }}">
                            <a class="nav-link arrow-none {{ request()->routeIs('formation.index') ? 'active' : '' }}" href="{{ route("formation.index") }}">
                                <i class="icon nav-icon" data-eva="book-open-outline"></i>
                                <span>Ma Formation</span>
                            </a>
                        </li>

                        @if(session()->has("codeconcours") && mb_strtoupper(session("codeconcours")) == "MSTAU")
                            <li class="nav-item {{ request()->routeIs('emploi.index') ? 'active' : '' }}">
                                <a class="nav-link arrow-none {{ request()->routeIs('emploi.index') ? 'active' : '' }}" href="{{ route("emploi.index") }}">
                                    <i class="icon nav-icon" data-eva="briefcase-outline"></i>
                                    <span>Mon Emploi</span>
                                </a>
                            </li>
                        @endif

                        @if(session()->has("notes") && (string) session("notes") === "1")
                            <li class="nav-item {{ request()->routeIs('notes.index') ? 'active' : '' }}">
                                <a class="nav-link arrow-none {{ request()->routeIs('notes.index') ? 'active' : '' }}" href="{{ route("notes.index") }}">
                                    <i class="icon nav-icon" data-eva="edit-2-outline"></i>
                                    <span>Mes Notes</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item {{ request()->routeIs('choix.index', 'choix.ordrechoix') ? 'active' : '' }}">
                            <a class="nav-link arrow-none {{ request()->routeIs('choix.index', 'choix.ordrechoix') ? 'active' : '' }}" href="{{ route("choix.index") }}">
                                <i class="icon nav-icon" data-eva="layers-outline"></i>
                                <span>Mes Choix</span>
                            </a>
                        </li>

                        @if(session()->has("nombrefiliere") && (int) session("nombrefiliere") > 1)
                            <li class="nav-item {{ request()->routeIs('choix.ordrechoix') ? 'active' : '' }}">
                                <a class="nav-link arrow-none {{ request()->routeIs('choix.ordrechoix') ? 'active' : '' }}" href="{{ route("choix.ordrechoix") }}">
                                    <i class="icon nav-icon" data-eva="list-outline"></i>
                                    <span>Ordre des Choix</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item {{ request()->routeIs('documents.index') ? 'active' : '' }}">
                            <a class="nav-link arrow-none {{ request()->routeIs('documents.index') ? 'active' : '' }}" href="{{ route("documents.index") }}">
                                <i class="icon nav-icon" data-eva="folder-outline"></i>
                                <span>Mes Documents</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link arrow-none" href="{{ route("fiche.telecharger") }}">
                                <i class="icon nav-icon" data-eva="file-text-outline"></i>
                                <span>Ma Fiche</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
