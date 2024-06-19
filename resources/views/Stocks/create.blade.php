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

        <div class="col-md-4 mt-5">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Entrés de stocks</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="settings-form" method="POST" action="{{ route('stock.store') }}">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="produit">Produit</label>
                            <select class="form-control select2" id="produit" name="produit" required>
                                <option value=""></option>
                                @foreach ($produits as $produit)
                                <option value="{{ $produit->libelle }} , {{ $produit->emplacement_id }}">{{ $produit->libelle }}</option>
                                @endforeach
                            </select>
                            @error('produit')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <input type="hidden" id="emplacement_id" name="emplacement_id">
                        
                        <div class="col-md-12">
                            <label for="quantite">Casier</label>
                            <input type="number" min="0" class="form-control"  id="casier" name="casier" value="{{ old('casier') }}" required step="any">
                        </div>

                        <div class="col-md-12">
                            <label for="unite">Unité</label>
                            <input type="number" min="0" class="form-control"  id="unite" name="unite" value="{{ old('unite') }}" required step="any">
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
