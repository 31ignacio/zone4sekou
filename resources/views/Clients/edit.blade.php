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

    <form class="settings-form" method="POST" action="{{ route('client.update',$client->id) }}">
        @csrf
        @method('PUT')

    

    <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editer un client</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="raisonSociale">Raison sociale</label>
                            <input type="text" class="form-control" id="raisonSociale" value="{{ $client->raisonSociale }}" name="societe" required style="border-radius:10px;">
                        
                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('raisonSociale')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $client->nom }}" required style="border-radius:10px;">
                       
                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('nom')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                

                    <div class="row">
                       
                        <div class="col-md-12">
                            <label for="telephone">Téléphone</label>
                            <input type="number" class="form-control" id="telephone" value="{{ $client->telephone }}" name="telephone" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('telephone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" id="ville" value="{{ $client->ville }}" name="ville" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('ville')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        
                    </div>
                
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-warning" style="border-radius:10px;">Editer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-4"></div>

    </div>
</form>
@endsection
  