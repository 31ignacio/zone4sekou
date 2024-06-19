@extends('layouts.master2')

@section('content')
<style>
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
</style>
     <span id="client-id" hidden>{{$client}}</span> 
     
    <section class="content">
        <div class="container-fluid">
            
            <div class="row ">
                <div class="col-12 mt-4">

                    
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
                                <span class="info-box-icon text-white"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total des achats</span>
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $totalTTCClient_format = number_format($totalTTCClient, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{$totalTTCClient_format}} FCFA</span>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="col-md-3" style="margin-top: 35px;">
                            

                        </div>
                        {{-- <div class="col-md-3" style="margin-top: 35px;">
                            <button type="button" onclick="detailRembourssements(event)" class="btn-sm btn-primary voir">Détails rembourssement</button> 
    
                        </div> --}}
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Facture client</h3>
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
                                        @if(auth()->user()->role_id === 1)
                                      
                                        <th>Caissier</th>
                                        @endif
                                        @endauth
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($codesFacturesUniques as $client)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($client->date)) }}</td>
                                            <td>{{ $client->montantFinal }}</td>
                                            <td>{{ $client->montantPaye }}</td>
                                            <td><b>{{ $client->montantPaye - $client->montantFinal}}</b></td>

                                            @auth
                                            @if(auth()->user()->role_id === 1)
                                          
                                            <td><b>{{ $client->user->name}}</b></td>
                                            @endif
                                            @endauth

                                           
                                            <td>
                                                <a href="{{ route('facture.details', ['code' => $client->code, 'date' => $client->date]) }}" class="btn-sm btn-success">Détail</a>
                                                
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
