@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            {{-- <a href="{{ route ('admin.create')}}" class="btn  bg-gradient-primary"><i class="fas fa-user-plus"></i>Ajouter</a><br><br> --}}


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
          
            <div class="msg20"></div>

          <div class="card">
            <div class="card-header">
              {{-- <h3 class="card-title">Liste des administrateurs</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nom</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Rôle</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)

                <tr>
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>{{ $admin->telephone }}</td>
                  <td>
                      @if($admin->role_id == 1)
                              
                              <span class="badge badge-success">ADMIN</span>

                              @elseif($admin->role_id == 3)
                      <span class="badge badge-warning">SUPERVISEUR</span>


                        @else
                              <span class="badge badge-primary">CAISSE</span>
                        @endif
                        </td>

                   <td>
                    <button type="button" class="btn-sm btn-success" title="Activer" data-toggle="modal" data-target="#myModal" onclick="updateModalContent({{ $admin->id }})">
                        <i class="fas fa-user-check"></i>
                  </button>  
                  <!-- Modal de confirmation -->
                  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmation d'activation </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('admin.active')}}" method="post">
                            @csrf
                            
                            
                            <div class="modal-body">
                                Voulez-vous vraiment activer cet utilisateur ?  
                                <input type="text" id="userIdInput" name="userId" class="form-control" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Confirmer</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
                  </td>
                </tr>


                
                @empty

                <tr>
                    <td class="cell text-center" colspan="6">Aucun administrateurs ajoutés</td>

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
    function updateModalContent(userId) {
        // Mettez à jour le contenu du span avec l'ID de l'utilisateur
        document.getElementById('userIdInput').value = userId;
    }
</script>
  @endsection
