<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['title' => 'Connexion'])
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
                                                    <a href="{{ route('login') }}" class="d-block auth-logo">
                                                        <img src="{{ asset("assets/images/logo-dark.png") }}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-dark me-start">
                                                        <img src="{{ asset("assets/images/logo-light.png") }}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-light me-start">
                                                    </a>
                                                </div>

                                                <div class="auth-content my-auto">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Bienvenue !</h5>
                                                        <p class="text-muted mt-2">Connectez-vous pour continuer votre inscription.</p>
                                                    </div>

                                                    @if (session('echec'))
                                                        <div class="alert alert-danger">
                                                            {{ session('echec') }}
                                                        </div>
                                                    @elseif(session('succes'))
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            {{ session('succes') }}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    @endif

                                                    <form class="mt-4 pt-2" method="POST" id="connexion">
                                                        @csrf
                                                        <div class="form-floating form-floating-custom mb-4">
                                                            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                                                            <label for="email">Email</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="email-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                            <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                                                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                            </button>
                                                            <label for="password">Mot de passe</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="lock-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <div class="form-check font-size-15">
                                                                    <input class="form-check-input" name="remember" type="checkbox" id="remember-check">
                                                                    <label class="form-check-label font-size-13" for="remember-check">
                                                                        Se souvenir de moi
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="{{ route('password.request') }}" class="text-primary font-size-13">
                                                                    Mot de passe oublié ?
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Se connecter</button>
                                                        </div>
                                                        <div class="mb-3">
                                                            <a class="btn btn-outline-primary w-100" href="{{ route('resultats.index') }}">
                                                                <i class="mdi mdi-magnify me-1"></i>
                                                                Consulter les résultats
                                                            </a>
                                                        </div>
                                                    </form>

                                                    <div class="mt-4 pt-3 text-center">
                                                        <p class="text-muted mb-0">Vous n'avez pas de compte ?
                                                            <a href="{{ route("inscription") }}" class="text-primary fw-semibold">S'inscrire</a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> INP-HB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 col-lg-8 col-md-6">
                <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-white"></div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-8">
                            <div class="mt-4">
                                <img src="{{ asset("./assets/images/login-img.png") }}" class="img-fluid" alt="Inscription INP-HB">
                            </div>
                            <div class="p-0 p-sm-4 px-xl-0 py-5">
                                <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>

                                    <div class="carousel-inner w-75 mx-auto">
                                        <div class="carousel-item active">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">L'avenir appartient a ceux qui s'y preparent</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    A l'INP-HB, chaque candidature est une etape vers une formation d'excellence.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">L'excellence au coeur de la formation</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Les concours d'entree selectionnent les talents prets a relever les defis de demain.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center">
                                                <h5 class="font-size-20 mt-4">Votre futur commence ici</h5>
                                                <p class="font-size-15 text-muted mt-3 mb-0">
                                                    Continuez votre inscription et suivez votre dossier depuis votre tableau de bord.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("partials.js")

<script type="text/javascript">
    $(document).ready(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#connexion').on('submit', function (e) {
            e.preventDefault();

            const email = $('#email').val();
            const password = $('#password').val();

            if (!email || !password) {
                Swal.fire('Champs requis', "Veuillez remplir l'email et le mot de passe.", 'warning');
                return;
            }

            if (typeof showLoader === 'function') {
                showLoader('Connexion en cours...');
            }

            $.ajax({
                url: "{{ route('login.concours') }}",
                method: "POST",
                data: {
                    email: email,
                    password: password,
                    remember: $('#remember-check').is(':checked') ? 1 : 0
                },
                success: function (response) {
                    if (typeof hideLoader === 'function') {
                        hideLoader();
                    }

                    Toast.fire({
                        title: 'Connexion reussie'
                    });

                    setTimeout(function () {
                        window.location.href = response.redirect || "{{ route('tableaudebord.index') }}";
                    }, 700);
                },
                error: function (response) {
                    if (typeof hideLoader === 'function') {
                        hideLoader();
                    }

                    const errors = response.responseJSON?.errors;
                    const message = typeof errors === 'object' ? Object.values(errors).flat().join("\n") : (errors || "Erreur inconnue");

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de connexion',
                        text: message
                    });
                }
            });
        });
    });
</script>

</body>
</html>
