@extends('layouts.master2')

@section('content')

    <span id="client-id" hidden>{{$servante}}</span> 
     
    <section class="content">
        <div class="container-fluid">
            
            <div class="row">
                
                <div class="col-12 mt-3">  
                    <div id="msg200"></div>

                    @if (Session::get('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                        <script>
                            setTimeout(() => {
                                document.getElementById('success-message').remove();
                            }, 3000);
                        </script>
                    @endif
                    @if (Session::get('danger_message'))
                    <div class="alert alert-danger">{{ Session::get('danger_message') }}</div>
                    <script>
                        setTimeout(() => {
                            document.getElementById('success-danger_message').remove();
                        }, 3000);
                    </script>
                @endif

                    <div class="row">
                        <div class="col-md-3 mt-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Point d'hier</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalHier_format = number_format($sommeMontantFinalHier, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$sommeMontantFinalHier_format}} FCFA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Point de la journée</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalAujourdhui_format = number_format($sommeMontantFinalAujourdhui, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$sommeMontantFinalAujourdhui_format}} FCFA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="far fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mois actuel</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalMoisActuel_format = number_format($sommeMontantFinalMoisActuel, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$sommeMontantFinalMoisActuel_format}} FCFA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Chiffres d'affaires global</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalTousMois_format = number_format($sommeMontantFinalTousMois, 0, ',', '.');
                                    ?>

                                    <span class="info-box-number" style="max-width: 150px; word-wrap: break-word;">
                                        {{$sommeMontantFinalTousMois_format}} FCFA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <h4 class="mt-4 mb-4"><b style="color: #4CAF50">Les boissons vendus cette semaine :</b></h4>
                        <div class="row">
                            @foreach($trois_produits_sup_semaine as $code => $quantite)
                                <div class="col-md-4 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"> <i class="fas fa-wine-bottle"></i> {{ $code }}</h5>
                                            <p class="card-text">
                                                <span class="badge bg-success mt-3"> <span style="font-size: 20px;"> {{ $quantite }}</span></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <button class="btn  btn-success" id="voir-details">
                                    <i class="fas fa-plus-circle"></i> <!-- Icône de graphique -->
                                    voir la liste
                                </button>

                            </div>  
                            <div class="col-md-6"></div> 
                            <div class="col-md-4 badge bg-danger">
                                <h3>Montant dû</h3>
                                <hr>
                                <?php
                                    // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                    $sumMontantRendu_format = number_format($sumMontantRendu, 0, ',', '.');
                                ?>
                                <span style="font-size:25px;">
                                    {{$sumMontantRendu_format}} FCFA
                                </span>
                            </div>
                        
                        </div>
                        
                        
                        
                    </div>
                    
                    <script>
                        document.getElementById('voir-details').addEventListener('click', function() {
                            document.getElementById('autres-produits').style.display = 'block';
                            this.style.display = 'none';
                        });
                    </script>
                    
                    
                    
                    

                    
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Les ventes de la servante : <b>{{ $servantes->nom }}</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th id="montant">Total TTC</th>
                                        <th>Montant Perçu</th>
                                        <th>Reliquat</th>
                                        @auth
                                        @if(auth()->user()->role_id == 1)
                                      
                                        <th>Caissier</th>
                                        @endif
                                        @endauth
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($codesFacturesUniques as $servante)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($servante->date)) }}</td>
                                            <td>{{ $servante->montantFinal }}</td>
                                            <td>{{ $servante->montantPaye }}</td>
                                            <td><b>{{ $servante->montantPaye - $servante->montantFinal}}</b></td>

                                            @auth
                                            @if(auth()->user()->role_id == 1)
                                          
                                            <td><b>{{ $servante->user->name}}</b></td>
                                            @endif
                                            @endauth

                                           
                                            <td>
                                                <a href="{{ route('facture.details', ['code' => $servante->code, 'date' => $servante->date]) }}" class="btn-sm btn-success">Détail</a>
                                                @if(($servante->montantPaye - $servante->montantFinal) < 0)
                                                    <a href="#" class="btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#confirmationModal"
                                                    onclick="updateModal('{{ $servante->code }}')">Reglé</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="6">Aucune opération éffectuée</td>

                                        </tr>
                                    @endforelse


                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-produits-semaine-passee" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"><b>Les boissons vendus cette semaine:</b></h5>
                    </div>
                    <div class="modal-body">
                        <!-- Contenu du modal (liste des produits les plus vendus la semaine passée) -->

                        @foreach($quantites_par_code_semaine_actuelle as $code => $quantite)
                            <div class="col-md-10 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"> <i class="fas fa-wine-bottle"></i> {{ $code }}</h5>
                                        <p class="card-text">
                                            <span class="badge bg-success mt-3"> <span style="font-size: 20px;"> {{ $quantite }}</span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- Insérez ici le contenu du modal avec les produits les plus vendus la semaine passée --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Écouteur d'événement pour le clic sur le bouton "Les produits les plus vendus la semaine passée"
            document.getElementById('voir-details').addEventListener('click', function() {
                // Afficher le modal
                var modal = new bootstrap.Modal(document.getElementById('modal-produits-semaine-passee'));
                modal.show();
            });
        </script>
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
               <form method="get" action="{{ route('facture.reglement') }}">
                   @csrf
                   <div class="modal-body">

                    <label for="">Reglement</label>
                    <input type="text" class="form-control" name="reglement" id="reglement" required>
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
