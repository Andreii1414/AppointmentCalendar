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

    <div id ="availability"></div>

    <script src="{{ url('js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            function selectCell(day, month, year)
            {
                $.ajax({
                    url: '/get-appointments',
                    type: 'GET',
                    data:{
                        year: year,
                        month: month,
                        day: day
                    },
                    success: function(response)
                    {
                        console.log(response);

                        displayAvailability(response, day, month, year);

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
            
            function displayAvailability(appointments, day, month, year)
            {

                var slots = [
                    {time: '09:00 - 10:00', id: 'id_app1'},
                    {time: '10:30 - 11:30', id: 'id_app2'},
                    {time: '12:00 - 13:00', id: 'id_app3'},
                    {time: '15:30 - 16:30', id: 'id_app4'},
                    {time: '17:00 - 18:00', id: 'id_app5'},
                    {time: '18:30 - 19:30', id: 'id_app6'},
                    {time: '20:00 - 21:00', id: 'id_app7'},
                ]
                var divAv = document.getElementById('availability');
                divAv.innerHTML = '';

                var txt = document.createElement('h2');
                var txt2 = document.createElement('h5');
                txt.innerHTML = day + ' ' + month + ' ' + year;
                txt2.innerHTML = 'Click on an available time to create an appointment';
                divAv.appendChild(txt);
                divAv.appendChild(txt2);


                slots.forEach(function(slot){
                    var avText = 'Available';
                    var avClass = 'green';

                    if(appointments[0][slot.id] && appointments[0][slot.id] !== 0){
                        avText = 'Not available';
                        avClass = 'red';
                    }

                    var slotHtml = '<div class="' + avClass + '">' + '<span class="time">' + slot.time + '</span>'
                        + '<span class="availability"> ' + avText + '</span></div>';
                        
                    var availabilityContainer = document.createElement('div');
                    availabilityContainer.innerHTML = slotHtml;
                    divAv.appendChild(availabilityContainer);
                })

            }

            $(document).on('click', '.table td', function(){
                var day = $(this).text();
                var month = $('#month-year').text().split(' ')[0];
                var year = $('#month-year').text().split(' ')[1];
                selectCell(day, month, year);
            })

        })

    </script>
</body>
</html>