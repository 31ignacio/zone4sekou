@extends('layouts.master2')

@section('content')


<div class="row">

<div class="col-md-3"></div>
    <div class="col-md-6 mt-5">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Changer mon mot de passe</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{ route('password.update') }}" method="post">
            @csrf

            @if(Session::get('danger'))
                <div class="alert alert-warning mt-3" id="msg_danger">
                    {{ Session::get('danger') }}
                </div>
            @endif

            <script>
                // Masquer le message d'erreur après 3 secondes
               setTimeout(function() {
                   $('#msg_danger').hide();
               }, 5000);
            </script>

            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Mot de passe actuel</label>
                    <input name="old_password" id="old_password" type="password" value="{{old('old_password')}}" class="form-control">
                    @error('old_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror              
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nouveau mot de passe</label>
                    <input name="password" id="password" type="password" class="form-control" value="{{old('password')}}">
                        
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror              
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Confirmer nouveau mot de passe</label>
                    <input name="password_confirmation" id="password_confirmation" value="{{old('password_confirmation')}}" type="password" class="form-control">
                    
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror              
                </div>
              
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-3"></div>

</div>

   

@endsection