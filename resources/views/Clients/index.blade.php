@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">

 
      <div class="row">
        <div class="col-12">

            {{-- <a href="{{ route ('client.create')}}" class="btn  bg-gradient-primary">Ajouter client</a><br><br> --}}

           
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
          
          <div class="card mt-4">
            <div class="card-header">
              <h3 class="card-title">Mes clients</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Raison sociale</th>
                  <th>Nom</th>
                  <th>Téléphone</th>
                  <th>Ville</th>
                  <th>Transaction</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)

                <tr>
                  <td>{{ $client->raisonSociale }} </td>
                  <td>{{ $client->nom }}</td>
                  <td>{{ $client->telephone }}</td>
                  <td>{{ $client->ville }}</td>

                  <td>
                    <a href="{{ route('client.detail', ['client' => $client->id]) }}" class="btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                    <a class="btn-sm btn-warning" href="{{ route('client.edit', $client->id) }}"><i class="fas fa-edit"></i></a>

                    @auth
                    @if(auth()->user()->role_id == 1)
                   
                    <a class="btn-sm btn-danger" href="{{ route('client.delete', $client->id) }}"><i class="fas fa-trash-alt"></i></a>
                 
                    @endif
                    @endauth
                  </td>
                </tr>
                @empty

                <tr>
                    <td class="cell text-center" colspan="7">Aucun client ajoutés</td>

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

  @endsection
