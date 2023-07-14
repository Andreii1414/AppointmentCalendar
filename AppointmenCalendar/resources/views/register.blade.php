<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register form</h1>
       <form action="/register" method="POST">
       @csrf
            <div>
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="repeat">Repeat your password: </label>
                <input type="password" id="repeat" name="repeat" required>
            </div>

            <div>
                <button type="submit">Register</button>
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