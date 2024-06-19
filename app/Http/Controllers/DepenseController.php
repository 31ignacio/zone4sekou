<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Facture;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
    //
    //
    public function index()
    {
        $user = Auth::user();
        $user_id =$user->id;
        $user_role =$user->role_id;
        $date_heure_actuelles = Carbon::now();
        $dateMoisActuel = Carbon::now()->startOfMonth();
        $dateFinMoisActuel = Carbon::now()->endOfMonth();

            // Si l'heure actuelle est avant 10h du matin, utilisez la date d'hier
            if ($date_heure_actuelles->hour < 10) {
                $date_aujourdhui = Carbon::yesterday()->startOfDay();
            } else {
                // Sinon, utilisez la date d'aujourd'hui
                $date_aujourdhui = Carbon::today()->startOfDay();
            }

        if($user_role== 1){
            $depenses = Depense::all();
            $somme_depenses_aujourdhui = Depense::whereDate('date', $date_aujourdhui)->sum('depense');
            $somme_depenses_mois = Depense::
            whereBetween('date', [$dateMoisActuel, $dateFinMoisActuel])
            ->sum('depense');

            $facture = Facture::all();
            $codesFacturesUnique = $facture->unique(function ($factur) {
                return $factur->code . $factur->date . $factur->totalTTC . $factur->montantPaye . $factur->mode;
            });
            $facturesAujourdhui = $codesFacturesUnique->where('date', $date_aujourdhui);
            $sommeMontantFinalAujourdhui = $facturesAujourdhui->sum('montantFinal');
            $recetteDepense= $sommeMontantFinalAujourdhui - $somme_depenses_aujourdhui ;


        }else{
            $depenses = Depense::where('user_id', $user_id)->get();
            $somme_depenses_aujourdhui = Depense::where('user_id', $user_id)
            ->whereDate('date', $date_aujourdhui)
            ->sum('depense');
        
            $somme_depenses_mois = Depense::where('user_id', $user_id)
            ->whereBetween('date', [$dateMoisActuel, $dateFinMoisActuel])
            ->sum('depense');

            $factures = Facture::where('user_id', $user_id)->get();

            // Créez une collection unique en fonction des colonnes code, date, client et totalHT
            $codesFacturesUniques = $factures->unique(function ($facture) {
                return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
            });
            $facturesAujourdhuiCaisse = $codesFacturesUniques->where('date', $date_aujourdhui);
            $sommeMontantFinalAujourdhui = $facturesAujourdhuiCaisse->sum('montantFinal');
            $recetteDepense= $sommeMontantFinalAujourdhui - $somme_depenses_aujourdhui ;


        }

        return view('Depenses.index', compact('depenses','somme_depenses_aujourdhui','somme_depenses_mois','recetteDepense'));
    }

    public function store(Depense $depense, Request $request)
    {
        $user = Auth::user();

        //Enregistrer un nouveau client
        try {
            $depense->depense = $request->depense;
            $depense->libelle = $request->libelle;
            $depense->user_id = $user->id;
            $depense->date = $request->date;
            $depense->save();

            // dd($client);

            return redirect()->route('depense.index')->with('success_message', 'Dépense enregistrée avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, Depense $depense)
    {
        $depense->update($request->all());
        
        return redirect()->route('depense.index')->with('success_message', 'Dépense mise à jour avec succès');
    }

    public function destroy(Depense $depense)
    {
        // Supprimer le signalement
        $depense->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success_message', 'Dépense supprimée avec succès.');
    }

    
}
