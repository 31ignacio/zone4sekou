@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mt-4">

            <a href="{{ route ('produit.create')}}" class="btn  bg-gradient-success">Ajouter</a><br><br>

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
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des produits</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code</th>
                  <th>Désignation</th>
                   <th>Types</th>
                  <th>Prix de vente</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($produits as $produit)

                <tr>
                  <td>{{ $produit->code }}</td>
                  <td>{{ $produit->libelle }}</td>
                  <td>
                    @if( $produit->produitType_id == 1)
                              
                    <span class="badge badge-success">Détails</span>

                    @else
                          <span class="badge badge-primary">Gros</span>
                    @endif
                  
                  </td>
                  <td>{{ $produit->prix}}</td>

                  <td>
                    <a class="btn-sm btn-info" href="{{ route('produit.detail', $produit->id) }}"><i class="fas fa-eye"></i></a>

                    <a class="btn-sm btn-warning" href="{{ route('produit.edit', $produit->id) }}"><i class="fas fa-edit"></i></a>

                    {{-- <a class="btn-sm btn-danger" href="{{ route('produit.delete', $produit->id) }}"><i class="fas fa-trash-alt"></i></a> --}}
                    <a href="#"  class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal{{ $produit->id }}"><i class="fas fa-trash-alt"></i></a>                 

                  
                  </td>
                </tr>

                <!-- Modal pour la confirmation de suppression -->
                <div class="modal fade" id="confirmationModal{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $produit->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="confirmationModalLabel{{ $produit->id }}">Confirmation</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              Êtes-vous sûr de vouloir supprimer ce produit ?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                              <form method="post" action="{{ route('produit.destroy', ['produit' => $produit->id]) }}">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">Oui</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
                @empty

                <tr>
                    <td class="cell" colspan="3">Aucun produit ajoutés</td>

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
