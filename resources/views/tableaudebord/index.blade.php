
<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    @include("partials.css")
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

        .footer-content {
            background-color: #fff; /* couleur claire comme dans ta capture */
            padding: 15px 0;
            margin-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-content .col-sm-12 {
            font-size: 14px;
            color: grey; /* gris doux */
        }



    </style>

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
                @if (session('echec'))
                    <div class="alert alert-danger">
                        {{ session('echec') }}
                    </div>
                @elseif(session('succes'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('succes') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>

                                            <div class="d-flex align-items-start gap-2">
                                                <!-- Bouton principal (sac d'achat) -->
                                                <div class="flex-grow-1">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-primary bg-gradient">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-shopping-bag fill-white">
                                                                <g data-name="Layer 2"><g data-name="shopping-bag">
                                                                        <rect width="24" height="24" opacity="0"></rect>
                                                                        <path d="M20.12 6.71l-2.83-2.83A3 3 0 0 0 15.17 3H8.83a3 3 0 0 0-2.12.88L3.88 6.71A3 3 0 0 0 3 8.83V18a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V8.83a3 3 0 0 0-.88-2.12zM12 16a4 4 0 0 1-4-4 1 1 0 0 1 2 0 2 2 0 0 0 4 0 1 1 0 0 1 2 0 4 4 0 0 1-4 4zM6.41 7l1.71-1.71A1.05 1.05 0 0 1 8.83 5h6.34a1.05 1.05 0 0 1 .71.29L17.59 7z"></path>
                                                                    </g></g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Bouton Profil -->
                                                <a href="" data-bs-toggle="tooltip" id="btnProfil" data-bs-placement="top" data-bs-original-title="Voir la liste des candidats">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-info bg-gradient">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="mt-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h4 class="text-truncate mb-1">{{$personne->matricule ?? ""}}</h4>
                                                        <p class="text-truncate text-muted mb-0">Matricule</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <div class="d-flex align-items-start gap-2">
                                                <div class="flex-grow-1">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-primary bg-gradient">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-pie-chart-2 fill-white"><g data-name="Layer 2"><g data-name="pie-chart-2"><rect width="24" height="24" opacity="0"></rect><path d="M14.5 10.33h6.67A.83.83 0 0 0 22 9.5 7.5 7.5 0 0 0 14.5 2a.83.83 0 0 0-.83.83V9.5a.83.83 0 0 0 .83.83zm.83-6.6a5.83 5.83 0 0 1 4.94 4.94h-4.94z"></path><path d="M21.08 12h-8.15a.91.91 0 0 1-.91-.91V2.92A.92.92 0 0 0 11 2a10 10 0 1 0 11 11 .92.92 0 0 0-.92-1z"></path></g></g></svg>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Bouton Profil -->
                                                <a href="" data-bs-toggle="tooltip" id="btnProfil2" data-bs-placement="top" data-bs-original-title="Voir la liste des candidats">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-info bg-gradient">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="mt-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h4 class="text-truncate mb-1">{{$personne->email ?? ""}}</h4>
                                                        <p class="text-truncate text-muted mb-0">Email</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <div class="d-flex align-items-start gap-2">
                                                <div class="flex-grow-1">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-primary bg-gradient">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-activity fill-white"><g data-name="Layer 2"><g data-name="activity"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect><path d="M14.33 20h-.21a2 2 0 0 1-1.76-1.58L9.68 6l-2.76 6.4A1 1 0 0 1 6 13H3a1 1 0 0 1 0-2h2.34l2.51-5.79a2 2 0 0 1 3.79.38L14.32 18l2.76-6.38A1 1 0 0 1 18 11h3a1 1 0 0 1 0 2h-2.34l-2.51 5.79A2 2 0 0 1 14.33 20z"></path></g></g></svg>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Bouton Excel -->
                                                <a href="{{route("fiche.telecharger")}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Télécharger la liste en Excel">
                                                    <div class="avatar">
                                                        <div class="avatar-title rounded bg-success bg-gradient">
                                                            <i class="fas fa-file-download text-white"></i>
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                            <div class="mt-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h4 class="text-truncate mb-1">Imprimer ma fiche</h4>
                                                        <p class="text-truncate text-muted mb-0">Fiche</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="card">
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
                                                <h5 class="font-size-16 mb-1">Mes Concours </h5>
                                                <p class="text-muted text-truncate mb-0">Concours auxquels j'ai postulé</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>

                                        </div>

                                    </div>
                                </a>

                                <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                                    <div class="container">

                                        <div class="row mb-3">

                                            <div class="d-flex center">
                                                <input id="concours-filter" type="text" class="form-control" placeholder="Filtrer ici...">
                                            </div>

                                        </div>

                                        <div class="row">

                                            @php $i = 1 @endphp

                                            @if($listeconcours->isNotEmpty())
                                                @foreach($listeconcours as $value)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 card-filter">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="avatar">
                                                        <span class="avatar-title rounded bg-light text-danger font-size-16">
                                                            <img src="{{ asset('assets/images/logoinphb.png') }}" alt="" height="30">
                                                        </span>
                                                                    </div>
                                                                    <div class="ms-auto">
                                                                        <div class="dropdown float-end">
                                                                            <a class="text-muted dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <a class="dropdown-item btnConnexionConcours" href="#" data-id="{{$value->idConcours}}">Se connecter</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="flex-grow-1 mt-4">
                                                                    <h5 class="font-size-15">
                                                                        <a href="" class="text-dark">{{ $value->libelleConcours ." - " . $value-> codeConcours}} </a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="px-4 py-2 border-top text-center">

                                                                @php $isCurrent = $value->idSession == session('sessions'); @endphp

                                                                <a href="javascript:void(0);"
                                                                   class="btn btn-sm {{ $isCurrent ? 'btn-success disabled' : 'btn-primary change-session' }}"
                                                                   data-id="{{ $value->idSession }}"
                                                                   @if($isCurrent) aria-disabled="true" @endif>
                                                                    <i class="mdi mdi-file-document-outline me-1"></i>
                                                                    {{ $isCurrent ? 'Connecté' : 'Se connecter' }}
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        {{--<div class="card">
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
                                                                    <img src="{{asset("assets/images/logo-dark-sm.png")}}" alt="" height="30">
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
                                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$concours->libelleConcours . ' - ' . $concours->codeConcours}}</a></h5>
                                                            --}}{{--<p class="text-muted mb-0">Etat d'avancement de mon inscription</p>--}}{{--

                                                            --}}{{--<div class="mt-3 mb-1">
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
                                                            </div>--}}{{--
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-2 border-top">
                                                        <div class="text-center btn-sm">

                                                            @php $isCurrent = $concours->idSession == session('sessions'); @endphp

                                                            <a href="javascript:void(0);"
                                                               class="btn btn-sm {{ $isCurrent ? 'btn-success disabled' : 'btn-primary change-session' }}"
                                                               data-id="{{ $concours->idSession }}"
                                                               @if($isCurrent) aria-disabled="true" @endif>
                                                                <i class="mdi mdi-file-document-outline me-1"></i>
                                                                {{ $isCurrent ? 'Connecté' : 'Se connecter' }}
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    @endif
                                </div>
                            </div>
                            </div>
                        </div>--}}
                        <!-- end card -->
                        @if(!is_null($personne->nom) && !is_null($personne->prenoms) && !is_null($personne->dateNaissance))
                            <div class="row">
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
                                                    @if(session("notes") === "1")
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
                                                                <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Date et lieu de Naissance : </strong>{{ mb_strtoupper($personne->genre) == "M" ? "Né le " : "Née le " }}{{\Carbon\Carbon::parse($personne->dateNaissance)->format('d/m/Y') . ' à ' . $personne->lieuNaissance}}</p></li>
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
                                                                @if(session()->has("codeconcours"))
                                                                    @if(mb_strtoupper(session("codeconcours")) == "MSTAU")
                                                                        <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Niveau d'Etude : </strong>{{mb_strtoupper($personne->niveauetudes ?? "")}}</p></li>
                                                                        <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Profession : </strong>{{mb_strtoupper($personne->professions ?? "")}}</p></li>
                                                                        <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Employeur : </strong>{{$personne->employeurs ?? ""}}</p></li>
                                                                        <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Expériences : </strong>{{mb_strtoupper($personne->experiences ?? "")}}</p></li>
                                                                        <li><p class="text-muted mb-0" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Source de Financement : </strong>{{mb_strtoupper($personne->financements ?? "")}}</p></li>
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
                                                            @php $numero = 1 @endphp
                                                            @if($choix->isNotEmpty())
                                                                @foreach($choix as $value)
                                                                    <li><p class="text-muted mb-1" style="font-size: 1.2em"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i><strong>Concours {{count($choix) > 1 ? $numero++ : ""}} : </strong> {{mb_strtoupper($value->libelleFiliere . ' ' . "( ". " " .$value->codeFiliere . " )")}} </p></li>
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
                                                    <h5 class="font-size-14">Documents Chargés ( {{$nbrdoc . " / " . count($documents)}} ):</h5>
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
                        </div>
                        @endif

                    </div>
                    <!-- end col -->
                    <div class="col-md-3 col-sm-12">

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
                                                    <h5 class="mb-1">{{$nbrdoc . " / " . count($documents) }}</h5>
                                                    <p class="text-muted mb-0">Docs Chargés</p>
                                                </div>
                                            </div>
                                        </div>



                                        <hr class="mb-4">


                                        <div class="mb-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-3">Postuler à un autre Concours</h5>
                                                </div>
                                                <div>
                                                    <button class="btn btn-link py-0 shadow-none"  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" title="Info">
                                                        <i data-eva="info-outline" class="fill-muted" data-eva-height="20" data-eva-width="20"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Postuler ici</button>
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
                                            @if((int)$personne->valideDossier === 1)

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
        <div id="choixConcoursModal" class="modal fade" tabindex="-1" aria-labelledby="choixConcoursModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Les concours Ouvert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">

                            <div class="row mb-3">

                                <div class="d-flex center">
                                    <input id="concours-filter1" type="text" class="form-control" placeholder="Filtrer ici...">
                                </div>

                            </div>

                            <div class="row" id="listeConcours1">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Fermez</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
    <!-- end main content-->
    @include("partials.footer")

</div>
<!-- END layout-wrapper -->


@include("partials.js")


<script src="{{asset('assets/js/filterconcours.js')}}"></script>

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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Étape 1 : interception du premier formulaire
    $('#btn-new-event').on('click', function(e) {

        e.preventDefault();

        showLoader('Connexion en cours...');

        // Appel AJAX pour récupérer les concours liés à l'utilisateur
        $.ajax({
            url: "{{ route('concours.recupererconcours') }}",
            method: "GET",
            success: function(response) {
                hideLoader('');
                if (response.success && response.concours.length > 0) {

                    // Sélectionne la zone où afficher les concours
                    let container = $('#listeConcours1');
                    container.empty(); // vide le contenu avant d’ajouter

                    // Parcours des concours
                    response.concours.forEach(function(concours) {
                        let card = `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 card-filter1">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="avatar">
                                    <span class="avatar-title rounded bg-light text-danger font-size-16">
                                        <img src="{{ asset('assets/images/logoinphb.png') }}" alt="" height="30">
                                    </span>
                                </div>
                                <div class="ms-auto">
                                    <div class="dropdown float-end">
                                        <a class="text-muted dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#" data-id="${concours.idSession}">S'inscrire</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-grow-1 mt-4">
                                <h5 class="font-size-15">
                                    <a href="javascript:void(0);" class="text-dark">${concours.libelleConcours} - ${concours.codeConcours}</a>
                                </h5>
                            </div>
                        </div>
                        <div class="px-4 py-2 border-top text-center">
                            <button class="btn btn-sm btn-primary btnConnexionConcours" data-id="${concours.idSession}">
                                <i class="mdi mdi-file-document-outline me-1"></i>
                                S'inscrire
                            </button>
                        </div>
                    </div>
                </div>`;

                        container.append(card);
                    });

                    // Afficher le modal après avoir ajouté les concours
                    $('#choixConcoursModal').modal('show');

                } else {
                    hideLoader('');
                    Swal.fire(
                        'Aucun concours',
                        response.message || 'Aucun concours trouvé pour cet utilisateur.',
                        'info'
                    );
                }
            },

            error: function(response) {
                hideLoader('');
                let errorMsg = response.responseJSON?.errors || "Erreur inconnue";

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: errorMsg
                });
            }
        });
    });


    $(document).on('click', '.btnConnexionConcours', function(e) {
        e.preventDefault();

        showLoader('Chargement en cours...');

        let sessionId = $(this).data('id');


        $.ajax({
            url: `/inscription-concours/${sessionId}`,
            method: "get",
            success: function(response) {
                hideLoader();
                Toast.fire({
                    title: response.success || 'Connexion réussie',
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = response.redirect;
                }, 1500);

            },
            error: function(xhr) {
                hideLoader();
                let message = "Une erreur est survenue";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    message = xhr.responseJSON.errors;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de connexion',
                    text: message
                });
            }
        });
    });


    $(document).on('click', '.change-session', function (e) {
        e.preventDefault();

        let idSession = $(this).data('id');

        $.ajax({
            url: "{{ route('changer.session') }}",
            type: "POST",
            data: {
                idSession: idSession,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        title: response.message, // 🔹 car c'est ici que le message est stocké
                        position: "top-end",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            },
            error: function () {
                Swal.fire({
                    title: "Echec",
                    text: "Echec de changement de concours",
                    icon: "error"
                });
            }
        });
    });



</script>

</body>

</html>
