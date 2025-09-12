<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Mon emploi'])

    @include("partials.css")

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
                                                <h5 class="font-size-16 mb-1">Mon Emploi</h5>
                                                <p class="text-muted text-truncate mb-0">Je remplis mes informations concernant mon emploi</p>
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
                                                        <label for="professions" class="form-label">Professions</label>
                                                        <input type="text" class="form-control" value="{{ $personnes?->professions ?? '' }}" id="professions" name="professions">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="employeurs" class="form-label">Employeur</label>
                                                        <input type="text" class="form-control" value="{{ $personnes?->employeurs ?? '' }}" id="employeurs" name="employeurs">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="">
                                                        <label for="experiences" class="form-label">Année d'expérience</label>
                                                        <select class="form-select select2" name="experiences"
                                                                id="experiences">
                                                            @if(!is_null($personnes->experiences))
                                                                <option value="{{ $personnes?->experiences ?? '' }}">{{ $personnes?->experiences ?? '' }}</option>
                                                            @else
                                                                <option value="">Sélectionnez une année</option>
                                                            @endif

                                                            @for($annee = 1; $annee <= 45; $annee++)
                                                                <option value="{{ $annee }} an(s)">{{ $annee }} an(s)</option>
                                                            @endfor

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <a href="{{route("formation.index")}}" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Précédent</a>
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

    @include("partials.footer")

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



    $('#inscriptionForm').on('submit', function (e) {

        e.preventDefault();

        let url = "{{ route('emploi.ajout') }}";

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
                } else {
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
    });
</script>


</body>

</html>
