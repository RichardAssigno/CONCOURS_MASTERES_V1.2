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
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div id="addproduct-accordion" class="custom-accordion">

                            <form id="inscriptionForm" method="post">
                                @csrf
                                <!-- ==================== Infos personnelles ==================== -->
                                <div class="card">
                                    <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                                        <div class="p-4 d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title font-size-16 rounded-circle bg-soft-primary text-primary">01</div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Mes formations</h5>
                                                <p class="text-muted text-truncate mb-0">Je remplis mes Formations</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>
                                    </a>

                                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                        <div class="p-4 border-top">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="lycee" class="form-label">Lycée d'Origine (Lycée ou Collège)</label>
                                                        <select class="form-select select2" name="lycee"
                                                                id="lycee">
                                                            <option value="AUTRE">AUTRE</option>
                                                            @if($lycees->isNotEmpty())
                                                                @foreach($lycees as $lycee)
                                                                    <option value="{{$lycee->id}}" {{ $personnes?->idLycee == $lycee->id ? 'selected' : '' }}>{{mb_strtoupper($lycee->libelle)}}</option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                        <input type="text" class="form-control mt-2 d-none" name="lycee_autre" id="lycee_autre" placeholder="Précisez le lycée">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="serie" class="form-label">Série</label>
                                                        <select class="form-select select2" name="serie"
                                                                id="serie">
                                                            <option value="AUTRE">AUTRE</option>
                                                            @if($series->isNotEmpty())
                                                                @foreach($series as $serie)
                                                                    <option value="{{$serie->id}}" {{ $personnes?->idSerie == $serie->id ? 'selected' : '' }}>{{mb_strtoupper($serie->libelle)}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <input type="text" class="form-control mt-2 d-none" name="serie_autre" id="serie_autre" placeholder="Précisez la série">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="">
                                                        <label for="diplome" class="form-label">Diplôme</label>
                                                        <select class="form-select select2" name="diplome"
                                                                id="diplome">
                                                            <option value="AUTRE">AUTRE</option>
                                                            @if($diplomes->isNotEmpty())
                                                                @foreach($diplomes as $diplome)
                                                                    <option value="{{$diplome->id}}" {{ $personnes?->idDiplome == $diplome->id ? 'selected' : '' }}>{{ mb_strtoupper($diplome->libelle) }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <input type="text" class="form-control mt-2 d-none" name="diplome_autre" id="diplome_autre" placeholder="Précisez le diplôme">
                                                    </div>
                                                </div>

                                            </div>
                                            @if( session()->has("cycles"))
                                                @if(mb_strtoupper(session("cycles")) != "BACHELIER")
                                                    <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="etablissementsuperieur" class="form-label">Etablissement superieure d'Origine</label>
                                                        <select class="form-select select2" name="etablissementsuperieur"
                                                                id="etablissementsuperieur">
                                                            <option value="AUTRE">AUTRE</option>
                                                            @if($etablissements->isNotEmpty())
                                                                @foreach($etablissements as $etablissement)
                                                                    <option value="{{$etablissement->id}}" {{ $personnes?->idEtablissement == $etablissement->id ? 'selected' : '' }}>{{mb_strtoupper($etablissement->libelle)}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <input type="text" class="form-control mt-2 d-none" name="etablissement_autre" id="etablissement_autre" placeholder="Précisez l'établissement">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="">
                                                        <label for="specialite" class="form-label">Spécialités</label>
                                                        <select class="form-select select2" name="specialite"
                                                                id="specialite">
                                                            <option value="AUTRE">AUTRE</option>
                                                            @if($specialites->isNotEmpty())
                                                                @foreach($specialites as $specialite)
                                                                    <option value="{{$specialite->id}}" {{ $personnes?->idSpecialite == $specialite->id ? 'selected' : '' }}>{{mb_strtoupper($specialite->libelle)}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <input type="text" class="form-control mt-2 d-none" name="specialite_autre" id="specialite_autre" placeholder="Précisez la spécialité">
                                                    </div>
                                                </div>
                                            </div>
                                                @endif
                                            @endif
                                            @if(session()->has("codeconcours"))
                                                @if(mb_strtoupper(session("codeconcours")) == "MSTAU")
                                                    <div class="row d-flex justify-center">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="telephoneDunProche">Niveau d'etude</label>
                                                            <select class="form-select select2" name="niveauetudes"
                                                                    id="niveauetudes">
                                                                <option value=""> Sélectionnez un niveau d'Etude</option>
                                                                <option {{($personnes?->niveauetudes ?? '') == mb_strtoupper("BAC+4") ? "selected": ""}}  value="{{mb_strtoupper("BAC+4")}}">{{mb_strtoupper("BAC+4")}}</option>
                                                                <option {{($personnes?->niveauetudes ?? '') == mb_strtoupper("BAC+5") ? "selected": ""}} value="{{mb_strtoupper("BAC+5")}}">
                                                                    {{mb_strtoupper("BAC+5")}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <a href="{{route("infos.index")}}" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Précédent</a>
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-file-document-outline me-1"></i>Enrégistrez et continuez</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>
    <!-- end main content-->

    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@include("partials.right-sidebar")

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



    $(document).ready(function () {

        $('.select2').select2({
            placeholder: "Sélectionnez un élément",
            allowClear: true
        });


        // Fonction générique
        function toggleAutre(selectId, inputId, triggerValue = "AUTRE") {
            $(`#${selectId}`).on('change', function () {
                let value = $(this).val();
                if (value === triggerValue) {
                    $(`#${inputId}`).removeClass('d-none').prop('required', true);
                    setTimeout(function() {
                        $(`#${inputId}`).focus();
                    }, 100);
                } else {
                    $(`#${inputId}`).addClass('d-none').prop('required', false).val('');
                }
            });
        }

        // 🔹 Appel de la fonction pour tes différents champs
        toggleAutre("serie", "serie_autre", "AUTRE");
        toggleAutre("diplome", "diplome_autre", "AUTRE");
        toggleAutre("lycee", "lycee_autre", "AUTRE");
        toggleAutre("specialite", "specialite_autre", "AUTRE");
        toggleAutre("etablissementsuperieur", "etablissement_autre", "AUTRE");
    });


    $('#inscriptionForm').on('submit', function (e) {

        e.preventDefault();

        let url = "{{ route('formation.ajout') }}";

        let formData = $(this).serialize();

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        title: response.success, // 🔹 car c'est ici que le message est stocké
                        position: "top-end",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 1500);
                }
                else{
                    Swal.fire({
                        title: "Echec",
                        text: response.message,
                        icon: "error"
                    });
                }


            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errorHtml = "Une erreur est survenue.";

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorHtml = Object.values(xhr.responseJSON.errors).map(e => e.join("\n")).join("\n");
                    }

                    Swal.fire({
                        title: "Erreur!",
                        text: errorHtml,
                        icon: "error"
                    });

                } else {
                    Swal.fire({
                        title: "Erreur!",
                        text: xhr.responseJSON.errors,
                        icon: "error"
                    });

                }
            }

        });
    });
</script>


</body>

</html>
