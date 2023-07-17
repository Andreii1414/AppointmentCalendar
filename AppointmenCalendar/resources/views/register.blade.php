<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/forms.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class='content'>
        <h1><i class="fa fa-calendar icon"></i>Register form</h1>
        <form action="/register" method="POST">
        @csrf
                <div>
                    <i class="fa fa-user icon"></i>
                    <input placeholder='Name' type="text" id="name" name="name" required>
                    <i class="fa fa-user icon"></i>
                </div>

                <div>
                    <i class="fa fa-envelope icon"></i>
                    <input placeholder='Email' type="email" id="email" name="email" required>
                    <i class="fa fa-envelope icon"></i>
                </div>
                
                <div>
                    <i class="fa fa-key icon"></i>
                    <input placeholder='Password' type="password" id="password" name="password" required>
                    <i class="fa fa-eye icon" id="showPassword" onclick="passwordVisibility(1)"></i>
                </div>

                <div>
                    <i class="fa fa-key icon"></i>
                    <input placeholder='Repeat your password' type="password" id="repeat" name="repeat" required>
                    <i class="fa fa-eye icon" id="showPassword" onclick="passwordVisibility(2)"></i>
                </div>

                <div class="g-recaptcha" data-sitekey="6LdqJy4nAAAAADUUjiZjfSotSUxMikRhkhkQpfOb"></div>

                <div>
                    <button type="submit">Register</button>
                </div>

                <div>
                    Have already an account? <a href='/login'>Login here</a>
                </div>
        </form>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var inputNume = document.getElementById('name');
            var inputEmail = document.getElementById('email');
            var inputParola = document.getElementById('password');
            var inputResparola = document.getElementById('repeat');

            inputNume.value = sessionStorage.getItem('name');
            inputEmail.value = sessionStorage.getItem('email');
            inputParola.value = sessionStorage.getItem('password');
            inputResparola.value = sessionStorage.getItem('repeat');

            inputNume.addEventListener('input', function(){
                sessionStorage.setItem('name', inputNume.value);
            });
            inputEmail.addEventListener('input', function(){
                sessionStorage.setItem('email', inputEmail.value);
            });
            inputParola.addEventListener('input', function(){
                sessionStorage.setItem('password', inputParola.value);
            });
            inputResparola.addEventListener('input', function(){
                sessionStorage.setItem('repeat', inputResparola.value);
            })

    })

                        
    function passwordVisibility(pas){
        if(pas == 1)
            var passwordInput = document.getElementById("password");
        else var passwordInput = document.getElementById("repeat");
        var toggle = document.getElementById("showPassword");

        if(passwordInput.type == "password")
        {
            passwordInput.type = "text";
        }
        else {
            passwordInput.type = "password";
        }
     }
    </script>
</body>
</html>