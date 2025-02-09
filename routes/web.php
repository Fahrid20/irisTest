<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\ReviewController; 



/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//////////////is admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Redirection vers la vue index (si vous préférez utiliser "index" au lieu de "welcome")
Route::get('/', function () {
    return view('index');
});

// Routes de login
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

// Routes d'enregistrement
Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

// Routes de logout
Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

// Autres vues statiques
Route::get('/features', function () {
    return view('features');
})->name('home');

/*Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');*/

//promotions
Route::get('/pricing', [App\Http\Controllers\PromotionController::class, 'pricing'])->name('pricing');

Route::post('/admin/promotions', [AdminController::class, 'storePromotion'])->name('admin.storePromotion');




Route::get('/propos', function () {
    return view('propos');
})->name('propos');

// Routes pour la page de contact
Route::get('/services', function () {
    return view('services');
})->name('services');

Route::post('/services/contact', [ContactController::class, 'send'])->name('contact.send');


/** route panier */
Route::middleware(['auth'])->group(function () {
    // Affichage du panier
    Route::get('/panier', [PanierController::class, 'afficherPanier'])->name('panier.afficher');

    // Ajout au panier
    Route::post('/panier/ajouter/{produit_id}', [PanierController::class, 'ajouterAuPanier'])->name('panier.ajouter');

    // Suppression d'un article du panier
    Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimerDuPanier'])->name('panier.supprimer');
    
    //metre a jours un article dans panier
    Route::patch('/panier/update/{id}', [PanierController::class, 'mettreAJourQuantite'])->name('panier.update');
    
    //copter le nombre d'aticle dans le panier


    Route::get('/panier/count', function () {
        return response()->json(['count' => \Cart::count()]);
    })->name('panier.count');




});

/** produit */
Route::get('/produits', [App\Http\Controllers\ArticleController::class, 'produits'])->name('produits');

Route::get('/produits', [App\Http\Controllers\ArticleController::class, 'categorieProduit'])->name('produits');


/** home */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

/**  gestion des commandes*/
//Route::get('/commande', [CommandeController::class, 'creerCommande'])->name('commande');
Route::get('/commande', [CommandeController::class, 'afficherCommande'])->name('commande.afficher');
Route::post('/commande', [CommandeController::class, 'passerCommande'])->name('commande.passer');
Route::get('/commande/success/{id}', [CommandeController::class, 'commandeSuccess'])->name('commande.success');

Route::get('/commande/details/{id}', [CommandeController::class, 'detailsCommande']);


//////////////////// ADMIN ////////////

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

//////////////// AUTHENTIFICATION ////////////////////
Auth::routes();

/////////////// DASHBOARD ROUTES///////////

// quand l'admin envoie un mail au client
Route::post('/client', [AdminController::class, 'sendEmail'])->name('admin.sendEmail');
Route::post('/admin/send-email', [AdminController::class, 'sendEmail'])->name('admin.sendEmail');
Route::post('/dashboard', [AdminController::class, 'sendEmail'])->name('admin.sendEmail');

//update produit
Route::put('/admin/produits/{id}', [AdminController::class, 'updateProduit'])->name('admin.updateProduit');

//supprimer produit
Route::delete('/admin/produits/{id}', [AdminController::class, 'deleteProduit'])->name('admin.deleteProduit');

//add adim
Route::post('/admin/users', [AdminController::class, 'addAdmin'])->name('admin.addAdmin');

//changer statut d'une commande 
Route::put('/admin/commandes/{id}', [AdminController::class, 'updateCommande'])->name('admin.updateCommande');

Route::get('/commande/details/{id}', [AdminController::class, 'getCommandeDetails']);

//add product route

// Route pour traiter le formulaire (POST)
Route::post('/admin/produits', [AdminController::class, 'ajouterProduit'])->name('admin.ajouterProduit');

/** route profil */ 
Route::middleware(['auth'])->group(function () { 
    Route::get('/profile', [UserInfoController::class, 'show'])->name('profile.show'); 
    Route::post('/profile/update', [UserInfoController::class, 'updatePersonalInfo'])->name('profile.update'); 
    Route::post('/profile/payment/add', [UserInfoController::class, 'addPaymentMethod'])->name('profile.payment.add'); 
});


