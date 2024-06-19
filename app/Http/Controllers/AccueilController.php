<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Fournisseur;
use App\Models\grosProduit;
use App\Models\Produit;
use App\Models\Servante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccueilController extends Controller
{
    //

    public function index(){

        // Récupérer l'ID de l'utilisateur connecté
        $user = Auth::user();
        $user_id=$user->id;
        //dd($user_id);

        $servantes = Servante::all();        
        $facture = Facture::all();

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

         // Récupérer la somme totale du montantFinal pour la journée
         $codesFacturesUnique = $facture->unique(function ($factur) {
            return $factur->code . $factur->date . $factur->totalTTC . $factur->montantPaye . $factur->mode;
        });
        $factures = Facture::where('user_id', $user_id)->get();

         // Créez une collection unique en fonction des colonnes code, date, client et totalHT
         $codesFacturesUniques = $factures->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
        });
        // Filtrer les factures par date d'aujourd'hui
        $facturesAujourdhui = $codesFacturesUnique->where('date', $dateAujourdhui);
        $facturesAujourdhuiCaisse = $codesFacturesUniques->where('date', $dateAujourdhui);

        // Calculer la somme des montants finaux pour les factures d'aujourd'hui
        $sommeMontantFinalAujourdhui = $facturesAujourdhui->sum('montantFinal');
        $sommeMontantFinalAujourdhuiCaisse = $facturesAujourdhuiCaisse->sum('montantFinal');

        $facturesParJour = Facture::all()->groupBy(function ($facture) {
            return (new DateTime($facture->date))->format('Y-m-d');
        });
        
        $sommeMontantParJour = $facturesParJour->map(function ($factures) {
            return $factures->sum('montantFinal');
        });

        $sommeMontantFinalTousMois = $codesFacturesUnique->sum('montantFinal');

         
        //dd($sommeTotalTTC,$sommeMontantDu);
        $nombreServantes=count($servantes);

        $produits = grosProduit::where('produitType_id', 1)->get();
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
         

        return view('Accueil.index',compact('nombreServantes','sommeMontantFinalAujourdhui','sommeMontantFinalAujourdhuiCaisse','produits','sommeMontantFinalTousMois'));
    }

    public function password(){

        return view('Accueil.password');
    }

    public function update(Request $request){
        //dd($request);
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:2',
            'password_confirmation' => 'required'
        ], [
            'old_password.required' => 'L\'ancien mot de passe est requis.',
            'password.required' => 'Le nouveau mot de passe est requis.',
            'password.min' => 'Le nouveau mot de passe doit comporter au moins 2 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password_confirmation.required' => 'La confirmation du mot de passe est requise.'
        ]);
        
        try{
            $user = Auth::user();
        
            // Vérifier si le mot de passe actuel est correct
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('danger','Le mot de passe actuel est incorrect.');
            }
        
            // Vérifier si le nouveau mot de passe est identique à l'ancien
            if (Hash::check($request->password, $user->password)) {
                return back()->with('danger','Le nouveau mot de passe doit être différent du mot de passe actuel.');
            }

            // Vérifier si le mot de passe et la confirmation sont identiques
            if ($request->password !== $request->password_confirmation) {
                return back()->with('danger','Le mot de passe de confirmation ne correspond pas au nouveau mot de passe.');
            }
        
            // Mettre à jour le mot de passe
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            // Mail::to($user->email)->send(new ModifierPasswordMail($user));

            // Déconnecter l'utilisateur
            Auth::logout();

            // Rediriger vers la page de connexion avec un message de succès
            return redirect()->route('login')->with('success_msg', 'Votre mot de passe a été modifié avec succès. Veuillez vous reconnecter avec le nouveau mot de passe.');

        }catch(Exception $e){
            dd($e);
        }
    }

}
