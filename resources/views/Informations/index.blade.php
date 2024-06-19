@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mt-4">

            <a href="{{ route ('information.create')}}" class="btn  bg-gradient-primary">Ajouter</a><br><br>

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
              <h3 class="card-title">Informations du bar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nom</th>
                  <th>Adresse</th>
                  <th>Téléphone</th>
                  <th>IFU</th>
                  <th>Modifier</th>

                </tr>
                </thead>
                <tbody>

                <tr>
                  <td>{{ $info->nom }}</td>
                  <td>{{ $info->adresse }}</td>
                  <td>{{ $info->telephone }}</td>
                  <td>{{ $info->ifu }}</td>
                  <td>  
                      <a class="btn-sm btn-warning" href="{{ route('information.edit', $info->id) }}"><i class="fas fa-edit"></i></a>
                  </td>
                </tr>
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
