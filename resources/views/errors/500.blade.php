<!doctype html>
<html lang="fr">

<head>

    @include('partials.meta',['title'=>'Tableau de Bord'])

    @include("partials.css")

</head>
<body>
    <div class="my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 pt-5">
                        <h1 class="error-title mt-5"><span>500!</span></h1>
                        <h4 class="text-uppercase mt-5">Erreur Serveur</h4>
                        <p class="font-size-15 mx-auto text-muted w-50 mt-4">Veillez cliquez sur le lien ci-dessous pour retourner sur le site.</p>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="{{route("tableaudebord.index")}}">Retour</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>
</body>
</html>
