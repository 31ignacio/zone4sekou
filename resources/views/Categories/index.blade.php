@extends('layouts.master2')

@section('content')


<section class="content">

    <div class="row">
        <div class="col-md-1"></div>

        <div class="col-md-3 mt-4">
            <div class="form-group">
                <label>Ajouter une famille</label>
                <input type="text" class="form-control" placeholder="Enter ..." required style="border-radius: 10px;" id="categorie" name="categorie" required>
            </div>
        </div>
        <div class="col-md-1 mb-5 mt-5">
            <button type="submit" class="btn btn-sm btn-primary" style="margin-top:8px;" onclick="categorie()"><i class="fas fa-plus-circle"></i>Ajouter</button>   

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-6 mt-4">
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
                      <th>Famille</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $categorie)
                      
                    <tr>
                        <td>{{$categorie->categorie}}</td>
                        <td> 
                            <a href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $categorie->id }}"><i class="fas fa-edit"></i></a>
                            <a href="#"  class="btn-sm btn-danger" data-toggle="modal" data-target="#confirmationModal{{ $categorie->id }}"><i class="fas fa-trash-alt"></i></a>                 
                        </td>
                       
                    </tr>


                    <!-- Modal -->
                   <div class="modal fade" id="editModal{{ $categorie->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="editModalLabel">Modifier la famille</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form class="settings-form" method="POST" action="{{ route('categorie.update',$categorie->id) }}">
                                    @csrf
                                    @method('PUT')
                            
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" style="border-radius: 10px;" id="categorie" name="categorie" value="{{$categorie->categorie}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-5 mt-4">
                                        <button type="submit" class="btn btn-sm btn-warning" style="margin-top:8px;"><i class="fas fa-plus-circle"></i>Editer</button>   
                        
                                    </div>
                        
                                    <div class="col-md-3"></div>
                                </form>
                            </div>

                        </div>
                    </div>
                  </div>

                   <!-- Modal pour la confirmation de suppression -->
                   <div class="modal fade" id="confirmationModal{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $categorie->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $categorie->id }}">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette famille ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <form method="post" action="{{ route('categorie.destroy', ['categorie' => $categorie->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Oui</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- Fin Modal pour la confirmation de suppression -->
                
                     @endforeach

                  </tbody>
                </table>


                <br>
                 {{-- LA PAGINATION --}}
                 <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev" aria-label="Précédent">&laquo; Précédent</a>
                            </li>
                        @endif
                
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next" aria-label="Suivant">Suivant &raquo;</a>
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
  function categorie() {
      // $("#remboursementBtn").click(function() {
          // Récupérer l'ID du client depuis la page
          var categorie = $("#categorie").val();
              //alert(ref)
          // Récupérer le jeton CSRF depuis la balise meta
          var csrfToken = $('meta[name="csrf-token"]').attr('content');

          // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
          $.ajax({
              type: 'POST',
              url: "{{ route('categorie.store') }}", // Remplacez "/votre-route" par la route pertinente de votre application
              data: {
                  _token: csrfToken,categorie
              },
              success: function(response) {
                  // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                  if (parseInt(response) == 200 || parseInt(response) == 500) {

                      parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                      <strong>Une erreur s'est produite</strong> veuillez réessayez.

                      </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                      <strong> Famille  ajoutée avec succès  </strong>

                      </div>`));
                  }

                  var url = "{{ route('categorie.index') }}"
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
