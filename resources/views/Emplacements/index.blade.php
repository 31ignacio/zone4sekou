@extends('layouts.master2')

@section('content')


<section class="content">

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label>Ajouter un type </label>
                        <input type="text" class="form-control" placeholder="Enter ..." style="border-radius:10px;" name="emplacement" id="emplacement">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-sm btn-primary" style="margin-top:10px;border-radius:10px;" onclick="emplacement()"><i class="fas fa-plus-circle"></i>Ajouter</button>   

            </div>
        </div>

        <div class="col-md-7 mt-4">
            <div id="msg200"></div>

            @if (Session::get('success_message'))
                <div class="alert alert-success" id="suce">{{ Session::get('success_message') }}</div>
                <script>
                    setTimeout(() => {
                        document.getElementById('suce').remove();
                    }, 3000);
                </script>
            @endif


             <!-- /.card-header -->
             <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Types</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($emplacements as $emplacement )
                    
                    <tr>
                      <td>{{$emplacement->nom}}</td>
                      <td> 
                        <a href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $emplacement->id }}"><i class="fas fa-edit"></i></a>
                        <a href="#"  class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal{{ $emplacement->id }}"><i class="fas fa-trash-alt"></i></a>                 
                    </td>
                                         
                     </tr>

                         <!-- Modal -->
                   <div class="modal fade" id="editModal{{ $emplacement->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="editModalLabel">Modifier le type</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form class="settings-form" method="POST" action="{{ route('emplacement.update', $emplacement->id) }}">
                                    @csrf
                                    @method('PUT')
                
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" style="border-radius:10px;" name="emplacement"
                                                   value="{{$emplacement->nom}}" id="emplacement">
                                            </div>
                                        </div>
                
                                        <button type="submit" class="btn btn-sm btn-primary" style="margin-top:10px;border-radius:10px;"
                                            onclick="emplacement()"><i class="fas fa-plus-circle"></i>Ajouter</button>
                
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                  </div>

                   <!-- Modal pour la confirmation de suppression -->
                   <div class="modal fade" id="confirmationModal{{ $emplacement->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $emplacement->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $emplacement->id }}">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer ce type ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <form method="post" action="{{ route('emplacement.destroy', ['emplacement' => $emplacement->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Oui</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                     @endforeach
                  </tbody>
                </table>
                <br>
                 {{-- LA PAGINATION --}}
                 <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @if ($emplacements->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $emplacements->previousPageUrl() }}" rel="prev" aria-label="Précédent">&laquo; Précédent</a>
                            </li>
                        @endif
                
                        @if ($emplacements->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $emplacements->nextPageUrl() }}" rel="next" aria-label="Suivant">Suivant &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">Suivant &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
                
              </div>
              <!-- /.card-body -->
             
        </div>


    </div>


</section>

<script>
  function emplacement() {
      // $("#remboursementBtn").click(function() {
          // Récupérer l'ID du client depuis la page
          var emplacement = $("#emplacement").val();
              //alert(ref)
          // Récupérer le jeton CSRF depuis la balise meta
          var csrfToken = $('meta[name="csrf-token"]').attr('content');

          // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
          $.ajax({
              type: 'POST',
              url: "{{ route('emplacement.store') }}", // Remplacez "/votre-route" par la route pertinente de votre application
              data: {
                  _token: csrfToken,emplacement
              },
              success: function(response) {
                  // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                  if (parseInt(response) == 200 || parseInt(response) == 500) {

                      parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                      <strong>Une erreur s'est produite</strong> veuillez réessayez.

                      </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                      <strong> Type ajouté avec succès  </strong>

                      </div>`));
                  }

                  var url = "{{ route('emplacement.index') }}"
                  if (response == 200) {
                      setTimeout(function() {
                          window.location = url
                      }, 1000)
                  } else {
                      $("#msg200").html(response);

                  }
              },

          });
      // });
  };
</script>


@endsection
