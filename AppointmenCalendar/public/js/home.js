function generateCalendar(year, month)
{
    var body = document.getElementById('calendar-body');
    var monthYear = document.getElementById('month-year');

    monthYear.textContent = getMonthName(month) + ' ' + year;

    body.innerHTML = '';

    var daysInMonth = new Date(year, month, 0).getDate();
    var firstDay = new Date(year, month - 1, 0).getDay();
    var date = 1;

    for(var i = 0; i < 6; i++)
    {
        var row = document.createElement('tr');
        for(var j = 0; j < 7; j++)
        {
            if(i === 0 && j < firstDay)
            {
                var cell = document.createElement('td');
                row.appendChild(cell);
            }
            else if(date <= daysInMonth)
            {
                var cell = document.createElement('td');
                cell.textContent = date;
                row.appendChild(cell);
                date++;
            }
        }
        body.appendChild(row);
    }
    applyDateStyles();
}

function getMonthName(month)
{
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return months[month - 1];
}

var currentDate = new Date();
var currentYear = currentDate.getFullYear();
var currentMonth = currentDate.getMonth() + 1;

generateCalendar(currentYear, currentMonth);

document.getElementById('prev').addEventListener('click', function(){
    currentMonth--;
    if(currentMonth === 0)
    {
        currentMonth = 12;
        currentYear--;
    }
    generateCalendar(currentYear, currentMonth);
    applyDateStyles();
})

document.getElementById('next').addEventListener('click', function(){
    currentMonth++;
    if(currentMonth === 13)
    {
        currentMonth = 1;
        currentYear++;
    }
    generateCalendar(currentYear, currentMonth);
    applyDateStyles();
})

function disableWekend()
{
    $('.table td:nth-child(6), .table td:nth-child(7)').addClass('disabled');
}

function isWeekend(date)
{
    var dayOfWeek = date.getDay();
    return dayOfWeek === 0 || dayOfWeek === 6;
}

function disablePastDates(){
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1;
    var currentDay = currentDate.getDate();

    var $tableCells = $('.table td');
    $tableCells.each(function(){
        var day = parseInt($(this).text(), 10);
        var month = parseInt(getMonthNr($('#month-year').text().split(' ')[0], 10));
        var year = parseInt($('#month-year').text().split(' ')[1], 10);

        console.log(currentMonth, month);
        if((year < currentYear) || (year === currentYear && month < currentMonth)  || 
        (year === currentYear && month === currentMonth && day < currentDay))
            $(this).addClass('disabled');
    })
}

function applyDateStyles(){
    disableWekend();
    disablePastDates();
}


function getMonthNr(month)
{
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    for(i = 0; i < 12; i++)
    {
        if(month === months[i])
            return i+1;
    }
}