@extends('layouts.master2')

@section('content')

    @if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
        <script>
            setTimeout(() => {
                document.getElementById('success-message').remove();
            }, 3000);
        </script>
    @endif

    <form class="settings-form" method="POST" action="{{ route('information.update',$information->id) }}">
        @csrf
    
        <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4 mt-5">
                <!-- general form elements -->
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editer </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <label for="raisonSociale">Raison sociale</label>
                                <input type="text" class="form-control" id="nom" value="{{ $information->nom }}" name="nom" required style="border-radius:10px;">
                            
                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('nom')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="nom">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $information->adresse }}" required style="border-radius:10px;">
                        
                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('adresse')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    

                        <div class="row">
                        
                            <div class="col-md-12">
                                <label for="telephone">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" value="{{ $information->telephone }}" name="telephone" required style="border-radius:10px;">

                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('telephone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="ifu">Ifu</label>
                                <input type="number" class="form-control" id="telephone" value="{{ $information->ifu }}" name="ifu" required style="border-radius:10px;">

                                {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                                @error('ifu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
    
                        </div>
                    
                    
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-warning">Editer</button>
                    </div>
                </form>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4"></div>

        </div>
    </form>
@endsection
  