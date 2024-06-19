<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\fournisseurInfo;
use App\Models\Produit;
use App\Models\grosProduit;

use App\Models\Stock;
use App\Models\Transfert;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Importez la classe Str


class StockController extends Controller
{
    //
    public function index()
    {

        return view('Stocks.index');
    }

    public function index2()
    {
        $transferts=Transfert::all();

        return view('Stocks.index2',compact('transferts'));
    }

    public function create()
    {
        //$produits = grosProduit::where('produitType_id', 1)->get();
        $produits = grosProduit::where('produitType_id', 1)
        ->where(function($query) {
            $query->whereNull('nombre')
                ->orWhere('nombre', '');
        })
        ->get();

        //dd($produits);
        return view('Stocks.create', compact('produits'));
    }

    public function entrer()
    {
        //$stocks = Stock::all();
        $stocks = Stock::where('produitType_id', 1)->get();

        return view('Stocks.entrer', compact('stocks'));
    }
    public function entrerGros()
    {
        // $stocks = Stock::all();
        $stocks = Stock::where('produitType_id', 2)->get();

        //dd($stocks);

        return view('Stocks.entrerGros', compact('stocks'));
    }

    public function sortie()
    {

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
        ->where('produitType_id', 1)
        ->groupBy('date', 'produit')
        ->orderBy('date', 'asc')
        ->get();
        //dd($factures);


        return view('Stocks.sortie', compact('factures'));
    }

    public function sortieGros()
    {
        // $factures = Facture::all();
        // dd($factures);

        $factures = Facture::select('date', 'produit', DB::raw('SUM(quantite) as total_quantite'))
        ->where('produitType_id', 2)
        ->groupBy('date', 'produit')
        ->orderBy('date', 'asc')
        ->get();


        return view('Stocks.sortieGros', compact('factures'));
    }

    // public function actuel()
    // {
    //     //Affiche tout les gros de la table grosProduit
    //     $produits = grosProduit::where('produitType_id', 1)->get();
    //             // Obtenir la quantité totale cassée par produit
    //     $bouteilles = fournisseurInfo::select('produit', DB::raw('SUM(nombre) as total_quantite'))
    //     ->where('status', "Cassée")
    //     ->groupBy('produit')
    //     ->pluck('total_quantite', 'produit');


        
    //     $date = Carbon::now();

    //     // Remplacer par ceci
    //     $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
    //     ->groupBy('produit')
    //     ->get();

    //     // Creez un tableau associatif pour stocker la quantite de sortie par produit
    //     $quantiteSortieParProduitArray = [];
    //     foreach ($quantiteSortieParProduit as $sortie) {
    //         $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
    //     }

    //     // Calculez le stock actuel pour chaque produit
    //     foreach ($produits as $produit) {

    //         $bouteilles = fournisseurInfo::select('produit', DB::raw('SUM(nombre) as total_quantite'))
    //         ->where('status', "Cassée")
    //         ->groupBy('produit')
    //         ->get();        
    //         //dd($bouteilles);
    

    //         // Vérifier si le produit se termine par "_Pro"
    //         if (isset($quantiteSortieParProduitArray[$produit->libelle])) {

                

    //             $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
    //            // dd($stockActuel);
    //             $produit->stock_actuel = $stockActuel;
    //         } else {
    //             // Si la quantite de sortie n'est pas definie, le stock actuel est egal a la quantite totale
    //             $produit->stock_actuel = $produit->quantite;
    //         }
    //     }

    //     //dd($produits);
    //     return view('Stocks.actuel', compact('produits','date'));
    // }

    public function actuel()
    {
        // Affiche tout les produits de la table grosProduit avec produitType_id = 1
        $produits = grosProduit::where('produitType_id', 1)
        ->where(function($query) {
            $query->whereNull('nombre')
                ->orWhere('nombre', '');
        })
        ->get();

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

        $date = Carbon::now();
        return view('Stocks.actuel', compact('produits', 'date'));
    }


    public function actuelGros()
    {
        // $produits = Produit::all();

        // $produits = Produit::all()->filter(function ($produit) {
        //     return $produit->produitType_id == 2;
        // });
        $produits = grosProduit::where('produitType_id', 1)->get();


        $quantiteSortieParProduit = Facture::select('produit', DB::raw('SUM(quantite) as total_quantite'))
        ->groupBy('produit')
        ->get();


        // Creez un tableau associatif pour stocker la quantite de sortie par produit
        $quantiteSortieParProduitArray = [];
        foreach ($quantiteSortieParProduit as $sortie) {
            $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
        }

        // Calculez le stock actuel pour chaque produit
        foreach ($produits as $produit) {
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;
            } else {
                // Si la quantite de sortie n'est pas definie, le stock actuel est egal a la quantite totale
                $produit->stock_actuel = $produit->quantite;
            }
        }
        //dd($produits);

        return view('Stocks.actuelGros', compact('produits'));
    }

    public function store(Request $request)
    {
        
        //dd($request);
        $produitData = $request->input('produit');
        list($libelle, $emplacement_id) = explode(',', $produitData);
    

        if ($emplacement_id == 1) {
            $multiplicateur = $request->casier * 24;
        } elseif ($emplacement_id == 2) {
            $multiplicateur = $request->casier * 12;
        } elseif ($emplacement_id == 3) {
            $multiplicateur = $request->casier * 20;
        } elseif ($emplacement_id == 4) {
            $multiplicateur = $request->casier * 6;
        } elseif ($emplacement_id == 5) {
            $multiplicateur = $request->casier * 8;
        } elseif ($emplacement_id == 6) {
            $multiplicateur = $request->casier * 6;
        } elseif ($emplacement_id == 7) {
            $multiplicateur = $request->casier * 12;
        } elseif ($emplacement_id == 8 or $request->emplacement == 9) {
            $multiplicateur = $request->casier * 24;
        
        } else {
            return redirect()->back()->with('error_message', 'Type de produit invalide.');
        }


        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        $stock->libelle = $libelle;

        $stock->quantite = $multiplicateur + $request->unite;
        $stock->date = $dateDuJour;
        $stock->produitType_id = 1;
        $stock->emplacement_id = $emplacement_id;

        //dd($stock);
        $stock->save();
        $quantite= $multiplicateur +$request->unite;
        // $produit = Produit::where('libelle', $request->produit)->first();
        $produit = grosProduit::where('libelle', $libelle)
                  ->where('produitType_id', 1)
                  ->first();
                 // dd($produit);

        //dd($produit);
        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return redirect()->route('stock.entrer')->with('success_message', 'Stock entrés avec succès.');
    }

    public function storeGros(Request $request)
    {
        //dd($request);
        $stock = new Stock();

        // Obtenir la date du jour
        $dateDuJour = Carbon::now();

        // Vous pouvez formater la date selon vos besoins
        $dateFormatee = $dateDuJour->format('Y-m-d H:i:s');
        // Récupérer les données JSON envoyées depuis le formulaire
        $stock->libelle = $request->produit;
        //$stock->ref = 001;

        $stock->quantite = $request->quantite;
        $stock->date = $dateDuJour;
        $stock->produitType_id = 2;

        $stock->save();

        // $produit = Produit::where('libelle', $request->produit)->first();

        $produit = Produit::where('libelle', $request->produit)
                  ->where('produitType_id', 2)
                  ->first();
            //dd($produit);

        //dd($produit);
        // Mettez à jour la quantité du produit
        $nouvelleQuantite = $produit->quantite + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);

        return redirect()->route('stock.entrerGros')->with('success_message', 'Stock entrés avec succès.');
    }

    public function transferer(Request $request)
    {
        $produit_id = $request->input('produit_id');
        $produit_libelle = $request->input('produit_libelle');
        $produit_quantite = $request->input('produit_quantite');
        //dd($produit_id,$produit_libelle,$produit_quantite);

        return view('Stocks.transferer', compact('produit_id', 'produit_libelle', 'produit_quantite'));
    }

    public function final(Request $request)
    {
        //dd($request);
        $id = $request->input('produit_id');
        $libelle = $request->input('produit_libelle');
        $quantite = $request->input('produit_quantite');
        $transferer = $request->input('transferer');
        $bar = $request->input('bar');

        $user = Auth::user();
        $idUser = $user->id;

        $dateAujourdhui = Carbon::today();
        //dd($dateAujourdhui);
        //control sur la quantité
        if ($quantite < $transferer) {
            return back()->with('success_message', "La quantité actuelle du produit est inférieure à la quantité que vous souhaitez transférer.");
        } else {

            $produits = grosProduit::all()->filter(function ($produit) {
                return $produit->produitType_id == 1;
            });

            //recupere le produit en detail qui a ce libelle
            $produitss = grosProduit::all()->filter(function ($produit) use ($libelle) {
                return $produit->produitType_id == 1 && $produit->libelle == $libelle;
            });
            

            //recupere le premier produit
            $produit = $produitss->first(); // Supposons que vous souhaitez travailler avec le premier produit de la collection
            // $produit1 = $produits1->first(); // Supposons que vous souhaitez travailler avec le premier produit de la collection

            // Récupérez la quantité du produit et ajoutez la quantité spécifiée dans $transferer
            $quantiteTotale = $produit->quantite - $transferer;

            //dd($quantiteTotale);
            // Faites ce que vous souhaitez avec $quantiteTotale, par exemple, mettez à jour la quantité dans la base de données
            $produit->update(['quantite' => $quantiteTotale]);

            
            // A partir d'ici le code vient de stock actuel (c'est pas propre il faut revoir avec le temps 09/03/24 by ignacio)

            $produits =Produit::where('produitType_id', 1)->get();
    
            $produitType_id = 1; // Remplacez cette valeur par celle que vous souhaitez
    
            $quantiteSortieParProduit = Facture::select('produit', 'produitType_id', DB::raw('SUM(quantite) as total_quantite'))
            ->where('produitType_id', $produitType_id)
            ->groupBy('produit', 'produitType_id')
            ->get();
        
    
            // Créez un tableau associatif pour stocker la quantité de sortie par produit
            $quantiteSortieParProduitArray = [];
            foreach ($quantiteSortieParProduit as $sortie) {
                $quantiteSortieParProduitArray[$sortie->produit] = $sortie->total_quantite;
            }
    
            // Calculez le stock actuel pour chaque produit
            //27/02/2024 j'ai ramener la quantite au niveau de $produit->stock_actuel (il suffit de faire une compaaison avec 'actuel' en haut pour comprendre)
            foreach ($produits as $produit) {
                if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                    $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                    $produit->stock_actuel = $produit->quantite;$produit->produitType_id=2;
                } else {
                    // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                    $produit->stock_actuel = $produit->quantite;
                }
            }

        }

        $transfert = new Transfert();

        $transfert->produit = $request->produit_libelle;
        $transfert->quanite = $request->transferer;
        $transfert->bar = $request->bar;
        $transfert->date = $dateAujourdhui;
        $transfert->user_id = $idUser;

            //dd($transfert);
        $transfert->save();

                
                //dd($produits);

                return redirect()->route('stock.actuelGros')->with(['produits' => $produits, 'success_message' => 'Produit transféré avec succès']);
        
            //}
        
    }

    public function update(Request $request, $id)
    {

        // Valider les données du formulaire
        $request->validate([
            'libelle' => 'required',
            'quantite' => 'required|numeric',
        ]);
        //dd($request);
        // Mettre à jour le stock en fonction de l'ID avec les données reçues du formulaire
        $stock = Stock::find($id);
        $ancienDate= $stock->date;
        $ancienStock= $stock->quantite;
        if($request->date == null){
            $stock->date = $ancienDate;
        }else{
            $stock->date = $request->date;
        }
        $stock->libelle = $request->libelle;
        $stock->quantite = $request->quantite;
        $stock->save();

        $produit = Produit::where('libelle', $request->libelle)->first();
    
        $nouvelleQuantite = ($produit->quantite - $ancienStock ) + $request->quantite;
        $produit->update(['quantite' => $nouvelleQuantite]);
        
        //dd($produit);
        // Mettez à jour la quantité du produit
       
        return redirect()->route('stock.entrer')->with('success_message', 'Stock modifié avec succès.');

    }

}
