<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Facture;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointController extends Controller
{
    //


    public function index(Request $request){


        
            /////////////////////////////////////////////////////////////////////////////
        $dateDuJour = date('Y-m-d');
        //dd($dateDuJour);
        $factures = Facture::all();
        // $admins = User::where('id', $admin)->first();

        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });

        // Date d'aujourd'hui
        //$dateAujourdhui = Carbon::today();

        $date_heure_actuelles = Carbon::now();

        // Si l'heure actuelle est avant 10h du matin, utilisez la date d'hier
            if ($date_heure_actuelles->hour < 10) {
                $dateAujourdhui = Carbon::yesterday()->startOfDay();
            } else {
                // Sinon, utilisez la date d'aujourd'hui
                $dateAujourdhui = Carbon::today()->startOfDay();
            }

        // Date d'hier
        $dateHier = $dateAujourdhui->copy()->subDay();

        // Filtrer les factures par date d'aujourd'hui
        $facturesAujourdhui = $codesFacturesUniques->where('date', $dateAujourdhui);
        $facturesHier = $codesFacturesUniques->where('date', $dateHier);

        // Calculer la somme des montants finaux pour les factures d'aujourd'hui
        $sommeMontantFinalAujourdhui = $facturesAujourdhui->sum('montantFinal');
        $sommeMontantFinalHier = $facturesHier->sum('montantFinal');

       // Date du mois actuel
        $dateMoisActuel = Carbon::now()->startOfMonth();
        // $dateMoisPrecedent = Carbon::now()->subMonth()->startOfMonth();

        // Filtrer les factures pour le mois actuel
        $facturesMoisActuel = $codesFacturesUniques->filter(function ($facture) use ($dateMoisActuel) {
            return Carbon::parse($facture->date)->startOfMonth()->equalTo($dateMoisActuel);
        });

        // Calcul de la somme montantFinal pour le mois actuel
        $sommeMontantFinalMoisActuel = $facturesMoisActuel->sum('montantFinal');
        $sommeMontantFinalTousMois = $codesFacturesUniques->sum('montantFinal');

        $depenses = Depense::all();
        $somme_depenses_aujourdhui = Depense::whereDate('date', $dateAujourdhui)
        ->sum('depense');

        $dateMoisActuel = now()->startOfMonth();
        $dateFinMoisActuel = now()->endOfMonth();

        $somme_depenses_mois_actuel = Depense::whereBetween('date', [$dateMoisActuel, $dateFinMoisActuel])
            ->sum('depense');

        //dd($somme_depenses_mois_actuel);
        $solde_final_journalier= ($sommeMontantFinalHier + $sommeMontantFinalAujourdhui)- $somme_depenses_aujourdhui ;
        $solde_final_mois_actuel= $sommeMontantFinalMoisActuel - $somme_depenses_mois_actuel;
        return view('Points.index', compact('sommeMontantFinalAujourdhui','sommeMontantFinalHier','sommeMontantFinalMoisActuel','sommeMontantFinalTousMois','somme_depenses_aujourdhui','solde_final_journalier','somme_depenses_mois_actuel','solde_final_mois_actuel' ));
    
    
    }
}
