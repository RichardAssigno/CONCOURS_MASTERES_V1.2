<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include("partials.css")

    <style>

        /* Ajuster la taille de l'icône PDF dans Dropzone */
        .dropzone .dz-preview .dz-image img {
            width: 100px;   /* taille réduite en largeur */
            height: 100px;  /* taille réduite en hauteur */
            object-fit: contain; /* garde les proportions */
        }

        .dropzone .dz-preview .dz-image {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;   /* largeur du conteneur */
            height: 80px;  /* hauteur du conteneur */
            overflow: hidden;
            border-radius: 8px; /* arrondir un peu */
        }

        /* Positionne le bouton en haut à droite */
        .dz-preview {
            position: relative; /* nécessaire pour le positionnement absolu du bouton */
        }

        .dz-remove-btn {
            z-index: 100000000;
            margin-top: 50px;
        }

        .dz-remove-btn:hover {
            background: rgba(220, 53, 69, 1);
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
                                                <h5 class="font-size-16 mb-1">Mes Documents</h5>
                                                <p class="text-muted text-truncate mb-0">Cliquez sur les champs pour téléverser vos documents</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                        <div class="p-4 border-top">
                                            <p style="font-weight: bold; color: darkred">
                                                Tous les documents ayant un astérisque (*) sont obligatoires
                                            </p>
                                            <div class="row mb-3">
                                                @if($documents->isNotEmpty())
                                                    @foreach($documents as $index => $document)
                                                        @php
                                                            $files = [];
                                                            if ($document->filePath) {
                                                                $files[] = [
                                                                    "name" => basename($document->filePath),
                                                                    "size" => 4000000,
                                                                    "serverFileName" => $document->filePath,
                                                                    "id" => $document->idDocument ?? 0,
                                                                    "idDossiercandidature" => $document->idDossiercandidature ?? 0,
                                                                ];
                                                            }
                                                        @endphp

                                                        <div class="col-md-3 mb-3">
                                                            <h5 class="text-center">{{$document->codeDocumentdossier}}
                                                                @if($document->requis == 1)
                                                                    <span style="font-size: 1.2em; font-weight: bold; color: darkred">
                                                                        *
                                                                    </span>
                                                                @endif
                                                            </h5>
                                                            <div
                                                                class="dropzone"
                                                                id="dropzoneForm{{ $index }}"
                                                                data-action="{{ route('documents.ajout', ['id' => $document->idDocument ?? 0, 'idDossiercandidature' => $document->idDossiercandidature ?? 0]) }}"
                                                                data-files='@json($files)'
                                                            >
                                                                @csrf
                                                                <div class="dz-message needsclick">
                                                                    <div class="mb-3">
                                                                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                                    </div>
                                                                    <h4>
                                                                        {{ $document->codeDocumentdossier }}
                                                                        @if($document->requis)
                                                                            <span style="font-size: 1.2em; font-weight: bold; color: darkred">*</span>
                                                                        @endif
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <a href="{{route($routeretour)}}" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Retour</a>
                                        <a href="{{route("tableaudebord.index")}}" class="btn btn-success"><i class="mdi mdi-file-document-outline me-1"></i> Tableau de Bord</a>
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
<script>
    // IMPORTANT : doit être exécuté AVANT le chargement de dropzone.js
    Dropzone = window.Dropzone || {}; // garantie safe si Dropzone pas encore défini
    Dropzone.autoDiscover = false;
</script>

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

    document.addEventListener("DOMContentLoaded", function () {
        Dropzone.autoDiscover = false;

        document.querySelectorAll(".dropzone").forEach(function (dropzoneElement) {
            const uploadUrl = dropzoneElement.dataset.action;
            const existingFiles = dropzoneElement.dataset.files
                ? JSON.parse(dropzoneElement.dataset.files)
                : [];

            // Détruire instance si déjà présente
            if (dropzoneElement.dropzone) {
                dropzoneElement.dropzone.destroy();
            }

            let dz = new Dropzone(dropzoneElement, {
                url: uploadUrl,
                paramName: "file",
                acceptedFiles: ".pdf",
                maxFiles: 1,
                maxFilesize: 10, // 10 Mo
                addRemoveLinks: false, // ⚠️ on le gère nous-mêmes
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content },
                init: function () {
                    let myDropzone = this;

                    // ⚡ Charger les fichiers déjà existants
                    existingFiles.forEach(function (fileInfo) {
                        let mockFile = {
                            name: fileInfo.name,
                            size: fileInfo.size,
                            serverFileName: fileInfo.serverFileName,
                            id: fileInfo.id,
                            idDossiercandidature: fileInfo.idDossiercandidature,
                            accepted: true
                        };

                        myDropzone.emit("addedfile", mockFile);

                        // ✅ Icône PDF forcée
                        let pdfIcon = "{{asset("assets/images/pdf.png")}}"; // mets ton chemin correct
                        myDropzone.emit("thumbnail", mockFile, pdfIcon);

                        myDropzone.emit("complete", mockFile);
                        myDropzone.files.push(mockFile);

                        // bouton supprimer
                        addRemoveButton(mockFile, myDropzone);
                    });

                    // Vérification fichier avant upload
                    this.on("addedfile", function (file) {
                        if (file.type !== "application/pdf") {
                            this.removeFile(file);
                            Swal.fire("Erreur", "Seuls les fichiers PDF sont acceptés.", "error");
                            return;
                        }

                        if (file.size > 10 * 1024 * 1024) {
                            this.removeFile(file);
                            Swal.fire("Erreur", "Le fichier doit faire au maximum 10 Mo.", "error");
                            return;
                        }
                    });

                    // Après succès upload
                    this.on("success", function (file, response) {
                        file.serverFileName = response.filePath;
                        file.id = response.id;
                        file.idDossiercandidature = response.idDossiercandidature;

                        let pdfIcon = "{{asset("assets/images/pdf.png")}}"; // mets ton chemin correct
                        this.emit("thumbnail", file, pdfIcon);
                        this.emit("complete", file);

                        Toast.fire({
                            title: "PDF ajouté avec succès",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        addRemoveButton(file, this);
                    });

                    this.on("error", function (file, response) {
                        Swal.fire("Erreur upload", response, "error");
                        this.removeFile(file);
                    });
                }
            });

            // 🔹 Bouton Supprimer personnalisé
            function addRemoveButton(file, dzInstance) {
                if (file._removeButton) return;

                /*let removeButton = Dropzone.createElement(
                    "<button type='button' class='dz-remove-btn btn btn-danger btn-sm' title='Supprimer'>&times;</button>"
                );*/

                let removeButton = Dropzone.createElement(
                    "<button type='button' class='btn btn-danger btn-sm mt-2 dz-remove-btn' style='cursor: pointer'>Supprimer</button>"
                );

                // Ajouter un espace et centrer
                file.previewElement.style.display = "flex";
                file.previewElement.style.flexDirection = "column";
                file.previewElement.style.alignItems = "center";
                file.previewElement.style.gap = "15px"; // <-- espace entre image et bouton

                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $.ajax({
                        url: "{{ route('documents.supprimer') }}",
                        type: "POST",
                        data: {
                            _token: document.querySelector('meta[name="csrf-token"]').content,
                            filePath: file.serverFileName,
                            id: file.id || null,
                            idDossiercandidature: file.idDossiercandidature || null
                        },
                        success: function () {
                            // 🔹 Retirer correctement le fichier de Dropzone
                            dzInstance.removeFile(file);

                            Toast.fire({
                                title: "Supprimé avec succès",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function () {
                            Swal.fire("Erreur", "Impossible de supprimer le fichier.", "error");
                        }
                    });
                });

                file._removeButton = removeButton;
                file.previewElement.appendChild(removeButton);
            }

        });
    });


</script>





</body>

</html>
