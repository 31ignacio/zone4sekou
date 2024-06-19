<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GES_BAR</title>
    
</head>

<body>

    <style>
        body {
          margin: 0;
          padding: 0;
          font-family: 'Arial', sans-serif;
          background: url('supermarket_bg.jpg') no-repeat center center fixed;
          background-size: cover;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
        }
    
        .login-container {
          background: rgba(255, 255, 255, 0.9);
          padding: 30px;
          border-radius: 15px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
          width: 350px;
          text-align: center;
        }
    
        .login-container h4 {
          margin-bottom: 20px;
          color: #333;
        }
    
        .login-message {
          margin-bottom: 20px;
          color: #666;
        }
    
        .login-input {
          width: 100%;
          padding: 15px;
          margin-bottom: 20px;
          border: 1px solid #ccc;
          border-radius: 8px;
          box-sizing: border-box;
        }
    
        .login-button {
          width: 100%;
          padding: 15px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          transition: background-color 0.3s;
        }
    
        .login-button:hover {
          background-color: #45a049;
        }
        .error_span{
          margin-left: 0%;
        }
    </style>
        
    <div class="login-container">
      @if (Session::get('success_message'))
          <b style="font-size:10px; color:rgb(29, 255, 199)">{{ Session::get('error_msg') }}</b>
      @endif

      @if (Session::get('error_msg'))
          <b style="font-size:15px; color:rgb(185, 81, 81)">{{ Session::get('error_msg') }}</b>
      @endif

      @if (Session::get('success_msg'))
          <b style="font-size:15px; color:green;">{{ Session::get('success_msg') }}</b>
      @endif

      <br><hr>
      <h3>Bienvenue au bar</h3>
      <p class="login-message">Veuillez vous connecter pour accéder à votre compte.</p>
      <form method="post" action="{{ route('handleLogin') }}">

          @csrf
          @method('POST')
          <div>
            <input class="login-input" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
            
            @error('email')
              <span class="error_span" style="color: red;margin-right:200px;">{{ $message }}</span>
            @enderror
          </div>
          <div>
              <input type="password" name="password" id="password" class="login-input email form-control styled-password" placeholder="Mot de passe" />
              @error('password')
              <span class="error_span" style="color: red;margin-right:200px;">{{ $message }}</span>
              @enderror

              <label for="showPasswordCheckbox" class="show-password-label">
                  <input type="checkbox" id="showPasswordCheckbox" class="show-password-checkbox"
                      onchange="togglePasswordVisibility()">
                  Afficher le mot de
                  passe
              </label>
          </div>

            

            <br>
          <button type="submit" class="login-button">Se connecter</button>
      </form>
    </div>    


    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>

  </body>

</html>
