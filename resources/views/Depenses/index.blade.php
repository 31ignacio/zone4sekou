@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 mt-4">
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
            <div class="col-md-3 mt-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon text-white"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Dépense mensuel</span>
                        <?php
                            // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                            $somme_depenses_mois_format = number_format($somme_depenses_mois, 0, ',', '.');
                        ?>
                        <span class="info-box-number">{{$somme_depenses_mois_format}} FCFA</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon text-white"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Resultats nette quotidien</span>
                        <?php
                            // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                            $recetteDepense_format = number_format($recetteDepense, 0, ',', '.');
                        ?>
                        <span class="info-box-number">{{$recetteDepense_format}} FCFA</span>
                    </div>
                </div>
            </div>
        </div>  
        

 
      <div class="row">
        <div class="col-12">

            <a href="#" data-toggle="modal" data-target="#ajouterServanteModal" class="btn bg-gradient-success mb-3 mt-3">Ajouter</a>

           
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
                  <th>Montant</th>
                  <th>Date</th>
                  <th>Libelle</th>
                  <th>Caissier</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($depenses as $depense)

                <tr>
                  <td>{{ $depense->depense }} </td>
                  <td>{{ date('d/m/Y', strtotime($depense->date)) }}</td>
                  <td>{{ $depense->libelle }}</td>
                  <td>{{ $depense->user->name }}</td>
                  <td>
                    <a href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $depense->id }}"><i class="fas fa-edit"></i></a>
                    <a href="#"  class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal{{ $depense->id }}"><i class="fas fa-trash-alt"></i></a>                 
                  </td>
                </tr>
                <!-- edit.blade.php -->
                   <!-- Modal -->
                   <div class="modal fade" id="editModal{{ $depense->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="editModalLabel">Modifier la depense</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form action="{{ route('depense.update', ['depense' => $depense->id]) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label for="depense">Montant:</label>
                                          <input type="text" class="form-control" id="depense" name="depense" value="{{ $depense->depense }}" required>
                                      </div>

                                      <div class="form-group">
                                        <label for="libelle">Libelle:</label>
                                        <input type="text" class="form-control" id="libelle" name="libelle" value="{{ $depense->libelle }}" required>
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
                   <div class="modal fade" id="confirmationModal{{ $depense->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $depense->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $depense->id }}">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette depense ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <form method="post" action="{{ route('depense.destroy', ['depense' => $depense->id]) }}">
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
                    <td class="cell text-center" colspan="7">Aucune depense ajoutés</td>

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
    {{-- Modal pour ajouter une depense --}}

    <div class="modal fade" id="ajouterServanteModal" tabindex="-1" role="dialog" aria-labelledby="ajouterServanteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ajouterServanteModalLabel">Ajouter une depense</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('depense.store') }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="nom">Montant</label>
                  <input type="number" min="0" class="form-control" id="depense" name="depense" required>
                </div>

                <div class="form-group">
                  <label for="libelle">Libelle</label>
                  <input type="text" class="form-control" id="libelle" name="libelle" required>
                </div>
                
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" id="date" name="date" required readonly>
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

    {{-- Control sur la date --}}
    <script>
      // Récupérer la date d'aujourd'hui
      var dateActuelle = new Date();
  
      // Si l'heure actuelle est avant 10h, décrémentez d'un jour
      if (dateActuelle.getHours() < 10) {
          dateActuelle.setDate(dateActuelle.getDate() - 1);
      }
  
      var annee = dateActuelle.getFullYear();
      var mois = ('0' + (dateActuelle.getMonth() + 1)).slice(-2);
      var jour = ('0' + dateActuelle.getDate()).slice(-2);
  
      // Formater la date pour l'attribut value de l'input
      var dateAujourdhui = annee + '-' + mois + '-' + jour;
  
      // Définir la valeur et la propriété max de l'input
      var inputDate = document.getElementById('date');
      inputDate.min = dateAujourdhui;
      inputDate.value = dateAujourdhui;
      inputDate.max = dateAujourdhui;
  </script>
  @endsection
