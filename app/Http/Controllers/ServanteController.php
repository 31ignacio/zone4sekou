<?php

namespace App\Http\Controllers;
use App\Models\Facture;
use App\Models\Servante;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ServanteController extends Controller
{
    //
    public function index()
    {
        $servantes = Servante::all();

        return view('Servantes.index', compact('servantes'));
    }
    public function detail($servante)
    {
        $dateDuJour = date('Y-m-d');
        //$date_heure_actuelles = Carbon::now();     

        //dd($dateDuJour);
        $servantes = Servante::where('id', $servante)->first();

        $factures = Facture::where('servante_id', $servante)->get();
        // Créez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });

        // Calculer la somme des montants "montantRendu" des factures uniques
        $sumMontantRendu = $codesFacturesUniques->sum('montantRendu');

       //dd($sumMontantRendu);


        
        // Déterminer les dates de début et de fin pour la semaine actuelle et la semaine passée
        $date_debut_semaine_actuelle = Carbon::now()->startOfWeek()->toDateString();
        $date_fin_semaine_actuelle = Carbon::now()->endOfWeek()->toDateString();
        
        // Filtrer les factures pour inclure uniquement celles émises cette semaine et la semaine passée
        $factures_semaine_actuelle = $factures->whereBetween('date', [$date_debut_semaine_actuelle, $date_fin_semaine_actuelle]);
        // $factures_semaine_passee = $factures->whereBetween('date', [$date_debut_semaine_passee, $date_fin_semaine_passee]);

        // Regrouper les produits par leur code de facture et sommer leurs quantités pour chaque semaine
        $quantites_par_code_semaine_actuelle = $factures_semaine_actuelle->groupBy('produit')->map(function ($group) {
            return $group->sum('quantite');
        });
        // $quantites_par_code_semaine_passee = $factures_semaine_passee->groupBy('produit')->map(function ($group) {
        //     return $group->sum('quantite');
        // });

        // Sélectionner les trois premiers produits après le tri
        $trois_produits_sup_semaine = $quantites_par_code_semaine_actuelle->take(3);
        // $trois_produits_sup_semaine_passee = $quantites_par_code_semaine_passee->take(3);

        //dd($trois_produits_sup);

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

        // Filtrer les factures pour le mois actuel
        $facturesMoisActuel = $codesFacturesUniques->filter(function ($facture) use ($dateMoisActuel) {
            return Carbon::parse($facture->date)->startOfMonth()->equalTo($dateMoisActuel);
        });

        // Calcul de la somme montantFinal pour le mois actuel
        $sommeMontantFinalMoisActuel = $facturesMoisActuel->sum('montantFinal');

        // $sommeMontantFinalMoisPrecedent = $facturesMoisPrecedent->sum('montantFinal');
        $sommeMontantFinalTousMois = $codesFacturesUniques->sum('montantFinal');


        //dd($sommeMontantFinalMoisActuel);

        return view('Servantes.detail', compact('codesFacturesUniques','sumMontantRendu', 'servante','servantes','sommeMontantFinalAujourdhui','sommeMontantFinalHier','sommeMontantFinalMoisActuel','sommeMontantFinalTousMois','trois_produits_sup_semaine','quantites_par_code_semaine_actuelle' ));
    }

    public function store(Servante $servante, Request $request)
    {
        //dd(1);
        //Enregistrer un nouveau client
        try {
            $servante->nom = $request->nom . ' ' . $request->prenom;
            $servante->telephone = $request->telephone;
            $servante->date = $request->date;
            $servante->save();

            // dd($client);

            return redirect()->route('servante.index')->with('success_message', 'Servante enregistrée avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, Servante $servante)
    {
        $servante->update($request->all());
        
        return redirect()->route('servante.index')->with('success_message', 'Servante mise à jour avec succès');
    }

    public function destroy(Servante $servante)
    {
        // Supprimer le signalement
        $servante->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success_message', 'Le servante a été supprimé avec succès.');
    }
   
}
