@extends('layouts.master2')



@section('content')

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">



                    {{-- Message de succès --}}

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

                    <div class="col-md-2"> <!-- Utilisez une colonne de taille moyenne pour aligner les boutons à gauche -->
                        <a href="{{ route('stock.index2') }}" class="btn bg-gradient-success mt-3"><i class="fas fa-sign-in-alt"></i> Voir liste des produits transférés</a><br>
                    </div>

                    <div class="card mt-4">

                        <div class="card-header">

                            <h1 class="card-title">Stocks actuels(Gros)</h1>

                        </div>

                        <!-- /.card-header -->

                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>Produits</th>

                                        <th>Quantité</th>

                                        <th>Tranferer</th>

                                    </tr>

                                </thead>

                                <tbody>

                                  <!-- Utilisez $produitLibelle et $produitQuantite comme vous le souhaitez dans cette vue -->

                                  @foreach ($produits as $produit)

                                      <tr>

                                          <td>{{ $produit->libelle }}</td>

                                          <td>

                                              {{ $produit->stock_actuel }}

                                              @if ($produit->stock_actuel <= 2)

                                                  <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

                                                  <script>

                                                      setInterval(function() {

                                                          Toastify({

                                                              text: "Le stock de {{ $produit->libelle }} est faible.",

                                                              duration: 15000,

                                                              close: true,

                                                              gravity: "top",

                                                              backgroundColor: "#b30000",

                                                          }).showToast();

                                                      }, 43200000);

                                                  </script>

                                              @endif

                                          </td>

                                          <td>

                                            <form action="{{ route('stock.tranferer') }}" method="get">

                                                @csrf

                                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                                                <input type="hidden" name="produit_libelle" value="{{ $produit->libelle }}">

                                                <input type="hidden" name="produit_quantite" value="{{ $produit->stock_actuel }}">

                                                <button type="submit" class="btn btn-sm btn-success">

                                                    <i class="fas fa-exchange-alt"></i>

                                                </button>

                                            </form>

                                        </td>

                                      </tr>

                                  @endforeach

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





        <div class="modal fade" id="modal-success">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title">Enregistrer un reglement</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form method="post" action="">

                            @csrf

                            <div class="form-group">

                                <label for="recette">Montant du reglement :</label>

                                <input type="number" class="form-control" name="montant" id="montant" required

                                    placeholder="Montant" />

                            </div>

                            <div class="form-group">

                                <label for="date">Date :</label>

                                <input type="date" class="form-control" name="date" id="date" required />

                            </div>



                            <input type="hidden" class="form-control" name="status" id="status" value="Reglement"

                                required />



                            <div class="modal-footer justify-content-between">

                                <button type="submit" class="btn btn-primary">Enregistrer</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <script>

        // Recherche de l'élément de message de succès

        var successMessage = document.getElementById('success-message');



        // Masquer le message de succès après 3 secondes (3000 millisecondes)

        if (successMessage) {

            setTimeout(function() {

                successMessage.style.display = 'none';

            }, 3000);

        }

    </script>

@endsection

