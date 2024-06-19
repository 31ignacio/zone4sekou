@extends('layouts.master2')

@section('content')


 <!-- Main content -->
 <section class="content">
    <div class="container">

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-3">
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

      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 mt-3">
              @if (Session::get('danger_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ Session::get('danger_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                      </button>
                  </div>
              @endif
          </div>
          <div class="col-md-2"></div>
      </div>

      <div class="row">
        <div class="col-12 mt-4">
          <div class="card">
            <div class="card-header">
              <h4>Etats des ventes </h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form class="settings-form" id="searchForm" method="GET" action="{{ route('etat.index') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-4 col-sm-2">
                        <label for="">Date début</label>
                        <input type="date" class="form-control" name="dateDebut" id="dateDebut" style="border-radius:10px;" placeholder="Date Début">
                    </div>
                    <div class="col-md-4 col-sm-2">
                        <label for="">Date fin</label>
                        <input type="date" class="form-control" name="dateFin" id="dateFin" style="border-radius:10px;" placeholder="Date Fin">
                    </div>
                     
                    <div class="col-md-2 col-sm-2 mt-4" >
                        <button type="submit" class="btn btn-md btn-success mt-2">Recherche</button>
                    </div>
                </div>
            </form>
            
            
            <br>
              
              <table id="example4" class="table table-bordered table-hover">

                <thead>
                 
                <tr>
                  <th>Date</th>
                  <th>Client</th>
                  <th>Servante</th>
                  <th>Caissier</th>
                  <th>Total TTC</th>
                  <th>Action</th>

                </tr>
                </thead>

                <tbody>
                    @forelse ($results as $result)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($result->date)) }}</td>
                        <td>{{$result->client_nom }}</td>
                        <td>{{$result->servante->nom }}</td>
                        <td>{{$result->user->name }}</td>

                        <td>{{$result->montantFinal }}</td>
                        <td>
                          <a href="{{ route('facture.details', ['code' => $result->code, 'date' => $result->date]) }}" class="btn-sm btn-success">Détail</a>

                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td class="cell text-center" colspan="5">Aucun résultat trouvé</td>
    
                    </tr>
                    @endforelse
                    </tbody>
                
                
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

  <!-- /.content -->
@endsection
