<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/forms.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class='content'>
        <h1>Login form</h1>
        <form action="/login" method="POST">
        @csrf

                <div>
                    <input placeholder='Email' type="email" id="email" name="email" required>
                </div>
                
                <div>
                    <input placeholder='Password' type="password" id="password" name="password" required>
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
</body>
</html>