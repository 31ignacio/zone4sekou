<?php

namespace App\Http\Controllers;

use App\Models\Emplacement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmplacementController extends Controller
{
    //

    public function index()
    {
        $emplacements = Emplacement::paginate(10);
        //dd($emplacements);

        return view('Emplacements.index',compact('emplacements'));
    }


    public function store(Emplacement $emplacement, Request $request)
    {
        //Enregistrer un nouveau client

        //dd($request);
        try {
            $emplacement->nom = $request->emplacement;
            //dd($emplacement);

            $emplacement->save();

            return new Response(200);
        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
    }

    public function destroy(Emplacement $emplacement)
    {
        // Supprimer le signalement
        $emplacement->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success_message', 'Le type a été supprimé avec succès.');
    }


    public function update(Emplacement $emplacement, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $emplacement->nom = $request->emplacement;

            $emplacement->update();

            return redirect()->route('emplacement.index')->with('success_message', 'Le type a été mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


}
