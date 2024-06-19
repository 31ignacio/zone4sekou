@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="row">
            
            <div class="col-md-8"></div>
            <div class="col-md-2"> <!-- Utilisez une colonne de taille moyenne pour aligner les boutons à gauche -->
            @auth
              @if(auth()->user()->role_id == 1)
                <a href="{{ route('stock.create') }}" class="btn bg-gradient-primary mt-3"><i class="fas fa-sign-in-alt"></i> Entrés de stocks</a><br><br>
            @endif
            @endauth
              </div>
            <div class="col-md-2"> <!-- Utilisez une colonne de taille moyenne pour aligner les boutons à gauche -->
                <a href="{{ route('stock.actuel') }}" class="btn bg-gradient-success mt-3"><i class="fas fa-archive"></i> Stocks actuels</a><br><br>
            </div>
          </div>


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card ">
            <div class="card-header">
              <h1 class="card-title">Sortie de stock(Détail)</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Produits</th>
                  <th>Quantité</th>


                </tr>
                </thead>
                <tbody>
                    @foreach ($factures as $facture)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($facture->date)) }}</td>
                            <td>{{ $facture->produit }}</td>
                            <td>{{ $facture->total_quantite }}</td>
                        </tr>
                    @endforeach


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

  @endsection

