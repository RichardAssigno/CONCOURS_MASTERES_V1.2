<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Connexion'])

    @include("partials.css")
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0 align-items-center">
            <div class="col-xxl-4 col-lg-4 col-md-6">
                <div class="row justify-content-center g-0">
                    <div class="col-xl-9">
                        <div class="p-4">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                        <div class="w-100">
                                            <div class="d-flex flex-column h-100">
                                                <div class="mb-4 mb-md-5">
                                                    <a href="#" class="d-block auth-logo">
                                                        <img src="{{asset("assets/images/logo-dark.png")}}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-dark me-start">
                                                        <img src="{{asset("assets/images/logo-light.png")}}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-light me-start">
                                                    </a>
                                                </div>
                                                <div class="auth-content my-auto">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Bienvenue !</h5>
                                                        <p class="text-muted mt-2">Connectez vous pour continuer votre inscription.</p>
                                                    </div>
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
                                                    <form class="mt-4 pt-2" method="POST" id="connexion">
                                                        @csrf
                                                        <div class="form-floating form-floating-custom mb-4">
                                                            <input type="email" class="form-control" id="email" placeholder="Enter User Name" name="email">
                                                            <label for="input-username">Email</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="email-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                            <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                </button>
                                                                <label for="password-input">Password</label>
                                                                <div class="form-floating-icon">
                                                                    <i data-eva="lock-outline"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <div class="form-check font-size-15">
                                                                    <input class="form-check-input" name="remenber" type="checkbox" id="remember-check">
                                                                    <label class="form-check-label font-size-13" for="remember-check">
                                                                        Se souvenir de moi
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="mb-3">
                                                            <button class="btn btn-primary w-100 waves-effect waves-light">Se Connecter</button>
                                                        </div>
                                                    </form>

                                                    <div class="mt-4 pt-3 text-center">
                                                        <p class="text-muted mb-0">Vous n'avez pas de compte ? <a href="{{route("inscription")}}" class="text-primary fw-semibold"> S'inscrire </a> </p>
                                                    </div>
                                                </div>
                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> INP-HB </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-8 col-lg-8 col-md-6">
                <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-white"></div>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-8">
                            <div class="mt-4">
                                <img src="{{asset("./assets/images/login-img.png")}}" class="img-fluid" alt="">
                            </div>
                            <div class="p-0 p-sm-4 px-xl-0 py-5">
                                <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>

                                    <!-- end carouselIndicators -->
                                    <div class="carousel-inner w-75 mx-auto">
                                        <div class="carousel-item active">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">
                                                    « L’avenir appartient à ceux qui s’y préparent »
                                                </h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    À l’INP-HB, nous croyons que chaque candidat porte en lui une graine d’excellence.
                                                    Ces concours sont plus qu’une étape : ils sont une porte ouverte vers votre avenir, vos ambitions et vos réussites.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">« L’excellence au cœur de la formation »</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Les concours d’entrée à l’INP-HB incarnent une exigence académique et une ouverture vers l’innovation.
                                                    Notre mission est de sélectionner et de former les talents de demain, prêts à relever les défis du développement et de la compétitivité mondiale.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">« Préparez-vous, votre futur commence ici »</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Intégrer l’INP-HB, c’est rejoindre une communauté d’apprenants, de chercheurs et de bâtisseurs.
                                                    Chaque effort compte, chaque étape vous rapproche de vos rêves. Saisissez cette opportunité et révélez votre potentiel.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>

<!-- Modal de sélection du concours -->
<!-- end row -->
<div id="choixConcoursModal" class="modal fade" tabindex="-1" aria-labelledby="choixConcoursModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalFullscreenLabel">Les concours Ouverts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">

                    <div class="row mb-3">

                        <div class="d-flex center">
                            <input id="concours-filter" type="text" class="form-control" placeholder="Filtrer ici...">
                        </div>

                    </div>

                    <div class="row" id="listeConcours">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Fermez</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- JAVASCRIPT -->
@include("partials.js")

<script src="{{asset('assets/js/filterconcours.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function() {

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
        // Étape 1 : interception du premier formulaire
        $('#connexion').on('submit', function(e) {

            e.preventDefault();

            showLoader('Connexion en cours...');

            let email = $('#email').val();
            let password = $('#password').val();

            if (!email || !password) {
                Swal.fire('Champs requis', 'Veuillez remplir l’email et le mot de passe', 'warning');
                return;
            }

            // Appel AJAX pour récupérer les concours liés à l'utilisateur
            $.ajax({
                url: "{{ route('login.concours') }}",
                method: "POST",
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    hideLoader('');
                    if (response.success && response.concours.length > 0) {

                        // Sélectionne la zone où afficher les concours
                        let container = $('#listeConcours');
                        container.empty(); // vide le contenu avant d’ajouter

                        // Parcours des concours
                        response.concours.forEach(function(concours) {
                            let card = `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 card-filter">
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
                                            <a class="dropdown-item" href="#" data-id="${concours.idSession}">Se connecter</a>
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
                                Se connecter
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

        // Étape 2 : soumission finale du formulaire complet (avec concours)
        $(document).on('click', '.btnConnexionConcours', function(e) {
            e.preventDefault();

            showLoader('Connexion en cours...');

            let sessionId = $(this).data('id');

            $.ajax({
                url: `/login/${sessionId}`,
                method: "get",
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(response) {
                    hideLoader('');
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
                    hideLoader('');
                    let message = "Une erreur est survenue";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de connexion',
                        text: message
                    });
                }
            });
        });
    })

</script>

</body>
</html>
