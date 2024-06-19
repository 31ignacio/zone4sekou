<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategorieController extends Controller
{
    //

    public function index()
    {
        $categories = Categories::paginate(10);

        return view('Categories.index',compact('categories'));
    }


    public function store(Categories $categorie, Request $request)
    {
        //Enregistrer un nouveau client
        try {
            $categorie->categorie = $request->categorie;
        
            $categorie->save();

            return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function destroy(Categories $categorie)
    {
        // Supprimer le signalement
        $categorie->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success_message', 'La famille a été supprimée avec succès.');
    }


    public function update(Categories $categorie, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $categorie->categorie = $request->categorie;

            $categorie->update();

            return redirect()->route('categorie.index')->with('success_message', 'Famille mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

}
