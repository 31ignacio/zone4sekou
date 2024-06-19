@extends('layouts.master2')

@section('content')

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




    <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Entrés de stocks(Gros)</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="settings-form" method="POST" action="{{ route('stock.storeGros') }}">
                @csrf
                @method('POST')
                            <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="produit">Produit</label>
                            <select class="form-control select2" id="produit" name="produit" style="width: 100%;border-radius:10px;" required>

                                <option value=""></option>
                                @foreach ($produits as $produit )
                                <option value="{{$produit->libelle}}">{{$produit->libelle}}</option>

                                @endforeach
                            </select>

                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('produit')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="quantite">Quantité</label>
                            <input type="text" class="form-control" min=1  id="quantite" name="quantite" value="{{ old('quantite') }}" required step="any" style="border-radius: 10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="border-radius:10px;">Envoyer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-4"></div>

    </div>

    
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
