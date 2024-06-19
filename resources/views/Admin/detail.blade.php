@extends('layouts.master2')

@section('content')
{{-- <style>
    #achats {
       border-radius: 10px;
        background-color: #4CAF50; /* Couleur de fond vert plus pur */
        color: white; /* Couleur du texte en blanc */
    }

    #dettes{
         border-radius: 10px;
        background-color: red; /* Couleur de fond vert plus pur */
        color: white; /* Couleur du texte en blanc */
    }
</style> --}}
     <span id="client-id" hidden>{{$admin}}</span> 
     
    <section class="content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12">

                    
                    <div id="msg200"></div>

                    @if (Session::get('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                        <script>
                            setTimeout(() => {
                                document.getElementById('success-message').remove();
                            }, 3000);
                        </script>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Dépense journalière</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $somme_depenses_aujourdhui_format = number_format($somme_depenses_aujourdhui, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$somme_depenses_aujourdhui_format}} FCFA</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Solde final journalier</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $solde_final_journalier_format = number_format($solde_final_journalier, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$solde_final_journalier_format}} FCFA</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Dépense mensuel</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $somme_depenses_mois_actuel_format = number_format($somme_depenses_mois_actuel, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$somme_depenses_mois_actuel_format}} FCFA</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Solde final mensuel</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $solde_final_mois_actuel_format = number_format($solde_final_mois_actuel, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$solde_final_mois_actuel_format}} FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Les ventes du caissier : <b>{{ $admins->name }}</b></h3>
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
                                      
                                        <th>Servante</th>
                                        @endif
                                        @endauth
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($codesFacturesUniques as $admin)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($admin->date)) }}</td>
                                            <td>{{ $admin->montantFinal }}</td>
                                            <td>{{ $admin->montantPaye }}</td>
                                            <td><b>{{ $admin->montantPaye - $admin->montantFinal}}</b></td>
                                            <td><b>{{ $admin->servante->nom}}</b></td>
                                            <td>
                                                <a href="{{ route('facture.details', ['code' => $admin->code, 'date' => $admin->date]) }}" class="btn-sm btn-success">Détail</a>      
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
        <!-- /.container-fluid -->
    </section>


   
    {{-- Pour faire la somme des achats --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalAchats = 0;
            let montants = document.querySelectorAll('#example1 tbody tr .montant');

            montants.forEach(function(montant) {
                totalAchats += parseFloat(montant.textContent.replace(/\s/g, '').replace(/,/g, '.'));
            });

            const formattedTotal = totalAchats.toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
            });

            document.getElementById('achats').value = formattedTotal;
        });
    </script>
        
@endsection
