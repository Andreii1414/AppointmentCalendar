<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/forms.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class='content'>
        <h1> <i class="fa fa-calendar icon"></i>Login form</h1>
        <form action="/login" method="POST">
        @csrf
            
                <div>
                    <i class="fa fa-envelope icon"></i>
                    <input placeholder='Email' type="email" id="email" name="email" required>
                    <i class="fa fa-envelope icon"></i>
                </div>
                
                <div>
                    <i class="fa fa-key icon"></i>
                    <input placeholder='Password' type="password" id="password" name="password" required>
                    <i class="fa fa-eye icon" id="showPassword" onclick="passwordVisibility()"></i>
                </div>

                <div>
                    <button type="submit">Login</button>
                </div>
                
                <div>
                    Don't have an account? <a href='/register'>Register here</a>
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
        var inputEmail = document.getElementById('email');
        var inputPassword = document.getElementById('password');

        inputEmail.value = sessionStorage.getItem('email');
        inputPassword.value = sessionStorage.getItem('password');

        inputEmail.addEventListener('input', function(){
            sessionStorage.setItem('email', inputEmail.value);
        });
        inputPassword.addEventListener('input', function(){
            sessionStorage.setItem('password', inputPassword.value);
        });

    })

    function passwordVisibility(){
        var passwordInput = document.getElementById("password");
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