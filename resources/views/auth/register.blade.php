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
            <div class="col-xxl-5 col-lg-5 col-md-6">
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
                                                    <form class="mt-4 pt-2" method="post" id="ajoutInscription">

                                                        @csrf

                                                        <div class="mb-3">
                                                            <select class="form-control select2" id="sessions_id" name="sessions_id" placeholder="Saisir pour rechercher">
                                                                <option value="">Choisissez un Concours</option>

                                                                @if(isset($concours))

                                                                    <option value="{{$concours->idSession}}" selected>{{$concours->libelleConcours.' Session '.$concours->libelleAnnee}}</option>

                                                                @elseif(isset($concoursouvert))

                                                                    @foreach($concoursouvert as $concours)

                                                                        <option value="{{$concours->idSession}}">{{$concours->libelleConcours.' Session '.$concours->libelleAnnee}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>
                                                        </div>


                                                        <div class="form-floating form-floating-custom mb-4">
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'Emial" required>
                                                            <div class="invalid-feedback">
                                                                Entrez votre Email
                                                            </div>
                                                            <label for="input-email">Email</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="email-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating form-floating-custom mb-4">
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Entrez le Mot de passe" required>
                                                            <div class="invalid-feedback">
                                                                Entrez le Mot de passe
                                                            </div>
                                                            <label for="input-password">Mot de passe</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="lock-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating form-floating-custom mb-4">
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmez le Mot de passe" required>
                                                            <div class="invalid-feedback">
                                                                Confirmez le Mot de passe
                                                            </div>
                                                            <label for="input-password">Confirmation</label>
                                                            <div class="form-floating-icon">
                                                                <i data-eva="lock-outline"></i>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">S'inscrire</button>
                                                        </div>
                                                    </form>


                                                    <div class="mt-4 pt-3 text-center">
                                                        <p class="text-muted mb-0">Vous avez déjà un compte ? <a href="{{route("login.index")}}" class="text-primary fw-semibold"> Se Connecter </a> </p>
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
            <div class="col-xxl-7 col-lg-7 col-md-6">
                <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-white"></div>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-8">
                            <div class="mt-4">
                                <img src="./assets/images/login-img.png" class="img-fluid" alt="">
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

<!-- JAVASCRIPT -->
@include("partials.js")


<script type="text/javascript">



    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Sélectionnez un concours",
            allowClear: true
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#ajoutInscription').on('submit', function(e) {

            e.preventDefault();

            let formData = $(this).serialize(); // Récupère tous les champs y compris le _token

            $.ajax({
                url: "{{ route('ajoutinscription') }}",
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

                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        let errors = xhr.responseJSON.error;

                        if (Array.isArray(errors)) {
                            // Plusieurs erreurs
                            message = errors.join("<br>");
                        } else if (typeof errors === "object") {
                            // Objet avec plusieurs champs => on récupère chaque valeur
                            message = Object.values(errors).flat().join("<br>");
                        } else {
                            // C'est juste une chaîne simple
                            message = errors;
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de validation',
                        html: message // utiliser html pour garder les <br>
                    });
                }



            });
        });
    })

</script>

</body>
</html>
