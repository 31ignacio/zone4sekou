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
              <table id="example1" class="table table-bordered table-striped">
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
                      <a href="{{ route('admin.detail', ['admin' => $admin->id]) }}" class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                
                <a class="btn-sm btn-warning" href="{{ route('admin.edit', $admin->id) }}"><i class="fas fa-edit"></i></a>
                <a class="btn-sm btn-danger" href="{{ route('admin.delete', $admin->id) }}"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
                @empty

                <tr>
                    <td class="cell text-center" colspan="6">Aucun utilisateur ajoutés</td>

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
