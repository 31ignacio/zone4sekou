<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Emplacement;
use App\Models\Facture;
use App\Models\FactureEnAtente;
use App\Models\grosProduit;
use App\Models\ProduitType;
use App\Models\Servante;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FactureEnAttenteController extends Controller
{
    //
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        // Vous pouvez maintenant accéder aux propriétés de l'utilisateur
        $nom = $user->name;
        $role=$user->role_id;

        // Recuperer la somme du montantFinal pour l'utilisateur connecte et le rôle donne
        $sommeMontant = FactureEnAtente::where('user_id', $user->id)
            // ->where('role_id', $role)
            ->whereDate('date', now()) // Filtre pour la date du jour
            ->sum('montantFinal');

        $factures = FactureEnAtente::all();
       // dd($factures);

        $client = Client::all();

        // Creez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures
        ->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->emplacement;
        })
        ->sortByDesc('created_at');


        // Paginer les resultats obtenus
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $codesFacturesUniques->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer une instance de LengthAwarePaginator
        $codesFacturesUniques = new LengthAwarePaginator(
            $currentPageItems,
            $codesFacturesUniques->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
            

        return view('FactureEnAttente.index', compact('factures', 'codesFacturesUniques','nom','role'));
    }

    public function valider(Request $request)
    {
        $code = $request->factureCode;
        $montant = $request->montantPerçu;

        //dd($montant);

        if($montant== "" or $montant=null){
            return back()->with('danger_message','Montant perçu ne doit pas être vide');
        }

    
        // Récupérer toutes les factures avec le code donné dans la table FactureEnAtente
        $facturesAttente = FactureEnAtente::where('code', $code)->get();
        //dd($facturesAttente);
    
        if ($facturesAttente->isNotEmpty()) {
            foreach ($facturesAttente as $factureAttente) {
                // Copier les informations de la facture dans la table Facture
                $facture = new Facture();
                
                // Ajouter d'autres champs nécessaires ici
                $facture->client = $factureAttente->client;
                $facture->client_nom = $factureAttente->client_nom;
                $facture->date = $factureAttente->date;
                $facture->produitType_id = $factureAttente->produitType_id;
                $facture->servante_id = $factureAttente->servante_id;
                $facture->totalHT = $factureAttente->totalHT;
                $facture->totalTVA = $factureAttente->totalTVA;
                $facture->totalTTC = $factureAttente->totalTTC;
                $facture->montantPaye = $montant;
                $facture->montantRendu = ($montant - $factureAttente->totalTTC);
                $facture->quantite = $factureAttente->quantite;
                $facture->produit = $factureAttente->produit; // Assurez-vous d'utiliser la bonne clé ici
                $facture->prix = $factureAttente->prix;
                $facture->total = $factureAttente->total;
                $facture->code = $factureAttente->code;
                $facture->user_id = $factureAttente->user_id;
                $facture->reduction = $factureAttente->reduction;
                $facture->montantFinal = $factureAttente->totalTTC;
    
                $facture->save();
            }
    
            // Supprimer toutes les factures avec ce code dans la table FactureEnAtente
            FactureEnAtente::where('code', $code)->delete();
    
            return redirect()->back()->with('success_message', 'Factures validées avec succès.');
        } else {
            return response()->json(['error_message' => 'Aucune facture trouvée avec ce code.'], 404);
        }
    }

    

    public function details($code, $date)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue

        $factures = FactureEnAtente::all();
        //dd($factures);
        return view('FactureEnAttente.details', compact('date', 'code', 'factures'));
    }

    public function facture($code,$servante){
        //dd($code,$servante);

        $emplacements = Emplacement::all();
        $clients = Client::all();
        $servantes = Servante::where('id', $servante)->get();
        $produits = grosProduit::all();
        $produitTypes = ProduitType::all();

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
            if (isset($quantiteSortieParProduitArray[$produit->libelle])) {
                $stockActuel = $produit->quantite - $quantiteSortieParProduitArray[$produit->libelle];
                $produit->stock_actuel = $stockActuel;
            } else {
                // Si la quantité de sortie n'est pas définie, le stock actuel est égal à la quantité totale
                $produit->stock_actuel = $produit->quantite;
            }
        }
       // dd($produits);
        return view('Factures.create', compact('clients','servantes', 'emplacements','produits','produitTypes','code'));
    }

    public function annuler(Request $request)
    {
        
       $code=$request->factureCode;
      //dd($code);
      FactureEnAtente::where('code', $code)->delete();
      
        //dd($fa);
        return back()->with('success_message', 'La facture a été annulée avec succès.');
    }
}
