<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login form</h1>
       <form action="/login" method="POST">
       @csrf

            <div>
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required>
            </div>


            <div>
                <button type="submit">Login</button>
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
</body>
</html>