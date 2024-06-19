<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\grosProduit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VenduController extends Controller
{
    //

    public function index(Request $request){

        $dateDebut= $request->dateDebut;
        $dateFin= $request->dateFin;

        if($dateDebut > $dateFin){
            return back()->with('danger_message','La date début ne peut pas être superieur à la date fin');
        }

        // dd($dateFin,$dateDebut);
        // Affiche tout les produits de la table grosProduit avec produitType_id = 1
        $produits = grosProduit::where('produitType_id', 1)
        ->where(function($query) {
            $query->whereNull('nombre')
                ->orWhere('nombre', '');
        })
        ->get();


        $query = Facture::query();

        // Ajouter les conditions de date si elles sont fournies
        if ($request->filled('dateDebut')) {
            $query->where('date', '>=', $request->dateDebut);
        }

        if ($request->filled('dateFin')) {
            $query->where('date', '<=', $request->dateFin);
        }

        // Ajouter la condition de produit si elle est fournie
        if ($request->filled('produit')) {
            $query->where('produit', $request->produit);
        }

        // Grouper par produit et calculer la somme des quantités
        $factures = $query->select('produit', 'date', DB::raw('SUM(quantite) as total_quantite'))
            ->groupBy('produit')
            ->get();

        return view('Vendus.index',compact('factures','produits'));

    }
}
