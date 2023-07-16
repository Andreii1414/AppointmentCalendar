<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/home.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

        <div class = 'container'>
            <div class="calendar">
                <div class="header">
                    <button id="prev">&lt;</button>
                    <h2 id="month-year"></h2>
                    <button id="next">&gt;</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body"></tbody>
                </table>
                <div id ="availability"></div>
            </div>


            <div id="your_appointments">
            </div>

            @if(Session::get('admin'))
            <div id="admin_panel">
                <h2>Admin panel</h2>
                <h4>Delete user</h4>
                <form action="/delete-user" method="POST">
                 @csrf
                 @method('DELETE')

                <div>
                    <input type="email" id="email" name="email" placeholder = "Email" required>
                </div>
                

                <div>
                    <button type="submit">Delete user</button>
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
            <div id="all_appointments"></div>
            </div>
            @endif

        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ url('js/home.js') }}"></script>
    <script src="{{ url('js/appointments.js') }}"></script>
    <script src="{{ url('js/admin.js') }}"></script>
    
</body>
</html>