<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\fournisseurInfo;
use App\Models\grosProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Importez la classe Str
use Carbon\Carbon;


class InventairesController extends Controller
{
    //

    public function index()
    {
        $today = Carbon::today()->toDateString(); // Format YYYY-MM-DD

        // Affiche tout les produits de la table grosProduit avec produitType_id = 1
    $produits = grosProduit::where('produitType_id', 1)->get();

    // Obtenir la quantité totale cassée par produit
    $bouteilles = fournisseurInfo::select('produit', DB::raw('SUM(nombre) as total_quantite'))
        ->where('status', "Cassée")
        ->groupBy('produit')
        ->pluck('total_quantite', 'produit');

    // Obtenir la quantité totale sortie par produit
    $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
        ->groupBy('produit')
        ->get();

    // Créez un tableau associatif pour stocker la quantité de sortie par produit
    $quantiteSortieParProduitArray = [];
    foreach ($quantiteSortieParProduit as $sortie) {
        $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
    }

    // Calculez le stock actuel pour chaque produit
    foreach ($produits as $produit) {
        // Obtenir la quantité cassée pour ce produit, s'il n'y en a pas, utiliser 0
        $quantiteCassee = isset($bouteilles[$produit->libelle]) ? $bouteilles[$produit->libelle] : 0;
        // Obtenir la quantité sortie pour ce produit, s'il n'y en a pas, utiliser 0
        $quantiteSortie = isset($quantiteSortieParProduitArray[$produit->libelle]) ? $quantiteSortieParProduitArray[$produit->libelle] : 0;

        // Calculer le stock actuel
        $stockActuel = $produit->quantite - $quantiteSortie - $quantiteCassee;
        $produit->stock_actuel = $stockActuel;
    }
        //dd($produits);
        return view('Inventaires.index', compact('produits','today'));
    }
}
