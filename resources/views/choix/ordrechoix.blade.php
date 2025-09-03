<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    @include("partials.css")

    <link href="{{ asset('assets/nestable/nestable.css')}}" rel="stylesheet" type="text/css" />

    <style>

        .choix-box {
            white-space: normal !important;  /* Autorise le retour à la ligne */
            word-wrap: break-word;           /* Coupe le mot si trop long */
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
                                                <h5 class="font-size-16 mb-1">Ordonner mes Choix du Concours</h5>
                                                <p class="text-muted text-truncate mb-0">Faites un glisser déposer pour ordonner le choix de votre concours</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                        </div>
                                    </a>

                                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                        <div class="p-4 border-top">
                                            <div class="row ">
                                                <div class=" d-flex justify-content-center ">
                                                    <div class="col-md-10 mb-3  offset-md-2 col-sm-12 offset-sm-0">
                                                        <div class="dd" id="nestable">
                                                            <ol class="dd-list">

                                                                @php $i=1; @endphp
                                                                @foreach($choix as $value)
                                                                    <li class="dd-item" data-id="{{$i}}">
                                                                        <div class="dd-handle">

                                                                            <i class="fa fa-fw fa-arrows-v"></i>
                                                                            <input type="hidden" id="" name="{{$value->id}}" value="{{$value->id}}"  class="positionInput" />
                                                                            <div  id="{{$value->id}}"  class="positionInput btn btn-primary">
                                                                                {{$i++}}
                                                                            </div>
                                                                            {{$value->libelleFiliere}}
                                                                        </div>
                                                                    </li>
                                                                @endforeach

                                                            </ol>
                                                        </div>
                                                        <div>
                                                            <input type="hidden"  id="nestable-output" rows="3" class="form-control font-md" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col text-center">
                                        <a href="{{route("choix.index")}}" class="btn btn-danger"><i class="mdi mdi-close me-1"></i> Retour</a>
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

<script src="{{asset('assets/nestable/nestable.min.js')}}"></script>

<script>

    $(document).ready(function(){

        $('#nestable').nestable().on('change', function() {
            console.log($('#nestable').nestable('serialize'));
        });

        var updateOutput = function(e) {

            var list = e.length ? e : $(e.target), output = list.data('output');

            if (window.JSON) {

                var pos =0;
                $(list.find("li")).each(function(){
                    pos++;
                    $(this).find("div.dd-handle > input.positionInput").val(pos);
                    $(this).find("div.dd-handle > div.positionInput").html(pos);
                });
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            group : 1
        }).on('change', updateOutput);


        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));


        $('#nestable3').nestable();

    })

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

        let url = "{{ route('choix.ajoutordrechoix') }}";

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
                        window.location.href = "{{ route('documents.index') }}";
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
