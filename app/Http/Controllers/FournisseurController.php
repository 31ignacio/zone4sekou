<?php

namespace App\Http\Controllers;

use App\Models\Emplacement;
use App\Models\fournisseurInfo;
use App\Models\grosProduit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
{
    //

    public function index()
    {
        $emplacements = Emplacement::all();
        //$produits = grosProduit::all();
        $produits = grosProduit::where('produitType_id', 1)
        ->where(function($query) {
            $query->whereNull('nombre')
                ->orWhere('nombre', '');
        })
        ->get();
       
        // ENTRE
        $stocks = Stock::whereIn('emplacement_id', [1, 2, 3])
        ->selectRaw('DATE(date) as date, emplacement_id, SUM(quantite) as total_quantite')
        ->groupBy(DB::raw('DATE(date)'), 'emplacement_id')
        ->orderBy('date','desc')
        ->get();

        // Organiser les données par date dans un tableau
        $stocksByDate = [];
        foreach ($stocks as $stock) {
        $stocksByDate[$stock->date][$stock->emplacement_id] = $stock->total_quantite;
        }


        //dd($stocks);
        $user = Auth::user();
        $user_id=$user->id;
        $fournisseur=$user_id;

        $fournisseurInfo = fournisseurInfo::orderBy('date', 'desc')->get();
        
    
        // SORTI 
        $reglements = FournisseurInfo::where('status', 'Sortie')
        ->whereIn('emplacement_id', [1, 2, 3])
        ->selectRaw('DATE(date) as date, emplacement_id, SUM(nombre) as total_quantite')
        ->groupBy(DB::raw('DATE(date)'), 'emplacement_id')
        ->orderBy('date','desc')
        ->get();

        // Organiser les données par date dans un tableau
        $reglementsByDate = [];
        foreach ($reglements as $reglement) {
        $reglementsByDate[$reglement->date][$reglement->emplacement_id] = $reglement->total_quantite;
        }


        // BOUTEILLES CASSEES 
        $casses = FournisseurInfo::where('status', 'Cassée')
        ->where('emplacement_id', 5)
        ->with('user')  // Inclure les informations de l'utilisateur
        ->selectRaw('DATE(date) as date, produit, nombre, user_id')
        ->orderBy('date', 'desc')
        ->get();

        // Organiser les données par date dans un tableau
        $cassesByDate = [];
        foreach ($casses as $reglement) {
            $cassesByDate[$reglement->date][] = [
                'produit' => $reglement->produit,
                'nombre' => $reglement->nombre,
                'user' => $reglement->user->name, // Assurez-vous que le modèle User a un attribut 'name'
            ];
        }


        // BOUTEILLES COULEE 
        $couler = FournisseurInfo::where('status', 'coulee')
        ->where('emplacement_id', 6)
        ->with('user')  // Inclure les informations de l'utilisateur
        ->selectRaw('DATE(date) as date, produit, nombre, user_id')
        ->orderBy('date', 'desc')
        ->get();

        // Organiser les données par date dans un tableau
        $coulerByDate = [];
        foreach ($couler as $reglement) {
            $coulerByDate[$reglement->date][] = [
                'produit' => $reglement->produit,
                'nombre' => $reglement->nombre,
                'user' => $reglement->user->name, // Assurez-vous que le modèle User a un attribut 'name'
            ];
        }

        //dd($cassesByDate);

        
        return view('Fournisseurs.detail', compact('stocksByDate','reglementsByDate','coulerByDate','cassesByDate','produits','fournisseur','fournisseurInfo','reglements','emplacements'));
    
    }

    public function storeReglement(Request $request)
    {
        $user = Auth::user();
        $user_id=$user->id;
        
        $fournisseur= new fournisseurInfo();
        $fournisseur->nombre = $request->nombre;
        $fournisseur->date = $request->date;
        $fournisseur->status = $request->status;
        $fournisseur->emplacement_id = $request->type;
        $fournisseur->user_id = $user_id;
        $fournisseur->save();
        
        return back()->with('success_message', 'Sortie de casier enregistrée avec succès');
    }

    public function storeCasser(Request $request)
    {

        $user = Auth::user();
        $user_id=$user->id;
        //dd($request);
        $fournisseurx= new fournisseurInfo();

        $fournisseurx->nombre = $request->nombre;
        $fournisseurx->date = $request->date;
        $fournisseurx->emplacement_id = $request->type;
        $fournisseurx->status = $request->status;
        $fournisseurx->produit = $request->produit;
        $fournisseurx->user_id = $user_id;
        //dd($fournisseurx);

        $fournisseurx->save();        
        return back()->with('success_message', 'Bouteille enregistrée avec succès');
    }

    public function storeCouler(Request $request)
    {

        $user = Auth::user();
        $user_id=$user->id;
        //dd($request);
        $fournisseurx= new fournisseurInfo();

        $fournisseurx->nombre = $request->nombre;
        $fournisseurx->date = $request->date;
        $fournisseurx->emplacement_id = $request->type;
        $fournisseurx->status = $request->status;
        $fournisseurx->produit = $request->produit;
        $fournisseurx->user_id = $user_id;
        //dd($fournisseurx);

        $fournisseurx->save();        
        return back()->with('success_message', 'Bouteille coulée enregistrée avec succès');
    }

}
