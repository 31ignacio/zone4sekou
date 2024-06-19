<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\grosProduit;
use App\Models\Produit;
use App\Models\Servante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtatController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = Facture::query();
        
        $dateDebut= $request->dateDebut;
        $dateFin= $request->dateFin;

        if($dateDebut > $dateFin){
            return back()->with('danger_message','La date début ne peut pas être superieur à la date fin');
        }

        
        if ($request->filled('dateDebut')) {
            $query->where('date', '>=', $request->dateDebut);
        }
    
        if ($request->filled('dateFin')) {
            $query->where('date', '<=', $request->dateFin);
        }

            $results = $query->groupBy('code')->get();
           // dd($results);
        
            return view('Etats/index', compact('results'));
    }

    public function periodeFacture(Request $request){

        $query = Facture::query();
        
        $dateDebut= $request->dateDebut;
        $dateFin= $request->dateFin;

        if($dateDebut > $dateFin){
            return back()->with('danger_message','La date début ne peut pas être superieur à la date fin');
        }
       

        if (!empty($dateDebut)) {
            $query->where('date', '>=', $dateDebut);
        }

        if (!empty($dateFin)) {
            $query->where('date', '<=', $dateFin);
        }
        $codesFacturesUniques = $query->get();
       //dd($codesFacturesUniques);

       $codesFacturesUniques1 = $query->groupBy('code','date')->get();

        // Calculer la somme de totalHT des factures uniques
        $totalHT = $codesFacturesUniques1->sum('totalHT');
       // dd($totalHT);

        // Calculer la somme de totalTVA des factures uniques
        $totalTVA = $codesFacturesUniques1->sum('totalTVA');
        // Calculer la somme de totalTVA des factures uniques
        $totalTTC = $codesFacturesUniques1->sum('totalTTC');
        // Calculer la somme de totalTVA des factures uniques
        $montantPaye = $codesFacturesUniques1->sum('montantPaye');
        // Calculer la somme de totalTVA des factures uniques
        $montantFinal = $codesFacturesUniques1->sum('montantFinal');
         // Calculer la somme de totalTVA des factures uniques
         $montantRendu = $codesFacturesUniques1->sum('montantRendu');

        return view('Etats/periode', compact('codesFacturesUniques','dateDebut','dateFin','totalHT','totalTVA','totalTTC','montantPaye','montantFinal','montantRendu'));

    }
    
    

}
