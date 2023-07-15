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

        </div>

    <script src="{{ url('js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //Select cell + display availability -----------
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
                    if(avText === 'Available')
                        availabilityContainer.addEventListener('click', function(){
                            createAppointment(day, month, year, slot.id);
                        })

                    divAv.appendChild(availabilityContainer);
                })

            }
            //-------------


            //Create appointment + get your appointments + print appointments --------------
            function createAppointment(day, month, year, appId)
            {
                $.ajax({
                    url: '/create-appointment',
                    type: 'POST',
                    data: {
                        day: day, 
                        month: month,
                        year: year,
                        appId: appId
                    },
                    success: function(response){
                        console.log(response);

                        selectCell(day, month, year);

                        getYourAppointments();
                        
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }

            function getYourAppointments(){
                $.ajax({
                    url: '/get-your-appointments',
                    type: 'GET',
                    success: function(response){
                        console.log(response);
                        printAppointments(response);
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }

            window.onload = function(){
                getYourAppointments();
            }

            function printAppointments(appointments){
                var divApp = document.getElementById('your_appointments');
                divApp.innerHTML = '';

                divApp.innerHTML = '<h2>Your appointments</h2> <h5>You can create a maximum of 2 appointments. <br> Press "x" to delete the appointment</h5>'

                var slots = [
                    {time: '09:00 - 10:00', id: 'id_app1'},
                    {time: '10:30 - 11:30', id: 'id_app2'},
                    {time: '12:00 - 13:00', id: 'id_app3'},
                    {time: '15:30 - 16:30', id: 'id_app4'},
                    {time: '17:00 - 18:00', id: 'id_app5'},
                    {time: '18:30 - 19:30', id: 'id_app6'},
                    {time: '20:00 - 21:00', id: 'id_app7'},
                ]
                var ul = document.createElement('ul');
                appointments.forEach(function(appointment){
                    var li = document.createElement('li');
                    li.innerHTML = appointment.app_date + ' - (' + slots[appointment.idCol - 1].time + ')';

                    li.addEventListener('click', function(){
                        removeAppointment(appointment.app_date, appointment.idCol);                        
                    })
                    
                    ul.appendChild(li);
                })
                divApp.appendChild(ul);
            }
            //-------------


            //Remove appointment --------------
            function removeAppointment(appDate, idCol){
                $.ajax({
                    url: '/remove-appointment',
                    type: 'PUT',
                    data: {
                        appDate: appDate,
                        idCol: idCol
                    },
                    success: function(response){
                        console.log(response);
                        getYourAppointments();
                        var day = appDate.split('.')[0];
                        var month = appDate.split('.')[1];
                        var year = appDate.split('.')[2];
                        console.log(day, month, year);
                        selectCell(day, getMonthName(month), year);

                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }
            //------------------

            $(document).on('click', '.table td', function(){
                var day = $(this).text();
                var month = $('#month-year').text().split(' ')[0];
                var year = $('#month-year').text().split(' ')[1];
                selectCell(day, month, year);
            })

            function getMonthName(month)
            {
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                return months[month - 1];
            }


        })

    </script>
</body>
</html>