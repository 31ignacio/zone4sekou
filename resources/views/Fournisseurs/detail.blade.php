@extends('layouts.master2')

@section('content')
    <br>
    {{-- Mes bouton en haut (qui affiche le modal) --}}
    <div class="row">
        {{-- <div class="col-md-1 col-sm-1"></div> --}}
        
        <div class="col-md-2 mb-2 mx-3">
            <button type="button" class="btn btn-sm btn-warning btn-block" data-toggle="modal" data-target="#modal-success">
                Sortie casier
            </button>
        </div>
        <div class="col-md-2 mb-2 mx-3">
            <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#modal-warning">
                 Bouteille cassée
            </button>
        </div>
        <div class="col-md-2 mb-2 mx-3">
            <button type="button" class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#modal-info">
                 Bouteille coulée
            </button>
        </div>
        <div class="col-md-6"></div>
    </div>

    <br>
        {{-- Mes messages --}}
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            @if (Session::get('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="card card-success card-outline mb-5 mx-3">
        <div class="card-header">

        </div>
        <div class="card-body">
            {{-- <h4>Left Sided</h4> --}}
            <div class="row">
                <div class="col-md-3 col-sm-2">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home"
                            role="tab" aria-controls="vert-tabs-home" aria-selected="true">ENTRES</a>

                        <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages"
                            role="tab" aria-controls="vert-tabs-messages" aria-selected="false">SORTIS</a>
                        <a class="nav-link" id="vert-tabs-messages-tab1" data-toggle="pill" href="#vert-tabs-messages1"
                        role="tab" aria-controls="vert-tabs-messages1" aria-selected="false">Bouteille cassée</a>
                        <a class="nav-link" id="vert-tabs-messages-tab2" data-toggle="pill" href="#vert-tabs-messages2"
                        role="tab" aria-controls="vert-tabs-messages2" aria-selected="false">Bouteille coulée</a>
                        {{-- <a class="nav-link" id="vert-tabs-messages-tab3" data-toggle="pill" href="#vert-tabs-messages3"
                        role="tab" aria-controls="vert-tabs-messages1" aria-selected="false">CASIERS 12T</a>
                        <a class="nav-link" id="vert-tabs-messages-tab4" data-toggle="pill" href="#vert-tabs-messages4"
                        role="tab" aria-controls="vert-tabs-messages1" aria-selected="false">CASIERS 20T</a> --}}
                    </div>
                </div>
                <div class="col-md-9 col-sm-10">
                    <div class="tab-content" id="vert-tabs-tabContent">

                        <div class="tab-content" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel"
                                aria-labelledby="vert-tabs-home-tab"> 

                            {{-- CASIER ENTRES --}}
                        
                            <div class="container mt-2">
                                <h2 class="mb-2">Liste des casiers entrés</h2>
                                <div class="table-responsive"> <!-- Rend le tableau réactif pour les appareils mobiles -->
                                    <table id="example3" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>CASIERS 24T</th>
                                                <th>CASIERS 12T</th>
                                                <th>CASIERS 20T</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stocksByDate as $date => $stocks)
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                                    <td> <span class="badge badge-success badge-custom">{{ isset($stocks[1]) ? $stocks[1] : '-' }}</span></td>
                                                    <td> <span class="badge badge-warning badge-custom">{{ isset($stocks[2]) ? $stocks[2] : '-' }}</span></td>
                                                    <td> <span class="badge badge-info badge-custom">{{ isset($stocks[3]) ? $stocks[3] : '-' }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    
                                </div>
                            </div>

                        </div>
                                {{-- Sortie --}}
                        <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                            aria-labelledby="vert-tabs-messages-tab">

                            <h2 class="mb-2">Liste des casiers sortis</h2>

                            <div class="table-responsive">
                                {{-- Tableau3 Reglement --}}
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>CASIERS 24T</th>
                                            <th>CASIERS 12T</th>
                                            <th>CASIERS 20T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reglementsByDate as $date => $stocks)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                                <td> <span class="badge badge-success badge-custom">{{ isset($stocks[1]) ? $stocks[1] : '-' }}</span></td>
                                                <td> <span class="badge badge-warning badge-custom">{{ isset($stocks[2]) ? $stocks[2] : '-' }}</span></td>
                                                <td> <span class="badge badge-info badge-custom">{{ isset($stocks[3]) ? $stocks[3] : '-' }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>

                            {{-- Cassée --}}
                        <div class="tab-pane fade" id="vert-tabs-messages1" role="tabpanel"
                            aria-labelledby="vert-tabs-messages-tab1">

                            <h2 class="mb-2">Liste des bouteilles cassées</h2>

                            <div class="table-responsive">
                                {{-- Tableau3 Reglement --}}
                                <table id="example2" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>Bouteilles</th>
                                            <th>Nombre</th>
                                            <th>Superviseur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cassesByDate as $date => $details)
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                            <td>{{ $detail['produit'] }}</td>
                                            <td>{{ $detail['nombre'] }}</td>
                                            <td>{{ $detail['user'] }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>

                            {{-- Coulée --}}
                        <div class="tab-pane fade" id="vert-tabs-messages2" role="tabpanel"
                            aria-labelledby="vert-tabs-messages-tab1">

                            <h2 class="mb-2">Liste des bouteilles coulées</h2>

                            <div class="table-responsive">
                                {{-- Tableau3 Reglement --}}
                                <table id="example5" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>Bouteilles</th>
                                            <th>Nombre</th>
                                            <th>Superviseur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coulerByDate as $date => $details)
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                            <td>{{ $detail['produit'] }}</td>
                                            <td>{{ $detail['nombre'] }}</td>
                                            <td>{{ $detail['user'] }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- /.card -->
    </div>


    
    {{-- Modal enregistrer un reglement --}}

    <div class="modal fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enregistrer une sortie</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('fournisseur.storeReglement') }}">
                        @csrf
                        <div class="form-group">
                            <label for="recette">Nombre :</label>
                            <input type="number" min="0" class="form-control" name="nombre" id="nombre" required />
                        </div>

                        <div class="form-group">
                            <label for="date">Date :</label>
                            <input type="date" class="form-control" name="date" id="date" required readonly />

                        </div>
                        <div class="form-group">
                            <label for="charge">Type:</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="">Sélectionnez le type</option>
                                    <option value="1">CASIERS 24T</option>
                                    <option value="2">CASIERS 12T</option>
                                    <option value="3">CASIERS 20T</option>

                            </select>
                        </div>

                        <input type="hidden" class="form-control" name="status" id="status" value="Sortie"
                            required />
                        

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    {{-- Modal enregistrer un bouteille cassée --}}

    <div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enregistrer bouteille cassée</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('fournisseur.storeCasser') }}">
                        @csrf
                        <div class="form-group">
                            <label for="recette">Nombre :</label>
                            <input type="number" min="0" class="form-control" name="nombre" id="nombre" required />
                        </div>

                        <div class="form-group">
                            <label for="date">Date :</label>
                            <input type="date" class="form-control" name="date" id="date2" required readonly />
                        </div>
                        <div class="form-group">
                            <label for="charge">Produit:</label>
                            <select class="form-control select2" name="produit" id="produit" required>
                                <option value="">Sélectionnez le type</option>
                                @foreach ($produits as $produit )
                                    
                                <option value="{{ $produit->libelle }}">{{ $produit->libelle }}</option>
                                @endforeach

                            </select>
                        </div>

                        <input type="hidden" class="form-control" name="status" id="status" value="Cassée"/>
                        <input type="hidden" class="form-control" name="type" id="type" value="5"/>


                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

     {{-- Modal enregistrer un bouteille coulee --}}

     <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enregistrer bouteille coulée</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('fournisseur.storeCouler') }}">
                        @csrf
                        <div class="form-group">
                            <label for="recette">Nombre :</label>
                            <input type="number" min="0" class="form-control" name="nombre" id="nombre" required />
                        </div>

                        <div class="form-group">
                            <label for="date">Date :</label>
                            <input type="date" class="form-control" name="date" id="date3" required readonly />
                        </div>
                        <div class="form-group">
                            <label for="charge">Produit:</label>
                            <select class="form-control select2" name="produit" id="produit" required>
                                <option value="">Sélectionnez le type</option>
                                @foreach ($produits as $produit )
                                    
                                <option value="{{ $produit->libelle }}">{{ $produit->libelle }}</option>
                                @endforeach

                            </select>
                        </div>

                        <input type="hidden" class="form-control" name="status" id="status" value="coulée"/>
                        <input type="hidden" class="form-control" name="type" id="type" value="6"/>


                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <style>
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        .title-icon {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .title-icon i {
            font-size: 24px;
            color: #4CAF50;
            margin-right: 10px;
        }
        .card-title {
            font-weight: bold;
            color: #333;
        }
        .list-group-item-custom {
            border: none;
            padding: 10px 15px;
            background-color: #fff;
            margin-bottom: 5px;
            border-radius: 8px;
        }
        .badge-custom {
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 8px;
        }
        .badge-danger {
            background-color: #f44336;
        }
        .badge-success {
            background-color: #4CAF50;
        }
        .badge-warning {
            background-color: #FF9800;
        }
        .badge-info {
            background-color: #2196F3;
        }
    </style>
    {{-- Control sur la date --}}

    
    <script>
        // Récupérer la date d'aujourd'hui
        var dateActuelle = new Date();

        // Si l'heure actuelle est avant 10h, décrémentez d'un jour
        if (dateActuelle.getHours() < 10) {
            dateActuelle.setDate(dateActuelle.getDate() - 1);
        }

        var annee = dateActuelle.getFullYear();
        var mois = ('0' + (dateActuelle.getMonth() + 1)).slice(-2);
        var jour = ('0' + dateActuelle.getDate()).slice(-2);

        // Formater la date pour l'attribut value de l'input
        var dateAujourdhui = annee + '-' + mois + '-' + jour;

        // Définir la valeur et la propriété max de l'input
        var inputDate = document.getElementById('date');
        var inputDate2 = document.getElementById('date2');
        var inputDate3 = document.getElementById('date3');

        inputDate.min = dateAujourdhui;
        inputDate.value = dateAujourdhui;
        inputDate.max = dateAujourdhui;
        inputDate2.min = dateAujourdhui;
        inputDate2.value = dateAujourdhui;
        inputDate2.max = dateAujourdhui;
        inputDate3.min = dateAujourdhui;
        inputDate3.value = dateAujourdhui;
        inputDate3.max = dateAujourdhui;
    </script>
@endsection
