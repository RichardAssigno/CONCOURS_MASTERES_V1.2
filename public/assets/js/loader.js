function showLoader(message = "Chargement en cours...") {
    // Supprime un ancien overlay s'il existe
    $('#globalLoaderOverlay').remove();

    // Crée dynamiquement l'overlay
    $('body').append(`
        <div id="globalLoaderOverlay" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            backdrop-filter: blur(2px);
        ">
            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;"></div>
            <h5 style="margin-top: 15px; color: white;">${message}</h5>
        </div>
    `);
}

function hideLoader() {
    $('#globalLoaderOverlay').fadeOut(30, function () {
        $(this).remove();
    });
}
