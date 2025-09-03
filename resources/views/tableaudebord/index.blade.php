<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    @include("partials.css")

</head>


<body data-layout-scrollable="true" data-layout="horizontal">

<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">


    @include("partials.top-bar")
    <!-- ========== Left Sidebar Start ========== -->
    @include("partials.side-bar")

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xxl-9">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                                        <i data-eva="pie-chart-2" class="fill-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Matricule</p>
                                                <h6 class="mb-0">{{$personne->matricule ?? ""}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-4 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                                        <i data-eva="shopping-bag" class="fill-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Email</p>
                                                <h6 class="mb-0">{{$personne->email ?? ""}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                                        <i data-eva="people" class="fill-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Ma fiche</p>
                                                <h6 class="mb-0"><a href="" style="color: black">Imprimer fiche</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <div class="card">
                            <div class="card-body">
                                <a href="#addproduct-img-collapse" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-haspopup="true" aria-controls="addproduct-img-collapse">
                                    <div class="p-4">

                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title font-size-16 rounded-circle bg-soft-primary text-primary">
                                                        01
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Mes concours</h5>
                                                <p class="text-muted text-truncate mb-0">Concours auxquels j'ai postulé</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>

                                        </div>

                                    </div>
                                </a>

                                <div id="addproduct-img-collapse" class="collapse mb-3" data-bs-parent="#addproduct-accordion">
                                <div class="row">
                                    @if($listeconcours->isNotEmpty())
                                        @foreach($listeconcours as $concours)
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="avatar">
                                                                <span class="avatar-title rounded bg-light text-danger font-size-16">
                                                                    <img src="assets/images/companies/img-1.png" alt="" height="30">
                                                                </span>
                                                            </div>
                                                            <div class="ms-auto">
                                                                <div class="dropdown float-end">
                                                                    <a class="text-muted dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Se connecter</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex-grow-1 mt-4">
                                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$concours->libelleConcours}}</a></h5>
                                                            <p class="text-muted mb-0">Etat d'avancement de mon inscription</p>

                                                            <div class="mt-3 mb-1">
                                                                <div class="row align-items-center">
                                                                    <div class="col">
                                                                        <div class="progress" style="height: 6px;">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <h6 class="mb-0 font-size-13"> 40%</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-2 border-top">
                                                        <div class="text-center btn-sm">

                                                            <a href="{{route("tableaudebord.index")}}" class="btn btn-primary waves-effect waves-light btn-sm"><i class="mdi mdi-file-document-outline me-1"></i> Se connecter</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    @endif
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- ==================== Infos personnelles ==================== -->
                        @if(!is_null($personne->nom) && !is_null($personne->prenoms) && !is_null($personne->dateNaissance))
                            <div class="card">
                            <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                                <div class="p-4 d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar">
                                            <div class="avatar-title font-size-16 rounded-circle bg-soft-primary text-primary">02</div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Mes Infos et ma Formation</h5>
                                        <p class="text-muted text-truncate mb-0">Je vérifie mes infos personnelles et ma formation</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>
                                </div>
                            </a>

                            <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                <div class="p-4 border-top">
                                    <div class="row">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Infos</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Concours</span>
                                                </a>
                                            </li>
                                            @if(session()->has("notes"))
                                                @if(session("notes") === 1)
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                            <span class="d-none d-sm-block">Notes</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Documents</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="home1" role="tabpanel">
                                                <div class="row">
                                                    <div class="mt-3">
                                                        <h5 class="font-size-14">Infos Personnelles et Formations:</h5>
                                                        <ul class="list-unstyled ps-0 mb-0 mt-3">
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Nom et Prénoms : </strong> {{mb_strtoupper($personne->nom . ' ' . $personne->prenoms)}} </p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Date et lieu de Naissance : </strong>{{ mb_strtoupper($personne->genre) == "M" ? "Né le " : "Née le " }}{{mb_strtoupper($personne->dateNaissance . ' à ' . $personne->lieuNaissance)}}</p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Genre : </strong>{{ mb_strtoupper($personne->genre) == "M" ? "MASCULIN" : "FEMININ" }}</p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Téléphone : </strong>{{$personne->telephone ?? ""}} </p></li>
                                                            <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Nom et Prénoms d'un proche : </strong>{{$personne->nomEtPrenomsDunProche ?? ""}}</p></li>
                                                            <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Téléphone d'un proche : </strong>{{mb_strtoupper($personne->nomEtPrenomsDunProche ?? "")}}</p></li>
                                                            <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Nom et Prénoms d'un proche : </strong>{{$personne->telephoneDunProche ?? ""}}</p></li>
                                                            <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Année du BAC : </strong>{{mb_strtoupper($personne->libelleAnneebac ?? "")}}</p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Lycée : </strong>{{mb_strtoupper($personne->libelleLycee ?? "")}}</p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Série : </strong>{{mb_strtoupper($personne->libelleSerie ?? "")}}</p></li>
                                                            <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Diplôme : </strong>{{mb_strtoupper($personne->libelleDiplome ?? "")}}</p></li>
                                                            @if(session()->has("cycles"))
                                                                @if(mb_strtoupper(session("cycles")) == "BAC")
                                                                    <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Etablissement Supérieur : </strong>{{mb_strtoupper($personne->libelleEtablissement ?? "")}}</p></li>
                                                                    <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Spécialité : </strong>{{mb_strtoupper($personne->libelleSpecialite ?? "")}}</p></li>
                                                                @endif
                                                            @endif

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="profile1" role="tabpanel">
                                                <div class="mt-3">
                                                    <h5 class="font-size-14">Concours :</h5>
                                                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                                                        @php $nbr = count($choix); $numero = 1 @endphp
                                                        @if($choix->isNotEmpty())
                                                            @foreach($choix as $value)
                                                                <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Concours {{$nbr > 1 ?$numero++ : ""}} : </strong> {{mb_strtoupper($value->libelleFiliere . ' ' . "( ". " " .$value->codeFiliere . " )")}} </p></li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            @if(session()->has("notes"))
                                                @if(session("notes") === 1)
                                                    <div class="tab-pane" id="messages1" role="tabpanel">
                                                <div class="p-4 border-top">
                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            <div class="form-note table-responsive">
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
                                                                                @php
                                                                                    $note = $notes->firstWhere('idTypemoyenne', $idType);
                                                                                @endphp
                                                                                <td>
                                                                                    <div class="mb-3">
                                                                                        <input
                                                                                            type="text"
                                                                                            class="form-control note-input"
                                                                                            name="{{ $note->idDiscipline ?? $notes->first()->idDiscipline }}[{{ $idType }}]"
                                                                                            value="{{ $note->moyenne ?? '' }}"
                                                                                            placeholder="Entrez la note" readonly>
                                                                                    </div>
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                @endif
                                            @endif

                                            <div class="tab-pane" id="settings1" role="tabpanel">
                                                <h5 class="font-size-14">Documents Chargés ( {{$nbrdoc . " / " . count($documentscandidat)}} ):</h5>
                                                <ul class="list-unstyled ps-0 mb-0 mt-3">
                                                    @php $numero = 1 @endphp
                                                    @if($documentscandidat->isNotEmpty())
                                                        @foreach($documentscandidat as $document)
                                                            <li>
                                                                <p class="text-muted mb-1" style="font-size: 1em">
                                                                    <i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>
                                                                    <strong>Document N° {{$numero++}} : </strong> {{mb_strtoupper($document->libelleDocumentdossier)}}
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- end row -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-3">

                        <div class="user-sidebar">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="user-profile-img">
                                        <img src="assets/images/pattern-bg.jpg"
                                             class="profile-img profile-foreground-img rounded-top" style="height: 120px;"
                                             alt="">
                                        <div class="overlay-content rounded-top">
                                            <div>
                                                <div class="user-nav p-3">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-eva="more-horizontal-outline" data-eva-width="20" data-eva-height="20"
                                                                   class="fill-white"></i>
                                                            </a>

                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                                <li><a class="dropdown-item" href="#">Another action</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="#">Something else
                                                                        here</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end user-profile-img -->

                                    <div class="mt-n5 position-relative">
                                        <div class="text-center">
                                            <img src="{{ session()->has("photo_path") ? asset('storage/'.session("photo_path")) : "assets/images/avatar.png"}}" alt=""
                                                 class="avatar-xl rounded-circle img-thumbnail">

                                            <div class="mt-3">
                                                <h5 class="mb-1">{{$personne->nom . " " . $personne->prenoms}}</h5>
                                                <p class="text-muted">{{$personne->matricule ?? ''}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3">
                                        <div class="row text-center pb-3">
                                            <div class="col-6 border-end">
                                                <div class="p-1">
                                                    <h5 class="mb-1">{{count($listeconcours)}}</h5>
                                                    <p class="text-muted mb-0">Concours</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-1">
                                                    <h5 class="mb-1">{{$nbrdoc . " / " . count($documentscandidat) }}</h5>
                                                    <p class="text-muted mb-0">Docs Chargés</p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mb-4">


                                        <div class="mb-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-3">Dossiers</h5>
                                                </div>
                                                <div>
                                                    <button class="btn btn-link py-0 shadow-none"  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Info">
                                                        <i data-eva="info-outline" class="fill-muted" data-eva-height="20" data-eva-width="20"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @if($personne->valideDossier === 1)

                                                <div class="alert alert-success" role="alert">
                                                    Dossier validé
                                                </div>

                                            @else

                                                <div class="alert alert-danger" role="alert">
                                                    Dossier pas encore validé
                                                </div>

                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <script>document.write(new Date().getFullYear())</script> &copy; Borex. Design & Develop by Themesbrand
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center bg-dark p-3">

            <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

            <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="m-0" />

        <div class="p-4">
            <h6 class="mb-3">Layout</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                       id="layout-vertical" value="vertical">
                <label class="form-check-label" for="layout-vertical">Vertical</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                       id="layout-horizontal" value="horizontal">
                <label class="form-check-label" for="layout-horizontal">Horizontal</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Mode</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                       id="layout-mode-light" value="light">
                <label class="form-check-label" for="layout-mode-light">Light</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                       id="layout-mode-dark" value="dark">
                <label class="form-check-label" for="layout-mode-dark">Dark</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Width</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                       id="layout-width-fluid" value="fluid" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                <label class="form-check-label" for="layout-width-fluid">Fluid</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                       id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                <label class="form-check-label" for="layout-width-boxed">Boxed</label>
            </div>

            <h6 class="mt-4 mb-3">Layout Position</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-position"
                       id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                <label class="form-check-label" for="layout-position-fixed">Fixed</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-position"
                       id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
            </div>

            <h6 class="mt-4 mb-3">Topbar Color</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                       id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                <label class="form-check-label" for="topbar-color-light">Light</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                       id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                <label class="form-check-label" for="topbar-color-dark">Dark</label>
            </div>

            <div id="sidebar-setting">
                <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                    <label class="form-check-label" for="sidebar-size-default">Default</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                    <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-size"
                           id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                    <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                </div>

                <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Color</h6>

                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                    <label class="form-check-label" for="sidebar-color-light">Light</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                    <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color"
                           id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                    <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                </div>
            </div>

            <h6 class="mt-4 mb-3">Direction</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                       id="layout-direction-ltr" value="ltr">
                <label class="form-check-label" for="layout-direction-ltr">LTR</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                       id="layout-direction-rtl" value="rtl">
                <label class="form-check-label" for="layout-direction-rtl">RTL</label>
            </div>

        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- chat offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivity" aria-labelledby="offcanvasActivityLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasActivityLabel">Offcanvas right</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        ...
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenujs/metismenujs.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/eva-icons/eva.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>
