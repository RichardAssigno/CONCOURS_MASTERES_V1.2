$(document).ready(function () {

    // Filtre pour la zone hors modal (déjà existante)
    $('#concours-filter').on('input', function () {
        let filter = $(this).val().toLowerCase().trim();

        $('.card-filter').each(function () {
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(filter));
        });
    });

    // Filtre pour le modal — fonctionne même si les cards sont injectées APRES via AJAX
    $('#concours-filter1').on('input', function () {

        let filter = $(this).val().toLowerCase().trim();

        // IMPORTANT : limiter au contenu du modal
        $('#listeConcours1 .card-filter1').each(function () {

            let text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(filter));

        });
    });

});
