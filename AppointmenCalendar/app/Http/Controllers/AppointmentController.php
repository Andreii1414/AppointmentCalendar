<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    private function getMonth($month)
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        for($i = 0; $i < 12; $i++)
        {
            if($month === $months[$i])
                return $i+1;
        }
    }

    public function createAppointment(Request $request){
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $appId = $request->input('appId');
        $date = $day . '.' . $this->getMonth($month) . '.' . $year;
        $userId = Session::get('user_id');

        $col1 = DB::select('SELECT count(*) as count FROM appointments where id_app1 = ?', [$userId]);
        $col2 = DB::select('SELECT count(*) as count FROM appointments where id_app2 = ?', [$userId]);
        $col3 = DB::select('SELECT count(*) as count FROM appointments where id_app3 = ?', [$userId]);
        $col4 = DB::select('SELECT count(*) as count FROM appointments where id_app4 = ?', [$userId]);
        $col5 = DB::select('SELECT count(*) as count FROM appointments where id_app5 = ?', [$userId]);
        $col6 = DB::select('SELECT count(*) as count from appointments where id_app6 = ?', [$userId]);
        $col7 = DB::select('SELECT count(*) as count from appointments where id_app7 = ?', [$userId]);
        $sum = $col1[0]->count + $col2[0]->count + $col3[0]->count + $col4[0]->count + $col5[0]->count + $col6[0]->count + $col7[0]->count;

        $existingAppointment = DB::select('SELECT * FROM appointments where app_date = ?', [$date]);
        if(!$existingAppointment && $sum < 2){
            DB::insert('INSERT INTO appointments (app_date, id_app1, id_app2, id_app3, id_app4, id_app5, id_app6, id_app7) VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?)', [$date, 0, 0, 0, 0, 0, 0, 0]);  
        }
        
        $existingAppointment = DB::select('SELECT * FROM appointments where app_date = ? and ' . $appId . ' != 0', [$date]);
        
        if(!$existingAppointment && $sum < 2)
            DB::update('UPDATE appointments SET ' . $appId . ' = ? where app_date = ?', [$userId, $date]);
        
    }

    public function getYourAppointments(){
        $userId = Session::get('user_id');

        $appointments = [];
        for($i = 1; $i <= 7; $i++){
            $column = 'id_app' . $i;
            $result = DB::select('SELECT app_date, '. $column . ' as id_app FROM appointments where ' . $column . ' = ? ', [$userId]);

            foreach($result as $row)
            {
                $appointment = [
                    'app_date' => $row->app_date,
                    'id_app' => $row->id_app,
                    'idCol' => $i
                ];
                $appointments[] = $appointment;
            }
        }
        return $appointments;
    }

    public function removeAppointment(Request $request)
    {
        $appDate = $request->input('appDate');
        $idCol = $request->input('idCol');

        $column = 'id_app' . $idCol;

        DB::update('UPDATE appointments SET ' . $column . ' = ? where app_date = ?', [0, $appDate]);

        $emptyRow = DB::select('SELECT * from appointments where app_date = ? and id_app1 = ? and id_app2 = ? and id_app3 = ?
        and id_app4 = ? and id_app5 = ? and id_app6 = ? and id_app7 = ?', [$appDate, 0, 0, 0, 0, 0, 0, 0]);

        if($emptyRow)
        {
            DB::delete('DELETE FROM appointments where app_date = ?', [$appDate]);
        }
    }
}
