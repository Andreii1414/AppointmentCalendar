<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/home.css') }}" />

</head>
<body>


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
    </div>

    <script src="{{ url('js/home.js') }}"></script>
</body>
</html>