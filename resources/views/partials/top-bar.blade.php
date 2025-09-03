<header class="ishorizontal-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset("assets/images/logo-dark-sm.png")}}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{asset("assets/images/logo-dark.png")}}" alt="" height="22">
                                </span>
                </a>

                <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset("assets/images/logo-dark-sm.png")}}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{asset("assets/images/logo-dark.png")}}" alt="" height="22">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="d-none d-sm-block ms-2 align-self-center">
                <h4 class="page-title">{{$titre ?? "Tableau de Bord"}}</h4>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown">
                <button type="button" class="btn header-item"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-eva="search-outline"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control bg-light border-0" placeholder="Search...">
                                <i class="search-icon" data-eva="search-outline" data-eva-height="26" data-eva-width="26"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ session()->has("photo_path") ? asset('storage/'.session("photo_path")) : "assets/images/avatar.png"}}"
                         alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">{{ Auth::user()->nom }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <a class="dropdown-item" href="contacts-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route("logout")}}"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Se déconnecter</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{route("tableaudebord.index")}}" id="topnav-dashboard" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon nav-icon" data-eva="grid-outline"></i>
                                <span data-key="t-dashboards">Tableau de Bord</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{route("infos.index")}}" id="topnav-uielement" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon nav-icon" data-eva="cube-outline"></i>
                                <span data-key="t-elements">Mes Infos</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{route("formation.index")}}" id="topnav-pages" role="button">
                                <i class="icon nav-icon" data-eva="archive-outline"></i>
                                <span data-key="t-apps">Ma Formation</span>
                            </a>
                        </li>

                        @if( session()->has("notes"))
                            @if(session("notes") === 1)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="{{route("notes.index")}}" id="topnav-note" role="button">
                                        <i class="icon nav-icon" data-eva="file-text-outline"></i>
                                        <span data-key="t-pages">Mes Notes</span>
                                    </a>
                                </li>
                            @endif
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{route("choix.index")}}" id="topnav-components" role="button">
                                <i class="icon nav-icon" data-eva="layers-outline"></i>
                                <span data-key="t-components">Mes Choix</span>
                            </a>
                        </li>
                        @if( session()->has("nombrefiliere"))
                            @if(mb_strtoupper(session("nombrefiliere")) > 1)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="{{route("choix.ordrechoix")}}" id="topnav-more" role="button">
                                        <i class="icon nav-icon" data-eva="file-text-outline"></i>
                                        <span data-key="t-pages">Ordre des Choix</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{route("documents.index")}}" id="topnav-document" role="button">
                                <i class="icon nav-icon" data-eva="folder-text-outline"></i>
                                <span data-key="t-pages">Mes Documents</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-document" role="button">
                                <i class="icon nav-icon" data-eva="file-text-outline"></i>
                                <span data-key="t-pages">Ma Fiche</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
