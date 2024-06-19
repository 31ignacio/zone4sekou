<?php

namespace App\Http\Controllers;
use App\Models\Facture;
use App\Models\Client;
use App\Models\Emplacement;
use App\Models\FactureEnAtente;
use App\Models\information;
use App\Models\Produit;
use App\Models\grosProduit;
use App\Models\ProduitType;
use App\Models\Servante;
use DateTime; // Importez la classe DateTime en haut de votre fichier
use Exception;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str; // Importez la classe Str

class FactureController extends Controller
{
    //

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        //dd($user);
        // Vous pouvez maintenant accéder aux propriétés de l'utilisateur
        $nom = $user->name;
        $role=$user->role_id;
        //dd($role);

        // Recuperer la somme du montantFinal pour l'utilisateur connecte et le rôle donne
        $sommeMontant = Facture::where('user_id', $user->id)
            // ->where('role_id', $role)
            ->whereDate('date', now()) // Filtre pour la date du jour
            ->sum('montantFinal');

            //dd($sommeMontant);

        $factures = Facture::all();
        $client = Client::all();

        // Creez une collection unique en fonction des colonnes code, date, client et totalHT
        $codesFacturesUniques = $factures
        ->unique(function ($facture) {
            return $facture->code . $facture->date . $facture->client . $facture->totalHT . $facture->emplacement;
        })
        ->sortByDesc('created_at');
       // dd($codesFacturesUniques);

        // Paginer les resultats obtenus
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $codesFacturesUniques->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer une instance de LengthAwarePaginator
        $codesFacturesUniques = new LengthAwarePaginator(
            $currentPageItems,
            $codesFacturesUniques->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
            

        //$factures = Facture::orderBy('code')->get()->groupBy('code');
       //dd($codesFacturesUniques);
        return view('Factures.index', compact('factures', 'codesFacturesUniques','nom','role'));
    }

    public function point()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        //dd($user);
        // Vous pouvez maintenant accéder aux propriétés de l'utilisateur
        $nom = $user->name;
        $role=$user->role_id;
        //dd($role);

       // Récupérer le rôle et l'identifiant de l'utilisateur
       $role_id = $user->role_id;
       $user_id = $user->id;

       $factures = Facture::where('user_id', $user_id)->get();
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


        // Date d'hier
        $dateHier = $dateAujourdhui->copy()->subDay();
        // Date du mois actuel
        $dateMoisActuel = Carbon::now()->startOfMonth();
        //dd($dateMoisActuel);

        // Si l'utilisateur a le rôle avec role_id=2
        if ($role_id == 2 or $role_id == 3) {

            $codesFacturesUnique = $factures->unique(function ($facture) {
                return $facture->code . $facture->date . $facture->totalTTC . $facture->montantPaye . $facture->mode;
            });
            // Filtrer les factures par date d'aujourd'hui
            $facturesAujour = $codesFacturesUnique->where('date', $dateAujourdhui);
            // Filtrer les factures par date d'aujourd'hui
            $facturesHier = $codesFacturesUnique->where('date', $dateHier);
            // Filtrer les factures pour le mois actuel
            $facturesMoisActuel = $codesFacturesUnique->filter(function ($facture) use ($dateMoisActuel) {
                return Carbon::parse($facture->date)->startOfMonth()->equalTo($dateMoisActuel);
            });            
            // Calculer la somme des montants finaux pour les factures d'aujourd'hui
            $sommeMontantFinalAujourdhui = $facturesAujour->sum('montantFinal');
            $sommeMontantFinalHier = $facturesHier->sum('montantFinal');
            $sommeMontantFinalMois = $facturesMoisActuel->sum('montantFinal');

        } else {
            // Récupérer la somme totale du montantFinal pour la journée
            $codesFacturesUnique = $facture->unique(function ($factur) {
                return $factur->code . $factur->date . $factur->totalTTC . $factur->montantPaye . $factur->mode;
            });
            // Filtrer les factures par date d'aujourd'hui
            $facturesAujourdhui = $codesFacturesUnique->where('date', $dateAujourdhui);
            $facturesHier = $codesFacturesUnique->where('date', $dateHier);
            // Filtrer les factures pour le mois actuel
            $facturesMoisActuel = $codesFacturesUnique->filter(function ($facture) use ($dateMoisActuel) {
                return Carbon::parse($facture->date)->startOfMonth()->equalTo($dateMoisActuel);
            });
            // Calculer la somme des montants finaux pour les factures d'aujourd'hui
            $sommeMontantFinalAujourdhui = $facturesAujourdhui->sum('montantFinal');
            $sommeMontantFinalHier = $facturesHier->sum('montantFinal');
            $sommeMontantFinalMois = $facturesMoisActuel->sum('montantFinal');

        }

        // Filtrer les factures par date d'aujourd'hui
        $codesFacturesUniques = $codesFacturesUnique->where('date', $dateAujourdhui);
        // Paginer les résultats obtenus
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $codesFacturesUniques->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer une instance de LengthAwarePaginator
        $codesFacturesUniques = new LengthAwarePaginator(
            $currentPageItems,
            $codesFacturesUniques->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
            
        return view('Factures.point', compact('factures', 'codesFacturesUniques','nom','role','sommeMontantFinalAujourdhui','sommeMontantFinalHier','sommeMontantFinalMois'));
    }

    public function details($code, $date)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue

        $factures = Facture::all();
        //dd($factures);
        return view('Factures.details', compact('date', 'code', 'factures'));
    }

    public function annuler(Request $request)
    {
        // Récupérez les informations nécessaires à partir des paramètres (code et date) et envoyez-les à la vue
        //dd($code);
       // $factures = Facture::where('code',$code)->get();
       $code=$request->factureCode;
      //dd($code);
        $factures = Facture::select('produit', 'quantite')->where('code', $code)->get();
        //dd($request,$factures);
        foreach ($factures as $facture) {
            //c'est la tu feras le jeu
            $produit = grosProduit::where('libelle', $facture->produit)->first();

            if ($produit) {
                $nouvelleQuantite = $produit->quantite + $facture->quantite - $facture->quantite; // Mettez à jour la nouvelle quantité
        
                // Assurez-vous de mettre à jour le produit avec la nouvelle quantité correcte
                $produit->quantite = $nouvelleQuantite;
                $produit->save();
            }
           // dd($produit);
        }
        //dd($produit);
        // Suppression de toutes les factures avec le code spécifié
        Facture::where('code', $code)->delete();

        //dd($fa);
        return back()->with('success_message', 'La facture a été annulée avec succès.');
    }

    public function create()
    {
        $code="000";
        $emplacements = Emplacement::all();
        $clients = Client::all();
        $servantes = Servante::all();
        $produits = grosProduit::all();
        $produitTypes = ProduitType::all();

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
       // dd($produits);
        return view('Factures.create', compact('clients','servantes', 'emplacements','produits','produitTypes','code'));
    }

    public function store(Request $request)
    { 
        if (Auth::check()) {

            // Récupérer les données JSON envoyées depuis le formulaire
            $donnees = json_decode($request->input('donnees'));
            //dd($donnees);
            $client_id = $request->client;
            //dd($client_id);
            $parts = explode(' ', $client_id);
            $client_id = $parts[0]; // Contient "2"
            $client_nom = $parts[1]; // Contient "zz"
            $dateString = $request->date;
            $totalHT = $request->totalHT;
            $totalTVA = $request->totalTVA;
            $totalTTC = $request->totalTTC;
            $montantPaye = $request->montantPaye;
            $remise = $request->remise;
            $montantFinal = $request->montantFinal;
            $produitType = $request->produitType;
            $servante = $request->servante;
            
            // Recupere l'utilisateur connecte
            $user = Auth::user();
            //dd($produitType, $client);
            
            // Vous pouvez acceder aux proprietes de l'utilisateur, par exemple :
            $idUser = $user->id;
            
            $prefix = 'Fact_';
            $nombreAleatoire = rand(0, 10000); // Utilisation de rand()

            // Formatage du nouveau matricule avec la partie numerique

            if($request->code == "000"){
                $code = $prefix . $nombreAleatoire;
            }else{
                $code= $request->code;
            }

            // Convertissez la date en un objet DateTime
            $date = new DateTime($dateString);
            try {
                // Parcourez chaque element de $donnees et enregistrez-les dans la base de donnees
                foreach ($donnees as $donnee) {

                    $facture= new FactureEnAtente();
                    $facture->client = $client_id; 
                    $facture->client_nom = $client_nom; 
                    $facture->date = $date;
                    $facture->produitType_id = $produitType;
                    $facture->servante_id = $servante;
                    $facture->montantPaye =  $montantPaye;
                    $facture->montantRendu =  $montantPaye - $totalTTC;
                    // Vous pouvez accéder aux propriétés de chaque objet JSON
                    $facture->quantite = $donnee->quantite;
                    $facture->produit= $donnee->produit; // Assurez-vous d'utiliser la bonne clé ici

                    //dump($donnee->produit);
                        // Si le produit se termine par "_Pro"
                    if (Str::endsWith($donnee->produit, '_Pro')) {

                        $produits = Produit::where('promotion', 'oui')->where('libelle',$donnee->produit)->first();
                        $nombre=$produits->nombre;
                        //dd($nombre);
                        // Supprimer le suffixe "_Pro"
                        $produitSansPro = Str::beforeLast($donnee->produit, '__Pro');
                        //dd($produitSansPro);
                        // Rechercher le produit sans le suffixe dans la table grosProduit
                        $grosProduit = grosProduit::where('libelle', $produitSansPro)->first();
                        // Affecter la valeur de $grosProduit à $produit
                        $produit = $grosProduit;
                        //dd($produit);
                        $facture->produit= $produit->libelle; // Assurez-vous d'utiliser la bonne clé ici
                        $facture->quantite = $donnee->quantite * $nombre;

                    }

                    $facture->prix = $donnee->prix;
                    $facture->total = $donnee->total;

                        /////
                        if ($code) {
                            // Vérifie si le code existe dans la table FactureEnAttente
                            $codeExists = FactureEnAtente::where('code', $request->code)->exists();
                        
                            if ($codeExists) {
                                // Si le code existe, effectue les calculs
                                $totalHT = (FactureEnAtente::where('code', $request->code)->sum('total') + $donnee->total)/(1+0.18);
                                $totalTVA = (($totalHT * 18) / 100);
                                $totalTTC = $totalHT + $totalTVA;
                            } 
                        }
                        
                    $facture->totalHT = $totalHT;
                    $facture->totalTVA = $totalTVA;
                    $facture->totalTTC = $totalTTC;

                    $facture->code = $code;
                    $facture->user_id =$idUser;
                    $facture->reduction =$remise;
                    $facture->montantFinal =$montantFinal;

                    //dd($facture);
                    // Sauvegardez la facture dans la base de données
                    $facture->save();
                }
                $factures = FactureEnAtente::where('code', $request->code)->get();
                foreach ($factures as $facture) {
                   
                    // Mettre à jour les enregistrements avec les nouveaux montants
                    $facture->totalHT = $totalHT;
                    $facture->totalTVA = $totalTVA;
                    $facture->totalTTC = $totalTTC;
                    $facture->save(); // Enregistrer les modifications dans la base de données
                }

                return new Response(200);
            } catch (Exception $e) {
                dd($e);
                return new Response(500);
            }
        }else {
            // Aucun utilisateur n'est connecté
            // Rediriger vers la page de connexion avec un message
            return redirect()->route('login')
                            ->with('success_message', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Répondez avec une réponse de confirmation
        return response()->json(['message' => 'Données enregistrées avec succès']);
    }

    public function pdf($facture,Request $request)
    {
        $date = $request->input('date');
        $code = $request->input('code');
        //$id = $request->input('id');

        //dd($facture);
        try {
            //recuperer tout les information de l'entreprise
            $factures = Facture::all();
            $info = information::first();

            //$name= $facture['date'];
          // Chargez la vue Laravel que vous souhaitez convertir en PDF
        $html = View::make('Factures.facture',compact('factures','info','date','code'))->render();


            // Créez une instance de Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendez le PDF
        $dompdf->render();

        // Téléchargez le PDF
        return $dompdf->stream('Facture .pdf', ['Attachment' => false]);

        } catch (Exception $e) {
            dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }

    public function reglement(Request $request){

        //dd($request);
        $code= $request->factureCode;
        $reglement= $request->reglement;

        $factures= Facture::where('code', $code)->get();
        foreach ($factures as $facture) {

            if($reglement > $facture->montantFinal){
                return redirect()->back()->with('danger_message', 'Le montant saisir ne peut pas etre superieur au total TTC.');

            }

            $totalTTC= $facture->totalTTC;
            // Mettre à jour les enregistrements avec les nouveaux montants
            $facture->montantPaye = $reglement;
            $facture->montantRendu = $reglement - $totalTTC;
            $facture->montantFinal = $totalTTC;
            $facture->save(); // Enregistrer les modifications dans la base de données
        }

        return redirect()->back()->with('success_message', 'Reglement enregistré avec succès.');


    }

}
