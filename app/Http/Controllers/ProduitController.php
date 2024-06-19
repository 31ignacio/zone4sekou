<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveProduitRequest;
use App\Models\Produit;
use App\Models\ProduitType;
use App\Models\Categories;
use App\Models\Emplacement;
use App\Models\Fournisseur;
use App\Models\grosProduit;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ProduitController extends Controller
{
    //
    public function index()
    {

        //$produits = Produit::all();
        $produits = grosProduit::where('produitType_id', 1)
        ->where(function($query) {
            $query->whereNull('nombre')
                ->orWhere('nombre', '');
        })
        ->get();
        
        return view('Produits.index',compact('produits'));
    }

    // Liste des produits filtré en gros
    public function index2()
    {
        $produitsGros = Produit::all()->filter(function ($produit) {
            return $produit->produitType_id == 2;
        });      

        return view('Produits.index2',compact('produitsGros'));
    }

    public function create()
    {
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $produitTypes = ProduitType::all();

        return view('Produits.create',compact('categories','emplacements','produitTypes'));
    }

    public function store(Produit $produit, grosProduit $grosproduit, Request $request)
    {
       $nombreAleatoire = rand(0, 1000); // Utilisation de rand()
       $codeTroisPremiereLettre= substr($request->libelle, 0, 3);
       //dd($codeTroisPremiereLettre);

       // Formatage du nouveau matricule avec la partie numérique
       $code = $codeTroisPremiereLettre . '_' . $nombreAleatoire;

       //Alo pour casier par type
       //dd($request->emplacement);

        // Utiliser des conditions if pour définir le multiplicateur en fonction du type de produit
        if ($request->emplacement == 1) {
            $multiplicateur = $request->casier * 24;
        } elseif ($request->emplacement == 2) {
            $multiplicateur = $request->casier * 12;
        } elseif ($request->emplacement == 3) {
            $multiplicateur = $request->casier * 20;
        } elseif ($request->emplacement == 4) {
            $multiplicateur = $request->casier * 6;
        } elseif ($request->emplacement == 5) {
            $multiplicateur = $request->casier * 8;
        } elseif ($request->emplacement == 6) {
            $multiplicateur = $request->casier * 6;
        } elseif ($request->emplacement == 7) {
            $multiplicateur = $request->casier * 12;
        } elseif ($request->emplacement == 8 ) {
            $multiplicateur = $request->casier * 24;
        
        } elseif ($request->emplacement == 9) {
            $multiplicateur = $request->casier * 24;
        } else {
            return redirect()->back()->with('error_message', 'Type de produit invalide.');
        }

        //Enregistrer un nouveau client
        try {
            $produit->code = $code;
            $produit->categorie_id = $request->categorie;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle;
            $produit->prix = $request->prix;
            $produit->prixA = $request->prixA;
            $produit->produitType_id=$request->produitType;
            $produit->quantite = $multiplicateur + $request->unite;
            $produit->dateReception = $request->dateReception;

                //dd($produit);
            // deuxieme table
            //25/02/2024
            $grosproduit->code = $code;
            $grosproduit->categorie_id = $request->categorie;
            $grosproduit->emplacement_id = $request->emplacement;
            $grosproduit->libelle = $request->libelle;
            $grosproduit->prix = $request->prix;
            $grosproduit->prixA = $request->prixA;
            $grosproduit->produitType_id=$request->produitType;
            $grosproduit->quantite = $multiplicateur + $request->unite;
            $grosproduit->dateReception = $request->dateReception;
            //dd($grosproduit);

            if($request->categorie=="" || $request->emplacement=="" || $request->produitType==""){

                return back()->with('success_message','Vueillez remplir tout les champs');
            }

             // Vérifier si le libellé existe déjà
            $existingProduit = Produit::where('libelle', $request->libelle)->first();

            if ($existingProduit) {
                // Le libellé existe déjà, retourner un message d'erreur sans vider les champs de formulaire
                return back()->with('warning', 'Le produit existe déjà dans la base')->withInput();
            } 

            //dd($produit);
            $produit->save();
            // $grosproduit->save();

            if($request->produitType == 1){
                $grosproduit->save();//25/02/2024
                return redirect()->route('produit.index')->with('success_message', 'Produit enregistré avec succès');
            }else{
                $grosproduit->quantite = 0;//25/02/2024
                $grosproduit->save();//25/02/2024
                return redirect()->route('produit.index')->with('success_message', 'Produit enregistré avec succès');
            }

        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function detail($produit)
    {

        $produits = Produit::where('id', $produit)->get();
        //dd($produits);

        return view('Produits.detail',compact('produits'));
    }


    public function edit(Produit $produit)
    {
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $produitTypes = ProduitType::all();

        return view('Produits.edit', compact('produit','categories','emplacements','produitTypes'));
    }

    public function update(Produit $produit, Request $request)
    {
        //dd($request->id);
        //Enregistrer un nouveau département
        try {
            $produit->id = $request->id;
            $produit->code = $request->code;
            $produit->categorie_id = $request->categorie;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle;
            $produit->prix = $request->prix;
            $produit->quantite = $request->quantite;
            $produit->prixA = $request->prixA;
            $produit->produitType_id=$request->produitType;
            $produit->dateReception = $request->dateReception;
           // dd($produit);
            $produit->update();
            //dd($produit);

            // Récupérer le grosProduit à partir de l'ID fourni
            $grosProduit = grosProduit::findOrFail($request->id);

            // Mettre à jour les attributs du grosProduit avec les données du formulaire
            $grosProduit->code = $request->code;
            $grosProduit->categorie_id = $request->categorie;
            $grosProduit->emplacement_id = $request->emplacement;
            $grosProduit->libelle = $request->libelle;
            $grosProduit->prix = $request->prix;
            $grosProduit->quantite = $request->quantite;

            $grosProduit->prixA = $request->prixA;
            $grosProduit->produitType_id = $request->produitType;
            $grosProduit->dateReception = $request->dateReception;

            // Sauvegarder les modifications dans la base de données
            $grosProduit->update();

        
            if($produit->produitType_id == 1){

                return redirect()->route('produit.index')->with('success_message', 'Produit modifié avec succès');

            }else{
                return redirect()->route('produit.index2')->with('success_message', 'Produit modifié avec succès');

            }

           // }
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function destroy(Produit $produit)
    {
        //Enregistrer un nouveau département
        try {
            $produit->delete();
            $grosProduit = grosProduit::findOrFail($produit->id);
            $grosProduit->delete();

            return redirect()->back()->with('success_message', 'Produit supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

}
