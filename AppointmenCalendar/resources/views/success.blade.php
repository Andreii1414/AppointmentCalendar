<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/forms.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>You have successfully registered! Press the button below to log in.</h1>
    <a href="/login">
         <button>Login</button>
    </a>
</body>
</html>