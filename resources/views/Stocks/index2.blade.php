@extends('layouts.master2')

@section('content')
    
        <div class="container">

            <div class="card mt-4">

                <div class="card-header">

                    <h1 class="card-title">Liste des produits transférés</h1>

                </div>

                <!-- /.card-header -->

                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>Transféré le</th>
                                <th>Quantité</th>
                                <th>Produits</th>
                                <th>Auteur</th>
                                <th>Vers le bar</th>
                            </tr>

                        </thead>

                        <tbody>

                          <!-- Utilisez $produitLibelle et $produitQuantite comme vous le souhaitez dans cette vue -->

                          @foreach ($transferts as $transfert)

                              <tr>
                                <td>{{ date('d/m/Y', strtotime($transfert->date)) }}</td>

                                  <td> {{ $transfert->quanite }}</td>
                                  <td>{{ $transfert->produit }}</td>

                                  <td> {{ $transfert->user->name }}</td>
                                  <td> {{ $transfert->bar }}</td>

                                 
                              </tr>

                          @endforeach

                      </tbody>

                    </table>

                </div>

                <!-- /.card-body -->

            </div>



        </div>

@endsection
