@extends('layouts.master2')

@section('content')

    <section class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mt-3">
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

            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mt-3">
                    @if (Session::get('danger_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('danger_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-md-2"></div>
            </div>


            

            <div class="card table-responsive mt-4">
                <div class="card-header">
                    <h3 class="card-title">Liste des factures en attentes de validation </h3>
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

                                            <a href="{{ route('factureAttente.facture', ['code' => $factureUnique->code, 'servante' => $factureUnique->servante->id]) }}"
                                                class="btn-sm btn-warning"><i class="fas fa-plus"></i></a>

                                            <a href="{{ route('factureAttente.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}"
                                                class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>

                                            <a href="#" class="btn-sm btn-danger" data-toggle="modal"
                                            data-target="#confirmationModal1"
                                            onclick="updateModal1('{{ $factureUnique->code }}')"><i class="fas fa-ban"></i></a>
                                            

                                           
                                                    <a href="#" class="btn-sm btn-success" data-toggle="modal"
                                                        data-target="#confirmationModal"
                                                        onclick="updateModal('{{ $factureUnique->code }}')"><i class="fas fa-check"></i></a>

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
                                        <a href="{{ route('factureAttente.facture', ['code' => $factureUnique->code, 'servante' => $factureUnique->servante->id]) }}"
                                                class="btn-sm btn-warning"><i class="fas fa-plus"></i></a>

                                            <a href="{{ route('factureAttente.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}"
                                                class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>

                                            <a href="#" class="btn-sm btn-danger" data-toggle="modal"
                                            data-target="#confirmationModal1"
                                            onclick="updateModal1('{{ $factureUnique->code }}')"><i class="fas fa-ban"></i></a>
                                            

                                            
                                                    <a href="#" class="btn-sm btn-success" data-toggle="modal"
                                                        data-target="#confirmationModal"
                                                        onclick="updateModal('{{ $factureUnique->code }}')"><i class="fas fa-check"></i></a>

                                              
                                        </td>
                                        
                                    </tr>
                                
                                @else

                                @endif
                            @endforeach
                        </tbody>
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
        <div class="modal fade" id="confirmationModal1" tabindex="-1" role="dialog"
            aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="get" action="{{ route('factureAttente.annuler') }}">
                        @csrf
                        <div class="modal-body">
                            Voulez-vous annuler cette facture ?
                        </div>
                        <input type="hidden" id="factureCode1" name="factureCode">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                            <button type="submit" class="btn btn-danger">Oui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- First Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous valider cette facture ?
            </div>
            <input type="hidden" id="factureCode" name="factureCode">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                <button type="button" class="btn btn-danger" id="confirmYesButton">Oui</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Second Modal -->
    <div class="modal fade" id="montantModal" tabindex="-1" role="dialog" aria-labelledby="montantModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="montantModalLabel">Saisir le montant perçu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="montantForm">
                    @csrf
                    <div class="form-group">
                        <label for="montantPerçu">Montant perçu :</label>
                        <input type="number" class="form-control" id="montantPerçu" name="montantPerçu" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="submitMontantButton">Valider</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Hidden form to submit data -->
    <form id="hiddenForm" method="get" action="{{ route('factureAttente.valider') }}" style="display: none;">

        @csrf
        <input type="hidden" id="hiddenFactureCode" name="factureCode">
        <input type="hidden" id="hiddenMontantPerçu" name="montantPerçu">
    </form>

    <!-- JavaScript to handle modals -->
    <script>
        document.getElementById('confirmYesButton').addEventListener('click', function() {
        // Hide the first modal
        $('#confirmationModal').modal('hide');
        // Show the second modal
        $('#montantModal').modal('show');
        });

        document.getElementById('submitMontantButton').addEventListener('click', function() {
        // Get the value of the montantPerçu input
        const montantPerçu = document.getElementById('montantPerçu').value;
        // Get the facture code (assuming it's set somewhere in your application)
        const factureCode = document.getElementById('factureCode').value;
        
        // Set the hidden form values
        document.getElementById('hiddenFactureCode').value = factureCode;
        document.getElementById('hiddenMontantPerçu').value = montantPerçu;
        
        // Submit the hidden form
        document.getElementById('hiddenForm').submit();
        });
    </script>


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

    <script>
        function updateModal1(code) {
            //alert(code)
            // Mettez à jour le contenu du span avec le code spécifique
            document.getElementById('factureCode1').value = code;
        }
    </script>
@endsection
