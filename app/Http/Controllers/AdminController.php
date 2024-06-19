<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUsersRequest;
use App\Models\Depense;
use App\Models\Facture;
use App\Models\information;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    
    public function index(){
      // dd(Auth::id());
      $admins = User::where('estActif', 0)->get();
        return view('Admin.index',compact('admins'));
    }

    public function detail($admin)
    {
        //dd($admin);

        $dateDuJour = date('Y-m-d');
        //dd($dateDuJour);
        $factures = Facture::where('user_id', $admin)->get();
        $admins = User::where('id', $admin)->first();

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

        $depenses = Depense::where('user_id', $admin)->get();
        $somme_depenses_aujourdhui = Depense::where('user_id', $admin)
        ->whereDate('date', $dateAujourdhui)
        ->sum('depense');

        $dateMoisActuel = now()->startOfMonth();
        $dateFinMoisActuel = now()->endOfMonth();

        $somme_depenses_mois_actuel = Depense::where('user_id', $admin)
            ->whereBetween('date', [$dateMoisActuel, $dateFinMoisActuel])
            ->sum('depense');

        //dd($somme_depenses_mois_actuel);
        $solde_final_journalier= ($sommeMontantFinalHier + $sommeMontantFinalAujourdhui)- $somme_depenses_aujourdhui ;
        $solde_final_mois_actuel= $sommeMontantFinalMoisActuel - $somme_depenses_mois_actuel;
        return view('Admin.detail', compact('codesFacturesUniques', 'admin','admins','sommeMontantFinalAujourdhui','sommeMontantFinalHier','sommeMontantFinalMoisActuel','sommeMontantFinalTousMois','somme_depenses_aujourdhui','solde_final_journalier','somme_depenses_mois_actuel','solde_final_mois_actuel' ));
    }

    public function indexInfo(){

        $info = information::first();
        return view('Informations.index',compact('info'));
    }


    public function index2(){
        
        $admins = User::where('estActif', 1)->get();
        return view('Admin.index2',compact('admins'));
    }


    public function create(){

        $roles = Role::all();
        return view('Admin.create',compact('roles'));
    }


    public function store(User $user,createUsersRequest $request)
    {

        try {
            $confirm= $request->confirm_password;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->telephone = $request->telephone;
            $user->role_id= $request->role;
            $user->password =Hash::make($request->password);
            $user->save();

            return redirect()->route('admin')->with('success_message', 'Utilisateur ajouté avec succès');
            
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet utilisateur');
        }
    }

    public function createInfo(){

        return view('Informations.create');
    }


    public function storeInfo(information $info,Request $request)
    {

        try {

            $info->nom = $request->nom;
            $info->adresse = $request->adresse;
            $info->telephone = $request->telephone;
            $info->ifu= $request->ifu;
            //dd($user);

            $info->save();

            
            return redirect()->route('information')->with('success_message', 'Information ajoutée avec succès');
            
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet utilisateur');
        }
    }

   
    public function logout(){

        FacadesSession::flush();
        Auth::logout();

        return redirect()->route('login');
    }



    public function edit(User $admin)
    {
        //dd($admin);
        
        return view('Admin.edit', compact('admin'));
    }

    public function update(User $admin, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $admin->name = $request->nom;
            $admin->email = $request->email;
            $admin->telephone = $request->telephone;
            $admin->role_id = $request->role;

            $admin->update();
            //return back()->with('success_message', 'Utilisateur mis à jour avec succès');

            return redirect()->route('admin')->with('success_message', 'Utilisateur mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function editInfo(information $information)
    {
        //dd($information);

        return view('Informations.edit', compact('information'));
    }

    public function updateInfo($info, Request $request)
    {
        //dd($info);
        $info = information::where('id', $info)->first();

        //Enregistrer un nouveau département
        try {
            $info->id = $request->id;

            $info->nom = $request->nom;
            $info->adresse = $request->adresse;
            $info->telephone = $request->telephone;
            $info->ifu= $request->ifu;
                //dd($info);
            $info->update();
            //return back()->with('success_message', 'Utilisateur mis à jour avec succès');
               // dd($info);
            return redirect()->route('information')->with('success_message', 'information modifiée avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function delete(User $admin)
    {
        //Enregistrer un nouveau département
        try {
            $admin->delete();

            return redirect()->route('admin')->with('success_message', 'Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    

}
