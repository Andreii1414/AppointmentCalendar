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
        <h1>Enter the code received by email</h1>
        <form action="/verify-code" method="POST">
        @csrf
                <div>
                     <input placeholder='Code' type="text" id="code" name="code" required>
                </div>
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