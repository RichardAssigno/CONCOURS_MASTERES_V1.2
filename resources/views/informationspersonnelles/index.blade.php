<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    @include("partials.css")

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

        .dz-image img {
            width: 100%;
            height: auto;
            max-width: 300px; /* limite la largeur */
            object-fit: cover; /* garde de belles proportions */
        }

        .btn-supprimer:hover{

            cursor: pointer;

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

                <div class="row">
                    <div class="col-md-12">
                        <div id="addproduct-accordion" class="custom-accordion">

                            <!-- ==================== Photo ==================== -->
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
                                                <h5 class="font-size-16 mb-1">Photo d'Identité</h5>
                                                <p class="text-muted text-truncate mb-0">Téléversez votre photo d'identité</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>

                                        </div>

                                    </div>
                                </a>

                                <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6">
                                            <div class="p-4 border-top w-100">
                                                <form id="myDropzone" action="{{route("infos.ajoutphoto")}}" method="post" class="dropzone d-flex flex-column align-items-center justify-content-center" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="dz-message needsclick text-center">
                                                        <div class="mb-3">
                                                            <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                                        </div>
                                                        <h4>Cliquez pour ajouter une photo d'identité</h4>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- ==================== Boutons ==================== -->

                            <form id="inscriptionForm" method="post">
                                @csrf
                                <!-- ==================== Infos personnelles ==================== -->
                                <div class="card">
                                    <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                                        <div class="p-4 d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title font-size-16 rounded-circle bg-soft-primary text-primary">02</div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="font-size-16 mb-1">Infos Personnelles</h5>
                                                <p class="text-muted text-truncate mb-0">Je remplis mes infos personnelles</p>
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
                                                    <label class="form-label" for="nom">Nom</label>
                                                    <input id="nom" name="nom" type="text" value="{{ $personnes?->nom ?? '' }}" class="form-control" placeholder="Entrez votre nom">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="prenoms">Prénoms</label>
                                                    <input id="prenoms" name="prenoms" type="text" value="{{ $personnes?->prenoms ?? '' }}" class="form-control" placeholder="Entrez vos prénoms">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="dateNaissance">Date de Naissance</label>
                                                    <input id="dateNaissance" value="{{ $personnes?->dateNaissance ?? '' }}" name="dateNaissance" type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="lieuNaissance">Lieu de Naissance</label>
                                                    <input id="lieuNaissance" value="{{ $personnes?->lieuNaissance ?? '' }}" name="lieuNaissance" type="text" class="form-control" placeholder="Lieu de naissance">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="telephone">Téléphone</label>
                                                    <input id="telephone" value="{{ $personnes?->telephone ?? '' }}" name="telephone" type="text" class="form-control" placeholder="Téléphone">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="anneebacs_id" class="form-label">Année du BAC</label>
                                                        <select class="form-select select2" name="anneebacs_id"
                                                                id="anneebacs_id">
                                                            <option value="">Sélectionnez</option>
                                                            @if($anneebacs->isNotEmpty())

                                                                @foreach($anneebacs as $value)

                                                                    <option {{ ($personnes?->idAnneebac ?? 0) == $value->id ? "selected" : "" }} value="{{$value->id}}">
                                                                        {{$value->libelle}}
                                                                    </option>


                                                                @endforeach

                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="genre" class="form-label">Genre</label>
                                                        <select class="form-select select2" name="genre"
                                                                id="genre">
                                                            <option {{($personnes?->genre ?? '') == "Masculin" ? "selected": ""}}  value="M">Masculin</option>
                                                            <option {{($personnes?->genre ?? '') == "Féminin" ? "selected": ""}} value="F">Féminin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="nomEtPrenomsDunProche">Nom et Prénoms d'un Proche</label>
                                                        <input id="nomEtPrenomsDunProche" name="nomEtPrenomsDunProche" value="{{ $personnes?->nomEtPrenomsDunProche ?? '' }}" placeholder="Entrez le nom et le Prénoms d'un Proche" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="telephoneDunProche">Téléphone d'un Proche</label>
                                                        <input id="telephoneDunProche" name="telephoneDunProche" value="{{ $personnes?->telephoneDunProche ?? '' }}" placeholder="Entrez le numéro de Téléphone d'un Proche" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-file-document-outline me-1"></i> Enrégistrez et continuez</button>
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

    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Sélectionnez un élément",
            allowClear: true
        });

    });

    Dropzone.autoDiscover = false;

    let dz = new Dropzone("#myDropzone", {
        url: "{{ route('infos.ajoutphoto') }}",
        paramName: "file",
        acceptedFiles: "image/*",
        maxFiles: 1,
        maxFilesize: 3,
        addRemoveLinks: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            let myDropzone = this;

            // ⚡ Charger l'image existante
            @if(!is_null($personnes?->photo_path))
                let mockFile = {
                    name: "{{ $personnes->photo_nom }}",
                    size: 12345,
                    serverFileName: "{{ $personnes->photo_path }}",
                    accepted: true,
                    status: Dropzone.ADDED
                };

                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, "{{ asset('storage/'.$personnes->photo_path) }}");
                myDropzone.emit("complete", mockFile);
                myDropzone.files.push(mockFile);

                addRemoveButton(mockFile, myDropzone);
            @endif

                this.on("addedfile", function(file) {
                addRemoveButton(file, myDropzone);
            });

            this.on("success", function(file, response) {
                file.serverFileName = response.fileName;
                Toast.fire({
                    title: "Photo ajoutée avec succès",
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
            });

            this.on("error", function(file, response) {
                Swal.fire({
                    title: "Erreur upload",
                    text: response,
                    icon: "error"
                });
            });
        }
    });

    function addRemoveButton(file, dzInstance) {
        let removeButton = Dropzone.createElement("<button class='btn btn-danger btn-sm mt-2 btn-supprimer'>Supprimer</button>");
        removeButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();

            if(file.serverFileName) {
                $.ajax({
                    url: "{{ route('infos.supprimerphoto') }}",
                    type: 'POST',
                    data: { fileName: file.serverFileName },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Toast.fire({
                            title: "Photo supprimée avec succès",
                            position: "top-end",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Erreur lors de la suppression",
                            text: xhr.responseText,
                            icon: "error"
                        });
                    }
                });
            }

            dzInstance.removeFile(file);
        });

        file.previewElement.appendChild(removeButton);
    }



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

        let url = "{{ route('infos.ajout') }}";

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
                        window.location.href = "{{ route('formation.index') }}";
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
