<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends \Illuminate\Routing\Controller
{
    public function deleteUser(Request $request)
    {
        $isAdmin = Session::get('admin');
        $email = $request->input('email');

        if ($isAdmin) {

            $existingUser = DB::select('SELECT * FROM users where email = ?', [$email]);
            if (!$existingUser) {
                $errors[] = 'User does not exists';
                return redirect()->back()->withErrors($errors)->withInput();
            } else {
                DB::delete('DELETE FROM users where email = ?', [$email]);

                for ($i = 1; $i <= 7; $i++) {
                    $column = 'id_app' . $i;
                    DB::update('UPDATE appointments SET ' . $column . ' = ? where ' . $column . ' = ? ', [0, $existingUser[0]->id]);
                }

                return redirect()->route('home');
            }
        }
    }

    public function getAllAppointments()
    {
        $isAdmin = Session::get('admin');

        if ($isAdmin) {
            $appointments = [];
            for ($i = 1; $i <= 7; $i++) {
                $column = 'id_app' . $i;
                $result = DB::select('SELECT app_date, u.name as nume, ' . $column . ' as id_app FROM appointments a JOIN users u on u.id = a.' . $column);

                foreach ($result as $row) {
                    $appointment = [
                        'app_date' => $row->app_date,
                        'name' => $row->nume,
                        'id_app' => $row->id_app,
                        'idCol' => $i
                    ];
                    $appointments[] = $appointment;
                }
            }
            return $appointments;
        }
    }
    public function deletePastAppointments(){
        $isAdmin = Session::get('admin');

        if($isAdmin)
        {
            DB::delete('DELETE FROM appointments WHERE STR_TO_DATE(app_date, "%d.%m.%Y") < CURDATE()');
        }
        return redirect()->route('home');
    }
}