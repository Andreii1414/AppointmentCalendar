<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function getAppointments(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        $date = $day . '.' . $this->getMonth($month) . '.' . $year;

        $existingAppointment = DB::select('SELECT * FROM appointments where app_date = ?', [$date]);
        if(!$existingAppointment)
            return response() -> json('Not found');
        else 
            return response() -> json($existingAppointment);
    }

    function getMonth($month)
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        for($i = 0; $i < 12; $i++)
        {
            if($month === $months[$i])
                return $i+1;
        }
    }
}
