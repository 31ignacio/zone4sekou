<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Emplacement;
use App\Models\grosProduit;
use App\Models\Produit;
use App\Models\ProduitType;
use Exception;
use Illuminate\Http\Request;

class ProduitPromotionController extends Controller
{
    //
    public function index()
    {

        $produits = Produit::where('promotion', 'oui')->get();
        return view('ProduitPromotions.index',compact('produits'));
    }

    public function create()
    {
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $produitTypes = ProduitType::all();

        return view('ProduitPromotions.create',compact('categories','emplacements','produitTypes'));
    }

    public function store(Produit $produit, grosProduit $grosproduit, Request $request)
    {
       $nombreAleatoire = rand(0, 1000); // Utilisation de rand()
       $codeTroisPremiereLettre= substr($request->libelle, 0, 3);
       //dd($codeTroisPremiereLettre);

       // Formatage du nouveau matricule avec la partie numérique
       $code = $codeTroisPremiereLettre . '_' . $nombreAleatoire;

       //Alo pour casier par type

        
        $terminaison= "_Pro";

        //Enregistrer un nouveau client
        try {
            $produit->code = $code;
            $produit->categorie_id = $request->categorie;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle . '_' . $terminaison;
            $produit->prix = $request->prix;
            $produit->nombre = $request->nombre;
            $produit->promotion= "oui";
            $produit->produitType_id=1;
            $produit->quantite = 10;
            $produit->dateReception = "12/12/2050";
            // deuxieme table
            //25/02/2024
            $grosproduit->code = $code;
            $grosproduit->categorie_id = $request->categorie;
            $grosproduit->emplacement_id = $request->emplacement;
            $grosproduit->libelle = $request->libelle . '_' . $terminaison;
            $grosproduit->prix = $request->prix;
            $grosproduit->nombre = $request->nombre;
            $grosproduit->promotion= "oui";

            $grosproduit->produitType_id=1;
            $grosproduit->quantite = 10;
            $grosproduit->dateReception = "12/12/2050";

            if($request->categorie=="" || $request->emplacement==""){

                return back()->with('warning','Vueillez remplir tout les champs')->withInput();
            }

            $produit->save();
            $grosproduit->save();//25/02/2024
            return redirect()->route('promotion.index')->with('success_message', 'Produit enregistré avec succès');
            

        } catch (Exception $e) {
            dd($e);
        }
    }

    public function edit(Produit $produit)
    {
        $categories = Categories::all();
        $emplacements = Emplacement::all();
        $produitTypes = ProduitType::all();

        return view('ProduitPromotions.edit', compact('produit','categories','emplacements','produitTypes'));
    }

    public function update(Produit $produit, Request $request)
    {
        //dd($produit);
        //Enregistrer un nouveau département
        try {
            $produit->id = $request->id;
            $produit->code = $request->code;
            $produit->categorie_id = $request->categorie;
            $produit->emplacement_id = $request->emplacement;
            $produit->libelle = $request->libelle;
            $produit->prix = $request->prix;
            $produit->nombre = $request->nombre;

            //dd($produit);
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
            $grosProduit->nombre = $request->nombre;

            // Sauvegarder les modifications dans la base de données
            $grosProduit->update();

            return redirect()->route('promotion.index')->with('success_message', 'Produit modifié avec succès');

           // }
        } catch (Exception $e) {
            dd($e);
        }
    }


    
}
