@extends('layouts.master2')

@section('content')
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

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Edition des factures </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body col-md-12">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                                <tr>
                                    <td>{{ $facture->produit }}</td>
                                    <td>{{ $facture->quantite }}</td>
                                    <td>
                                        <a href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $facture->id }}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>

                                <!-- edit.blade.php -->
                   <!-- Modal -->
                   <div class="modal fade" id="editModal{{ $facture->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="editModalLabel">Modifier la facture</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Inside the modal body -->
                            <div class="modal-body">
                                <!-- Your form inputs for editing vehicle information here -->
                                <form action="{{ route('factureAttente.update', ['facture' => $facture->id]) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                  <div class="modal-body">
                                    <input type="hidden"  name="id" value="{{ $facture->id }}" required>
                                    <input type="hidden"  name="code" value="{{ $facture->code }}" required>

                                    <div class="form-group">
                                        <label>Produit </label>
                                        <select class="produit form-control select2" style="width: 100%;border-radius:10px;" name="produit">
                                            <option></option>
                                            @foreach ($produits as $produit)
                                                <option value="{{ $produit->libelle }} , {{ $produit->prix }}" 
                                                    @if ($facture->produit == $produit->libelle) selected @endif>
                                                    {{ $produit->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                    </div> 
                                    
                                      

                                      <div class="form-group">
                                        <label for="libelle">Quantité:</label>
                                        <input type="number" class="form-control" min="0" id="quantite" name="quantite" value="{{ $facture->quantite }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="libelle">Montantant percu:</label>
                                        <input type="number" class="form-control" min="100" id="montantPaye" name="montantPaye" value="{{ $facture->montantPaye }}" required>
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

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>


    <!-- JavaScript pour la mise à jour dynamique (Produit type et produit) -->
    <script>
        // Fonction pour mettre à jour la liste des produits en fonction du Produit Type sélectionné
        function updateProduits() {
            var produitTypeSelect = document.getElementById('produitType');

            //alert(produitTypeSelect)
            var produitsSelect = document.getElementById('produit');


            // Obtient la valeur sélectionnée du Produit Type
            var selectedProduitType = produitTypeSelect.value;

            // Efface les options précédentes
            produitsSelect.innerHTML = '<option></option>';

            // Filtrage des produits en fonction du Produit Type sélectionné
            @foreach ($produits as $produit)
                if ("{{ $produit->produitType_id }}" == selectedProduitType) {
                    var option = document.createElement('option');
                    option.value = "{{ $produit->libelle }}";
                    option.setAttribute('data-prix', "{{ $produit->prix }}");
                    option.setAttribute('data-stock', "{{ $produit->stock_actuel }}");

                    option.textContent = "{{ $produit->libelle }}";
                    produitsSelect.appendChild(option);
                }
            @endforeach
        }

        // Ajoute un écouteur d'événements pour détecter les changements dans le Produit Type
        document.getElementById('produitType').addEventListener('change', updateProduits);

        // Appelle la fonction updateProduits initialement pour configurer la liste des produits
        updateProduits();
    </script>
@endsection
