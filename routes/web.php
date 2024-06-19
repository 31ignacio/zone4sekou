<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EmplacementController;
use App\Http\Controllers\FactureEnAttenteController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\InventairesController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProduitPromotionController;
use App\Http\Controllers\ServanteController;
use App\Http\Controllers\VenduController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



    Route::get('/', [AuthController::class, 'login'])->name('login');

    Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');
    Route::post('/change-password', [AccueilController::class, 'update'])->name('password.update');

    Route::prefix('admin')->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/admin/password', [AccueilController::class, 'password'])->name('admin.password');

        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/admin2', [AdminController::class, 'index2'])->name('admin2');
        Route::get('/information', [AdminController::class, 'indexInfo'])->name('information');
        Route::get('/detail{admin}}', [AdminController::class, 'detail'])->name('admin.detail');


        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/create', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{admin}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{admin}', [AdminController::class, 'update'])->name('admin.update');

        Route::get('/createInfo', [AdminController::class, 'createInfo'])->name('information.create');
        Route::post('/createInfo', [AdminController::class, 'storeInfo'])->name('information.store');
        Route::get('/editInfo/{information}', [AdminController::class, 'editInfo'])->name('information.edit');
        Route::post('/updateInfo/{information}', [AdminController::class, 'updateInfo'])->name('information.update');

            
        Route::get('/{admin}', [AdminController::class, 'delete'])->name('admin.delete');
        Route::post('/users/disable', [AdminController::class, 'disable'])->name('admin.disable');
        Route::post('/users/active', [AdminController::class, 'active'])->name('admin.active');

        // Route::post('/users/{id}/disable', [UserController::class, 'disable'])->name('users.disable');

    });

    Route::middleware(['auth'])->group(function(){

        Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil.index');

        Route::prefix('client')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('client.index');
            Route::get('/detteClient', [ClientController::class, 'dette'])->name('client.dette');
        
            Route::get('/detail{client}}', [ClientController::class, 'detail'])->name('client.detail');
            Route::post('/remboursement}}', [ClientController::class, 'rembourssement'])->name('client.rembourssement');
            Route::get('/create', [ClientController::class, 'create'])->name('client.create');
            Route::post('/create', [ClientController::class, 'store'])->name('client.store');
            Route::get('/edit/{client}', [ClientController::class, 'edit'])->name('client.edit');
            Route::put('/update/{client}', [ClientController::class, 'update'])->name('client.update');
            Route::post('/detailRemb', [ClientController::class, 'detailRembourssement'])->name('detailRembourssement');
            Route::post('/detailRembs', [ClientController::class, 'detailRembourssements'])->name('detailRembourssements');

            Route::get('/pdf/{remboursement}/{code}/{clientId}', [ClientController::class, "pdf"])->name('rembourssement.pdf');
        
            Route::get('Client/{client}', [ClientController::class, 'delete'])->name('client.delete');
        });

        Route::prefix('servante')->group(function () {
            Route::get('/', [ServanteController::class, 'index'])->name('servante.index');
            Route::get('/detail{servante}}', [ServanteController::class, 'detail'])->name('servante.detail');
            Route::get('/create', [ServanteController::class, 'create'])->name('servante.create');
            Route::post('/create', [ServanteController::class, 'store'])->name('servante.store');
            Route::put('/servantes/{servante}', [ServanteController::class, 'update'])->name('servante.update');
            Route::delete('/servantes/{servante}', [ServanteController::class, 'destroy'])->name('servante.destroy');
            Route::get('servante/{servante}', [ServanteController::class, 'delete'])->name('servante.delete');
        });

        Route::prefix('Depense')->group(function () {
            Route::get('/', [DepenseController::class, 'index'])->name('depense.index');
            Route::get('/detail{depense}}', [DepenseController::class, 'detail'])->name('depense.detail');
            Route::get('/create', [DepenseController::class, 'create'])->name('depense.create');
            Route::post('/create', [DepenseController::class, 'store'])->name('depense.store');
            Route::put('/depenses/{depense}', [DepenseController::class, 'update'])->name('depense.update');
            Route::delete('/depenses/{depense}', [DepenseController::class, 'destroy'])->name('depense.destroy');
            Route::get('depense/{depense}', [DepenseController::class, 'delete'])->name('depense.delete');
        });
        
        Route::prefix('fournisseur')->group(function () {
            Route::get('/', [FournisseurController::class, 'index'])->name('fournisseur.index');
            Route::get('/create', [FournisseurController::class, 'create'])->name('fournisseur.create');
            Route::post('/create', [FournisseurController::class, 'store'])->name('fournisseur.store');
            Route::get('/edit/{fournisseur}', [FournisseurController::class, 'edit'])->name('fournisseur.edit');
            Route::put('/update/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseur.update');    
            Route::get('/fournisseur/{fournisseur}', [FournisseurController::class, 'delete'])->name('fournisseur.delete');
            Route::get('/detail{fournisseur}}', [FournisseurController::class, 'detail'])->name('fournisseur.detail');
            Route::post('/create/achat/', [FournisseurController::class, 'storeAchat'])->name('fournisseur.storeAchat');
            Route::post('/create/reglement/', [FournisseurController::class, 'storeReglement'])->name('fournisseur.storeReglement');
            Route::post('/create/casser/', [FournisseurController::class, 'storeCasser'])->name('fournisseur.storeCasser');
            Route::post('/create/couler/', [FournisseurController::class, 'storeCouler'])->name('fournisseur.storeCouler');


        });
        
        Route::prefix('etat')->group(function () {
            Route::get('/', [EtatController::class, 'search'])->name('etat.index');
            Route::get('/facturePeriode', [EtatController::class, 'periodeFacture'])->name('periode.index');

        });
        
        Route::prefix('produit')->group(function () {
            Route::get('/', [ProduitController::class, 'index'])->name('produit.index');
            Route::get('/produitsGros', [ProduitController::class, 'index2'])->name('produit.index2');
            Route::get('/create', [ProduitController::class, 'create'])->name('produit.create');
            Route::post('/create', [ProduitController::class, 'store'])->name('produit.store');
            Route::get('/detail/{produit}', [ProduitController::class, 'detail'])->name('produit.detail');
            Route::get('/edit/{produit}', [ProduitController::class, 'edit'])->name('produit.edit');
            Route::post('/update/{produit}', [ProduitController::class, 'update'])->name('produit.update');
            
            Route::get('produit/{produit}', [ProduitController::class, 'delete'])->name('produit.delete');
            Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produit.destroy');
        });

        Route::prefix('promotion')->group(function () {
            Route::get('/', [ProduitPromotionController::class, 'index'])->name('promotion.index');
            Route::get('/create', [ProduitPromotionController::class, 'create'])->name('promotion.create');
            Route::post('/create', [ProduitPromotionController::class, 'store'])->name('promotion.store');
            Route::get('/detail/{produit}', [ProduitPromotionController::class, 'detail'])->name('promotion.detail');
            Route::get('/edit/{produit}', [ProduitPromotionController::class, 'edit'])->name('promotion.edit');
            Route::post('/update/{produit}', [ProduitPromotionController::class, 'update'])->name('promotion.update');
            Route::get('produit/{produit}', [ProduitPromotionController::class, 'delete'])->name('promotion.delete');
            Route::delete('/produits/{produit}', [ProduitPromotionController::class, 'destroy'])->name('promotion.destroy');
        });

        Route::prefix('categorie')->group(function () {
            Route::get('/', [CategorieController::class, 'index'])->name('categorie.index');
            Route::post('/create', [CategorieController::class, 'store'])->name('categorie.store');
            Route::put('/categories/{categorie}', [CategorieController::class, 'update'])->name('categorie.update');
            Route::delete('/categorie/{categorie}', [CategorieController::class, 'destroy'])->name('categorie.destroy');
            Route::get('categorie/{categorie}', [CategorieController::class, 'delete'])->name('categorie.delete');

        });
        
        Route::prefix('emplacement')->group(function () {
            Route::get('/', [EmplacementController::class, 'index'])->name('emplacement.index');
            Route::post('/create', [EmplacementController::class, 'store'])->name('emplacement.store');
            Route::get('/{emplacement}', [EmplacementController::class, 'delete'])->name('emplacement.delete');
            Route::put('/emplacements/{emplacement}', [EmplacementController::class, 'update'])->name('emplacement.update');
            Route::delete('/emplacement/{emplacement}', [EmplacementController::class, 'destroy'])->name('emplacement.destroy');
        });

        Route::prefix('facture')->group(function () {
            Route::get('/', [FactureController::class, 'index'])->name('facture.index');
            // Route::middleware(['chriss'])->group(function(){

                Route::get('/create', [FactureController::class, 'create'])->name('facture.create');
                Route::post('/create', [FactureController::class, 'store'])->name('facture.store');
            // });
            Route::get('/edit/{facture}', [FactureController::class, 'edit'])->name('facture.edit');
            Route::put('/update/{facture}', [FactureController::class, 'update'])->name('facture.update');
            Route::get('/details/{code}/{date}',[FactureController::class, 'details'])->name('facture.details');
            Route::get('/annuler',[FactureController::class, 'annuler'])->name('facture.annuler');
            Route::get('/pointJournée', [FactureController::class, 'point'])->name('facture.point');
            Route::get('/reglement',[FactureController::class, 'reglement'])->name('facture.reglement');

            Route::get('/pdf/{facture}', [FactureController::class, "pdf"])->name('facture.pdf');
        
            Route::get('/{facture}', [FactureController::class, 'delete'])->name('facture.delete');
        });


        Route::prefix('factureAttente')->group(function () {
            Route::get('/', [FactureEnAttenteController::class, 'index'])->name('factureAttente.index');
            Route::get('/create', [FactureEnAttenteController::class, 'create'])->name('factureAttente.create');
            Route::post('/create', [FactureEnAttenteController::class, 'store'])->name('factureAttente.store');
            Route::get('/details/{code}/{date}',[FactureEnAttenteController::class, 'details'])->name('factureAttente.details');
            Route::get('/facture/{code}/{servante}',[FactureEnAttenteController::class, 'facture'])->name('factureAttente.facture');

            Route::get('/annuler',[FactureEnAttenteController::class, 'valider'])->name('factureAttente.valider');
            Route::get('/details/{code}/{date}',[FactureEnAttenteController::class, 'details'])->name('factureAttente.details');
            Route::get('/annuler/oui',[FactureEnAttenteController::class, 'annuler'])->name('factureAttente.annuler');


        });
        
        Route::prefix('stock')->group(function () {
            Route::get('/index', [StockController::class, 'index'])->name('stock.index');
            Route::get('/index2', [StockController::class, 'index2'])->name('stock.index2');

            Route::get('/entrer', [StockController::class, 'entrer'])->name('stock.entrer');
            Route::get('/entrerGros', [StockController::class, 'entrerGros'])->name('stock.entrerGros');

            Route::get('/sortie', [StockController::class, 'sortie'])->name('stock.sortie');
            Route::get('/sortieGros', [StockController::class, 'sortieGros'])->name('stock.sortieGros');

            Route::get('stock/actuel', [StockController::class, 'actuel'])->name('stock.actuel');
            Route::get('/actuelGros', [StockController::class, 'actuelGros'])->name('stock.actuelGros');
            Route::get('/transferer', [StockController::class, 'transferer'])->name('stock.tranferer');

            Route::get('/create', [StockController::class, 'create'])->name('stock.create');
            Route::get('/createGros', [StockController::class, 'createGros'])->name('stock.createGros');

            Route::post('/create', [StockController::class, 'store'])->name('stock.store');
            Route::post('/createGros', [StockController::class, 'storeGros'])->name('stock.storeGros');

            Route::post('stock/final', [StockController::class, 'final'])->name('stock.final');

            Route::post('/stock/{id}', [StockController::class, 'update'])->name('stock.update');
        });

        Route::prefix('point')->group(function () {
            Route::get('/index', [PointController::class, 'index'])->name('point.index');

        });


        Route::prefix('vendu')->group(function () {
            Route::get('/', [VenduController::class, 'index'])->name('vendu.index');

        });

        Route::prefix('Inventaires')->group(function () {
            Route::get('/', [InventairesController::class, 'index'])->name('inventaires.index');
        });

    });

