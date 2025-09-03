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

                <div class="row">
                    <div class="col-lg-12">
                        <div id="addproduct-accordion" class="custom-accordion">

                            <form id="inscriptionForm">
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
                                                <h5 class="font-size-16 mb-1">Mes notes</h5>
                                                <p class="text-muted text-truncate mb-0">Je renseigne mes notes</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>
                                    </a>

                                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
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
                                                                                    placeholder="Entrez la note" required>
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
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <a href="{{route("formation.index")}}" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Retour</a>
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-file-document-outline me-1"></i> Enrégistrer et continuer</button>
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

    $(document).ready(function() {
        $('.note-input').on('input', function() {
            let val = $(this).val();

            // Remplacer la virgule par un point mais ne pas bloquer la saisie
            val = val.replace(',', '.');

            // Autoriser chiffres et un seul point
            if (/^\d*\.?\d*$/.test(val)) {
                $(this).val(val);
            } else {
                // Supprimer le dernier caractère si invalide
                $(this).val(val.slice(0, -1));
            }
        });

        $('.note-input').on('blur', function() {
            let val = parseFloat($(this).val());

            if (isNaN(val)) {
                $(this).val('');
                return;
            }

            if(val < 0) {
                Swal.fire({
                    title: "Echec",
                    text: "La note ne doit pas être en dessous de 0",
                    icon: "error"
                });
                $(this).val(0);
            } else if(val > 20) {
                Swal.fire({
                    title: "Echec",
                    text: "La note ne doit pas être au dessus de 20",
                    icon: "error"
                });
                $(this).val(20);
            } else {
                // Limiter à 2 décimales si tu veux
                $(this).val(val.toFixed(2));
            }
        });
    });




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

    $('#inscriptionForm').on('submit', function (e) {

        e.preventDefault();

        let url = "{{ route('notes.ajout') }}";

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
                        window.location.href = "{{ route('choix.index') }}";
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
