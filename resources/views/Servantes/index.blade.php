@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">

 
      <div class="row">
        <div class="col-12">

            <a href="#" data-toggle="modal" data-target="#ajouterServanteModal" class="btn bg-gradient-primary mb-3 mt-3">Ajouter</a>

           
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
              {{-- <h3 class="card-title">Liste des clients</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nom & prénom</th>
                  <th>Téléphone</th>
                  <th>Date de prise de service</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($servantes as $servante)

                <tr>
                  <td>{{ $servante->nom }} </td>
                  <td>{{ $servante->telephone }}</td>
                  <td>{{ date('d/m/Y', strtotime($servante->date)) }}</td>

                  <td>
                    <a href="{{ route('servante.detail', ['servante' => $servante->id]) }}" class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                    <a href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $servante->id }}"><i class="fas fa-edit"></i></a>
                    <a href="#"  class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal{{ $servante->id }}"><i class="fas fa-trash-alt"></i></a>                 
                  </td>
                </tr>
                <!-- edit.blade.php -->
                   <!-- Modal -->
                   <div class="modal fade" id="editModal{{ $servante->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="editModalLabel">Modifier la servante</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form action="{{ route('servante.update', ['servante' => $servante->id]) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label for="nom">Nom & Prénom :</label>
                                          <input type="text" class="form-control" id="nom" name="nom" value="{{ $servante->nom }}" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="telephone">Téléphone :</label>
                                          <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $servante->telephone }}" required>
                                      </div>
                                      <div class="form-group">
                                          <label for="date">Date de prise de service :</label>
                                          <input type="date" class="form-control" id="date" name="date" value="{{ $servante->date }}" required>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                                  </div>
                              </form>
                            </div>

                        </div>
                    </div>
                  </div>

                   <!-- Modal pour la confirmation de suppression -->
                   <div class="modal fade" id="confirmationModal{{ $servante->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $servante->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $servante->id }}">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette servante ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <form method="post" action="{{ route('servante.destroy', ['servante' => $servante->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Oui</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- Fin Modal pour la confirmation de suppression -->
                
                @empty

                <tr>
                    <td class="cell text-center" colspan="7">Aucune servante ajoutés</td>

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
    {{-- Modal pour ajouter une servante --}}

    <div class="modal fade" id="ajouterServanteModal" tabindex="-1" role="dialog" aria-labelledby="ajouterServanteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ajouterServanteModalLabel">Ajouter une servante</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('servante.store') }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="nom">Nom</label>
                  <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                  <label for="prenom">Prénom</label>
                  <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                  <label for="telephone">Téléphone</label>
                  <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <div class="form-group">
                  <label for="date">Date de prise de service</label>
                  <input type="date" class="form-control" id="date" name="date" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      

  </section>

  @endsection
