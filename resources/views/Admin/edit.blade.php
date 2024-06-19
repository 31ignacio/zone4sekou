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



    <form class="settings-form" method="POST" action="{{ route('admin.update',$admin->id) }}">

        @csrf

        @method('PUT')

    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4">

            <!-- general form elements -->

            <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">Editer un utilisateur</h3>

            </div>

            <!-- /.card-header -->

            <!-- form start -->

            <form>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            <label for="raisonSociale">Nom</label>

                            <input type="text" class="form-control" id="nom" value="{{ $admin->name }}" name="nom" required style="border-radius:10px;">

                        

                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}

                        @error('nom')

                        <div class="text-danger">{{ $message }}</div>

                        @enderror

                        </div>



                    

                    </div>



                    <div class="row">

                        <div class="col-md-12">

                            <label for="nom">Email</label>

                            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required style="border-radius:10px;">

                       

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}

                            @error('email')

                                <div class="text-danger">{{ $message }}</div>

                            @enderror

                        </div>



                    </div>

                



                    <div class="row">

                       

                        <div class="col-md-12">

                            <label for="telephone">Téléphone</label>

                            <input type="number" class="form-control" id="telephone" value="{{ $admin->telephone }}" name="telephone" required style="border-radius:10px;">



                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}

                            @error('telephone')

                                <div class="text-danger">{{ $message }}</div>

                            @enderror

                        </div>



                        <div class="col-md-12">

                            <label for="ville">Rôle</label>



                            <select name="role" id="role" class="form-control">

                                @if($admin->role_id == 1)

                                    <option value="1" selected>ADMIN</option>

                                    <option value="2">CAISSE</option>

                                    <option value="3">SUPRRVISEUR</option>



                                @elseif($admin->role_id == 3)

                                    <option value="1">ADMIN</option>

                                    <option value="2" >CAISSE</option>

                                    <option value="3" selected>SUPRRVISEUR</option>



                                @else

                                    <option value="1">ADMIN</option>

                                    <option value="2" selected>CAISSE</option>

                                    <option value="3">SUPRRVISEUR</option>



                                @endif

                            </select>

                            

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}

                            @error('role')

                                <div class="text-danger">{{ $message }}</div>

                            @enderror

                        </div>



                        <div class="col-md-12" hidden>

                            <label for="mdp">Mot de passe</label>

                            <div class="input-group">

                                <input type="password" class="form-control" id="mdp" value="{{ $admin->password }}" name="mdp" required style="border-radius:10px;" disabled>

                                <button class="input-group-addon" id="showHidePassword" onclick="togglePassword()">

                                    <i class="fas fa-eye"></i>

                                </button>

                            </div>

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

 

<script>

    function togglePassword() {

    var passwordInput = document.getElementById('mdp');

    var icon = document.getElementById('showHidePassword').querySelector('i');



    // Inverser l'état du champ de mot de passe entre "text" et "password"

    if (passwordInput.type == 'password') {

        passwordInput.type = 'text';

        passwordInput.value = ''; // Efface le contenu du champ

        icon.classList.remove('fa-eye');

        icon.classList.add('fa-eye-slash');

        passwordInput.classList.remove('input-password-hidden');

    } else {

        passwordInput.type = 'password';

        icon.classList.remove('fa-eye-slash');

        icon.classList.add('fa-eye');

        passwordInput.classList.add('input-password-hidden');

    }

}







</script>

@endsection

  