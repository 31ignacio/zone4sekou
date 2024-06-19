@extends('layouts.master2')

@section('content')

    <section class="content">
        <div class="container">
            <a href="{{ route ('facture.point')}}" class="btn bg-gradient-success mt-4">Point de la journée</a><br><br>

            <!--<div class="row">-->
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


                    <div class="card table-responsive">
                        <div class="card-header">
                            <h3 class="card-title">Liste des factures</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body col-md-12">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Total TTC</th>
                                        <th>Montant Perçu</th>
                                        <th>Reliquat</th>
                                        <th>Servantes</th>

                                        @auth
                                            @if (auth()->user()->role_id == 1)

                                                <th>Caissier</th>
                                            @endif
                                        @endauth
                                        <th>Actions</th>

                                        <!-- Autres colonnes -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($codesFacturesUniques as $factureUnique)
                                        @if ($role==1)                                            
                                                    <tr>
                                                        @if ($factureUnique->client == null)
                                                            <td>Client</td>
                                                        @else
                                                            <td>{{ $factureUnique->client_nom }}</td>
                                                        @endif

                                                        <td>{{ date('d/m/Y', strtotime($factureUnique->date)) }}</td>
                                                        <td>{{ $factureUnique->montantFinal }}</td>
                                                        <td>{{ $factureUnique->montantPaye }}</td>
                                                        <td><span
                                                                class="right badge badge-info"><b>{{ $factureUnique->montantPaye - $factureUnique->montantFinal }}</b></span>
                                                        </td>
                                                       
                                                        <td><b>{{ $factureUnique->servante->nom}}</b></td>


                                                        @auth
                                                            @if (auth()->user()->role_id == 1)

                                                                <td><b>{{ $factureUnique->user->name }}</b></td>

                                                            @endif
                                                        @endauth
                                                        <td>
                                                            <a href="{{ route('facture.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}"
                                                                class="btn-sm btn-primary">Détail</a>

                                                            @auth
                                                                @if (auth()->user()->role_id == 1)

                                                                    <a href="#" class="btn-sm btn-danger" data-toggle="modal"
                                                                        data-target="#confirmationModal"
                                                                        onclick="updateModal('{{ $factureUnique->code }}')">Annuler</a>

                                                                @endif
                                                            @endauth
                                                        </td>
                                                    </tr>
                                            
                                        @elseif($nom == $factureUnique->user->name)

                                                    <tr>
                                                        @if ($factureUnique->client == null)
                                                            <td>Client</td>
                                                        @else
                                                            <td>{{ $factureUnique->client_nom }}</td>
                                                        @endif

                                                        <td>{{ date('d/m/Y', strtotime($factureUnique->date)) }}</td>
                                                        <td>{{ $factureUnique->montantFinal }}</td>
                                                        <td>{{ $factureUnique->montantPaye }}</td>
                                                        <td><span
                                                                class="right badge badge-info"><b>{{ $factureUnique->montantPaye - $factureUnique->montantFinal }}</b></span>
                                                        </td>
                                                       
                                                        <td><b>{{ $factureUnique->servante->nom}}</b></td>


                                                        @auth
                                                            @if (auth()->user()->role_id == 1)

                                                                <td><b>{{ $factureUnique->user->name }}</b></td>

                                                            @endif
                                                        @endauth
                                                        <td>
                                                            <div class="d-flex flex-column flex-sm-row"> <!-- Utiliser la classe flexbox -->
                                                                <a href="{{ route('facture.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}"
                                                                    class="btn-sm btn-primary mb-2 mb-sm-0 mr-sm-2">Détail</a> <!-- Ajouter des marges et des classes de grille -->
                                                        
                                                                @auth
                                                                    @if (auth()->user()->role_id === 1)
                                                                        <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal"
                                                                            onclick="updateModal('{{ $factureUnique->code }}')">Annuler</a>
                                                                    @endif
                                                                @endauth
                                                            </div>
                                                        </td>
                                                        
                                                    </tr>
                                        
                                        @else

                                        @endif
                                    @endforeach
                            </table>

                                <br>
                                {{-- LA PAGINATION --}}
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        @if ($codesFacturesUniques->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $codesFacturesUniques->previousPageUrl() }}"
                                                    rel="prev" aria-label="Précédent">&laquo; Précédent</a>
                                            </li>
                                        @endif

                                        @if ($codesFacturesUniques->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $codesFacturesUniques->nextPageUrl() }}"
                                                    rel="next" aria-label="Suivant">Suivant &raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">Suivant &raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                        </div>
                            <!-- /.card-body -->
                    </div>
                   
        </div>
            <!-- /.container-fluid -->

        {{-- Modal pour annuler une facture --}}
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="get" action="{{ route('facture.annuler') }}">
                        @csrf
                        <div class="modal-body">
                            Voulez-vous annuler cette facture ?
                        </div>
                        <input type="hidden" id="factureCode" name="factureCode">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                            <button type="submit" class="btn btn-danger">Oui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function updateModal(code) {
                //alert(code)
                // Mettez à jour le contenu du span avec le code spécifique
                document.getElementById('factureCode').value = code;
            }
        </script>
    @endsection
