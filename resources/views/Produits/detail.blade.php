@extends('layouts.master2')



@section('content')

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-1"></div>

                <div class="col-md-10 mt-4">

                @foreach ($produits as $produit)

                    @if($produit->produitType_id ==1)
                        
                        <a href="{{ route('produit.index') }}" class="btn  bg-gradient-primary"><i class="fas fa-arrow-left"></i></a><br><br>

                    @else
                        <a href="{{ route('produit.index') }}" class="btn  bg-gradient-primary"><i class="fas fa-arrow-left"></i></a><br><br>

                    @endif

                @endforeach



                    <div class="card col-sm-12 col-md-12">

                        <div class="card-header">

                            <h3 class="card-title">Détail d'un produits</h3>

                        </div>

                        <!-- /.card-header -->

                                <div class="card-body table-responsive">

                                    <table  class="table table-bordered table-striped">

                                    

                                        <tbody>

                                            @foreach ($produits as $produit)

                                                <tr>

                                                    <th>Code</th>

                                                    <td>{{ $produit->code }}</td>

                                                </tr>

                                                <tr>

                                                    <th>Produit</th>

                                                    <td>{{ $produit->libelle }}</td>

                                                </tr>
                                                <tr>

                                                    <th>Prix d'achat</th>

                                                    <td>{{ $produit->prixA }}</td>

                                                </tr>

                                                <tr>

                                                    <th>Prix de vente</th>

                                                    <td>{{ $produit->prix }}</td>

                                                </tr>

                                                <tr>

                                                    <th>Produit type</th>

                                                    <td>{{ $produit->produitType->produitType }}</td>

                                                </tr>

                                                {{-- <tr>

                                                    <th>Quantités</th>

                                                    <td>{{ $produit->quantite }}</td>

                                                </tr> --}}

                                                <tr>

                                                    <th>Types</th>

                                                    <td>{{ $produit->emplacement->nom }}</td>

                                                </tr>

                                                <tr>

                                                    <th>Familles</th>

                                                    <td>{{ $produit->categorie->categorie }}</td>

                                                </tr>

                                                

                                                <tr>

                                                    <th>Date reception</th>

                                                    <td>{{ date('d/m/Y', strtotime($produit->dateReception)) }}</td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>
                    </div>

                    <!-- /.card -->

                </div>

                <div class="col-md-1"></div>

                <!-- /.col -->

            </div>

            <!-- /.row -->

        </div>

        <!-- /.container-fluid -->

    </section>



    <script>

        // Recherche de l'élément de message de succès

        var successMessage = document.getElementById('success-message');



        // Masquer le message de succès après 3 secondes (3000 millisecondes)

        if (successMessage) {

            setTimeout(function() {

                successMessage.style.display = 'none';

            }, 3000);

        }

    </script>

@endsection

