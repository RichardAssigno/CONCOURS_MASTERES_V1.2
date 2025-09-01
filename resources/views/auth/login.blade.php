<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Connexion'])

    @include("partials.css")

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
                                                    <a href="index.html" class="d-block auth-logo">
                                                        <img src={{asset("assets/images/logo-dark.png")}}"" alt="" height="22" class="auth-logo-dark me-start">
                                                        <img src="{{asset("assets/images/logo-light.png")}}" alt="" height="22" class="auth-logo-light me-start">
                                                    </a>
                                                </div>
                                                <div class="auth-content my-auto">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Bienvenue !</h5>
                                                        <p class="text-muted mt-2">Connectez vous pour continuer votre inscription.</p>
                                                    </div>
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
                                                <h5 class="font-size-20 mt-4">“I feel confident
                                                    imposing change
                                                    on myself”
                                                </h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">Vestibulum auctor orci in risus iaculis consequat suscipit felis rutrum aliquet iaculis
                                                    augue sed tempus In elementum ullamcorper lectus vitae pretium Aenean sed odio dolor Nullam ultricies diam
                                                    eu ultrices tellus eifend sagittis.</p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">“Our task must be to
                                                    free widening our circle”</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Curabitur eget nulla eget augue dignissim condintum Nunc imperdiet ligula porttitor commodo elementum
                                                    Vivamus justo risus fringilla suscipit faucibus orci luctus
                                                    ultrices posuere cubilia curae lectus non ultricies cursus.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">“I've learned that
                                                    people will forget what you”</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Pellentesque lacinia scelerisque arcu in aliquam augue molestie rutrum magna Fusce dignissim dolor id auctor accumsan
                                                    vehicula dolor
                                                    vivamus feugiat odio erat sed vehicula lorem tempor quis Donec nec scelerisque magna
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
<div class="modal fade" id="choixConcoursModal" tabindex="-1" aria-labelledby="choixConcoursModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form-final-connexion">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Sélection du concours</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="email" id="hidden-email">
                    <input type="hidden" name="password" id="hidden-password">

                    <div class="mb-3">
                        <label for="concours-select" class="form-label">Choisissez le concours dont vous voulez vous connecter</label>
                        <select class="form-select" name="sessions_id" id="concours-select" required>
                            <option value="">Sélectionnez un concours</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Connexion</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JAVASCRIPT -->
@include("partials.js")


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
        $('#connexion').on('submit', function(e) {

            e.preventDefault();

            let email = $('#email').val();
            let password = $('#password').val();

            if (!email || !password) {
                Swal.fire('Champs requis', 'Veuillez remplir l’email et le mot de passe', 'warning');
                return;
            }

            // Appel AJAX pour récupérer les concours liés à l'utilisateur
            $.ajax({
                url: "{{ route('login.concours') }}", // Créée cette route côté serveur
                method: "POST",
                data: {
                    email: email,
                    password: password,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success && response.concours.length > 0) {
                        // Remplir le select
                        $('#concours-select').empty().append('<option value="">Sélectionnez un concours</option>');
                        response.concours.forEach(c => {
                            $('#concours-select').append(`<option value="${c.idSession}">${c.libelleConcours} session ${c.libelleAnnee}</option>`);
                        });

                        // Injecter email et password
                        $('#hidden-email').val(email);
                        $('#hidden-password').val(password);

                        // Afficher le modal
                        $('#choixConcoursModal').modal('show');
                    } else {
                        Swal.fire('Aucun concours', response.message || 'Aucun concours trouvé pour cette session. Veillez aller à page d\'inscription pour selectionner les concours en cours. Entrer le même mail et le mot de passe', 'info');
                    }
                },
                error: function(response) {
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
        $('#form-final-connexion').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Récupère tous les champs y compris le _token

            $.ajax({
                url: "{{ route('login') }}",
                method: "POST",
                data: formData, // Envoie le formulaire complet
                success: function(response) {

                    Toast.fire({
                        title: response.success || 'Connexion réussie',
                        position: "top-end",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        window.location.href = "{{ route('home') }}";
                    }, 1500);

                },
                error: function(xhr) {
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
