{{-- Fichier qui permet de voir les details des rembourssements chez lz client --}}


<div class="card">
    <div class="card-header">

<p hidden>{{$clientId}}</p>


        @php
            $clientInfoDisplayed = false; // Variable de drapeau pour vérifier si les informations du client ont déjà été affichées
        @endphp

        @foreach ($remboursementss as $remboursements)
            <!-- Le reste de votre code pour chaque remboursement -->

            @if (!$clientInfoDisplayed)
                <!-- Affichez le nom et le prénom du client une seule fois -->
                <b>Client : {{ $remboursements->facture->client->nom }}
                    {{ $remboursements->facture->client->prenom }}</b>


                <a href="{{ route('rembourssement.pdf', [$clientId,'remboursement' => $remboursements->facture->id, 'code' => $remboursements->facture->code]) }}"
                    class="btn btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </a>

                @php
                    $clientInfoDisplayed = true; // Marquer que les informations du client ont été affichées
                @endphp
            @endif
        @endforeach


    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>N°Facture</th>
                    <th>Montant</th>
                    <th>Mode paiement</th>

                </tr>
            </thead>
            <tbody>

                @php
                    $totalRemboursement = 0;
                    $totalMontant =0;
            @endphp
                

                @foreach ($remboursementss->sortByDesc('date') as $remboursements)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($remboursements->date)) }}</td>
                        <td>{{ $remboursements->facture->code }}</td>
                        <td>{{ $remboursements->montant }}</td>
                        <td class="badge badge-warning">{{ $remboursements->mode }}</td>
                    </tr>

                    @php
                        $totalRemboursement += $remboursements->montant;
                        
                    @endphp
                @endforeach
                
            
                @php
                $montantPaye=0;
                $totalTTC =0;
                @endphp
        
        
                @foreach ($codesFacturesUniques as $facture)
                @if($facture->mode_id===1)
                        <tr hidden>
                            <td>{{ $facture->montantPaye }}</td>
                            <td>{{ $facture->totalTTC }}</td>
                        </tr>
        
                        @php
                            $totalTTC += $facture->totalTTC;
                            $montantPaye += $facture->montantPaye;
                            
                        @endphp
                @endif
                    @endforeach
        
                <div class="row mt-3">
                    <div class="col-12">
                        <hr>

                        <div class="row">
                            <div class="col-4">
                                <div class="font-weight-bold text-center">Remboursements :</div>
                            </div>
                            <div class="col-4">
                                <div class="font-weight-bold text-center"><span
                                        style="color:green;margin-right:40px">{{ $totalRemboursement }} </span> Sur
                                    <span style="color:red;margin-left:20px;"> {{ $totalTTC - $montantPaye}}
                                        FCFA</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="font-weight-bold text-center">Montant Dû :</div>
                            </div>
                            
                            <div class="col-4">
                                <div class="font-weight-bold text-center">{{ ($totalTTC - $montantPaye) - $totalRemboursement }} FCFA
                                </div>
                            </div>
                        </div>
                        <hr>

                    
                    </div>
                </div>

            </tbody>

        </table>
    </div>
    <!-- /.card-body -->
</div>
