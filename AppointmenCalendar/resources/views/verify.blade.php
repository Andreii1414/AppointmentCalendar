<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/forms.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class='content'>
        <h1>Verify your account. You will receive the code by email.</h1>
        <form action="/verify" method="GET">
        @csrf
                <div>
                    <button type="submit">Verify</button>
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