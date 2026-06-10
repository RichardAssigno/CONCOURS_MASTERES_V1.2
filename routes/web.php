<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChoixController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\EmploiController;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\InformationsPersonnellesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ResultatsController;
use App\Http\Controllers\TableaudebordController;
use App\Http\Controllers\TransfertDossierController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {return Auth::guard('personne')->check() ? redirect()->route('tableaudebord.index') : redirect()->route('login');})->name('home');


Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/resultats', [ResultatsController::class, 'index'])->name('resultats.index');
Route::post('/login-concours', [\App\Http\Controllers\AuthController::class, 'recupererconcours'])->name("login.concours");
Route::get('/recuperer-concours', [\App\Http\Controllers\ConcoursController::class, 'recupererconcours'])->name("concours.recupererconcours");
Route::get('/login/{idSession}', [\App\Http\Controllers\AuthController::class, 'index'])->name('login.index');
Route::get('/inscription-concours/{idSession}', [\App\Http\Controllers\AuthController::class, 'inscriptionconcours'])->name('inscription.concours');


Route::get("/inscription/{code?}", [\App\Http\Controllers\AuthController::class, 'inscription'])->name('inscription');
Route::post("/inscription", [\App\Http\Controllers\AuthController::class, 'ajoutinscription'])->name('ajoutinscription');

Route::get("/recuperer/photos/{idCandidat}", [\App\Http\Controllers\AuthController::class, 'recupererphoto'])->name('recupererphoto');
Route::get("/recuperer/pdf/{idCandidatDocument}", [\App\Http\Controllers\AuthController::class, 'recupererpdf'])->name('recupererpdf');
Route::get("/connecter/etudiant/{idCandidatSession}", [\App\Http\Controllers\AuthController::class, 'connecteretudiant'])->name('connecteretudiant');



Route::middleware('auth:personne')->group(function () {

    Route::get('tableau-de-bord', [TableaudebordController::class, 'index'])->name('tableaudebord.index');
    Route::get('profil', [TableaudebordController::class, 'profil'])->name('profil.index');
    Route::post('profil/mot-de-passe', [TableaudebordController::class, 'modifierMotDePasse'])->name('profil.password.update');
    Route::get('se-déconnecter', [AuthController::class, 'logout'])->name('logout');

    Route::post('/connecte-a-un-concours', [AuthController::class, 'connexionconcours'])->name('changer.session');

    Route::post('/recuperer-concours', [TableaudebordController::class, 'recupererconcours'])->name('recupererconcours');

    Route::get('/informations-personnelles', [InformationsPersonnellesController::class, 'index'])->name('infos.index');
    Route::post('/ajout-informations-personnelles', [InformationsPersonnellesController::class, 'ajout'])->name('infos.ajout');
    Route::post('/ajout-photos', [InformationsPersonnellesController::class, 'ajoutphoto'])->name('infos.ajoutphoto');
    Route::post('/supprimer-photos', [InformationsPersonnellesController::class, 'supprimerphoto'])->name('infos.supprimerphoto');

    Route::get('/formation', [FormationsController::class, 'index'])->name('formation.index');
    Route::post('/ajouter-formation', [FormationsController::class, 'ajout'])->name('formation.ajout');

    Route::get('/emploi', [EmploiController::class, 'index'])->name('emploi.index');
    Route::post('/ajouter-emploi', [EmploiController::class, 'ajout'])->name('emploi.ajout');

    Route::get('/choix', [ChoixController::class, 'index'])->name('choix.index');
    Route::post('/ajout-choix', [ChoixController::class, 'ajout'])->name('choix.ajout');
    Route::get('/ordre-choix', [ChoixController::class, 'ordrechoix'])->name('choix.ordrechoix');
    Route::post('/ajouter-ordre-choix', [ChoixController::class, 'ajoutordrechoix'])->name('choix.ajoutordrechoix');

    Route::get('/notes', [NotesController::class, 'index'])->name('notes.index');
    Route::post('/ajouter-notes', [NotesController::class, 'ajouter'])->name('notes.ajout');

    Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
    Route::post('/ajouter-document/{id}/{idDossiercandidature}', [DocumentsController::class, 'ajouter'])->name('documents.ajout');
    Route::post('/supprimer-document', [DocumentsController::class, 'supprimerdocument'])->name('documents.supprimer');

    Route::get('/impression-fiche-de-preinscription', [FicheController::class, 'telecharger'])->name('fiche.telecharger');

    Route::get('/telecharger-fiche', function() {
        return response()->download(public_path('assets/pdf/fiche.pdf'), 'Fiche_Candidature.pdf');
    })->name('telecharger.fiche');

});

Route::get('/transfert-dossiers-candidats', [TransfertDossierController::class, 'transfererDossiers'])->name('transfert.dossiers');

// Téléchargement du dossier candidat
Route::get('/documents/candidat_id/{idCandidat}', [DocumentsController::class, "telechargerdossier"])
    ->middleware(Cors::class)
    ->name('document.download');

// Prévoir la route OPTIONS pour CORS
Route::options('/documents/candidat_id/{idCandidat}', function () {
    return response()->noContent()
        ->header('Access-Control-Allow-Origin', 'https://admin.concours.inphb.app')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
});
