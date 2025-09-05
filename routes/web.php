<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChoixController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\EmploiController;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\InformationsPersonnellesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\TableaudebordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {return Auth::guard('personne')->check() ? redirect()->route('tableaudebord.index') : redirect()->route('login');})->name('home');


Route::get('login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login.index');
Route::post('/login-concours', [\App\Http\Controllers\AuthController::class, 'recupererconcours'])->name("login.concours");
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


Route::get("/inscription/{code?}", [\App\Http\Controllers\AuthController::class, 'inscription'])->name('inscription');
Route::post("/inscription", [\App\Http\Controllers\AuthController::class, 'ajoutinscription'])->name('ajoutinscription');


Route::middleware('auth:personne')->group(function () {

    Route::get('tableau-de-bord', [TableaudebordController::class, 'index'])->name('tableaudebord.index');
    Route::get('se-déconnecter', [AuthController::class, 'logout'])->name('logout');

    Route::post('/connecte-a-un-concours', [AuthController::class, 'connexionconcours'])->name('changer.session');

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


});
