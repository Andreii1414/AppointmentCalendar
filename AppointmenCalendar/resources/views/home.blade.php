<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    @if (Session::has('user_id') && Session::has('login_time') && Session::has('expiry_time'))
        <p>User is connected</p>
    @else
        <p>User is not connected</p>
    @endif
</body>
</html>