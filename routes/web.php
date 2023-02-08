<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\FallbackController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group(['middleware' => 'prevent-back-history'],function(){

    //route auth
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');


    //Section page d'accueil
    Route::get('/', AcceuilController::class)->name('acceuil');

    //route catalogue
    /*Route::get('/catalogue', function () {
        return view('catalogue');
    })->middleware(['auth', 'verified'])->name('catalogue');


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });*/




    /**** ROUTE TEST ET IMPORTE CATALOGUE *** */

    // Permet de tester rapidement la connection*/
    Route::get('/testDB', function () {
        return view('testDB');
    });

    // Importe le catalogue de la SAQ*/
    Route::get('/SAQ', [SAQController::class, 'import'])
        ->name('bouteille.updateSAQ');


    /****************CELLIER *********/


    /* CELLIER */
    Route::get('/cellier', [CellierController::class, 'index'])
        ->name('cellier.index');

    // Ajout d'un cellier
    Route::get('/cellier/nouveau', [CellierController::class, 'nouveau'])
        ->name('cellier.nouveau');
    Route::post('/cellier/creer', [CellierController::class, 'creer'])
    ->name('cellier.creer');


    // Édition d'un cellier
    Route::get('/cellier/edit/{id}', [CellierController::class, 'edit'])
    ->name('cellier.edit');
    Route::post('/cellier/update/{id}', [CellierController::class, 'update'])
    ->name('cellier.update');

    // Suppression d'un cellier
    Route::post('/cellier/supprime/{id}', [CellierController::class, 'supprime'])
    ->name('cellier.supprime');



    Route::pattern('id', '[0-9]+');
    /****************BOUTEILLE *********/

    // Route pour Liste bouteille
    Route::get('/bouteille/{id}', [BouteilleController::class, 'index'])
        ->name('bouteille.liste');

    Route::post('/bouteille/{id}', [BouteilleController::class, 'updateBouteille'])
    ->name('bouteille.updateBouteille');
   

    // Ajout d'une bouteille
    Route::get('/bouteille/nouveau/{id}', [BouteilleController::class, 'nouveau'])
        ->name('bouteille.nouveau');

   Route::post('/bouteille/recherche', [BouteilleController::class, 'recherche'])
    ->name('bouteille.recherche');


    Route::post('/bouteille/creer', [BouteilleController::class, 'creer'])
    ->name('bouteille.creer');

    // Édition d'une bouteille
    Route::get('/bouteille/edit/{idVin}/{idCellier}', [BouteilleController::class, 'edit'])
    ->name('bouteille.edit');
    Route::post('/bouteille/update/{idVin}/{idCellier}', [BouteilleController::class, 'update'])
    ->name('bouteille.update');


    // Suppression d'un bouteille
    Route::post('/bouteille/supprime/{idVin}/{idCellier}', [BouteilleController::class, 'supprime'])
    ->name('bouteille.supprime');


    // Route Fallback pour les routes non existantes Page Erreur 404
    Route::fallback(FallbackController::class);


});//prevent back middleware



require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
