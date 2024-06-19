@extends('layouts.master2')

@section('content')

    <section class="content">
        <div class="container">

            <!--<div class="row">-->
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

                    <div class="card-body">
                        <form class="settings-form" id="searchForm" method="GET" action="{{ route('vendu.index') }}">
                          @csrf
                          
                          <div class="row">
                              <div class="col-md-3 col-sm-2">
                                  <label for="">Date début</label>
                                  <input type="date" class="form-control" name="dateDebut" id="dateDebut">
                              </div>
                              <div class="col-md-3 col-sm-2">
                                  <label for="">Date fin</label>
                                  <input type="date" class="form-control" name="dateFin" id="dateFin">
                              </div>

                            <div class="col-md-4 col-sm-2">
                                <label for="">Produit</label>

                                <select class="form-control select2" id="produit" name="produit">
                                    <option></option>
                                
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->libelle }}">{{ $produit->libelle }} </option>
                                    @endforeach
                                
                                </select>
                            </div>

                              <div class="col-md-2 col-sm-2 mt-4" >
                                <button type="submit" class="btn btn-md btn-success mt-2">Recherche</button>
                            </div>
                          </div>
                        </form>
                    </div>

                    <div class="card table-responsive mt-2">
                        <div class="card-header">
                            <h2 class="card-title">Liste des produits vendus <b></b></h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body col-md-12">

                            @if($factures->isNotEmpty())
                            <table id="example4" class="table table-bordered mt-4">
                                
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Date</th>
                                        <th>Total Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factures as $facture)
                                        <tr>
                                            <td>{{ $facture->produit }}</td>
                                             <td>{{ date('d/m/Y', strtotime($facture->date)) }}</td>
                                            <td> <span class="badge bg-info">{{ $facture->total_quantite }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">Aucun produit trouvé pour la période sélectionnée.</p>
                        @endif
                

                                <br>
                                {{-- LA PAGINATION --}}
                                {{-- <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        @if ($factures->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $factures->previousPageUrl() }}"
                                                    rel="prev" aria-label="Précédent">&laquo; Précédent</a>
                                            </li>
                                        @endif

                                        @if ($factures->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $factures->nextPageUrl() }}"
                                                    rel="next" aria-label="Suivant">Suivant &raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">Suivant &raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav> --}}
                        </div>
                            <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.col -->
            <!--</div>-->
                <!-- /.row -->
        </div>
            <!-- /.container-fluid -->

       

    </section>

@endsection
