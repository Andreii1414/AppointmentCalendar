<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginController extends \Illuminate\Routing\Controller
{
    public function loginUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $errors = $this->validateLogin($email, $password);
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        
       if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $user = Auth::user();
            $loginTime = now();
            $expiryTime = $loginTime->addHours(6);

            Session::put('user_id', $user->id);
            Session::put('admin', $user->admin);
            Session::put('login_time', $loginTime);
            Session::put('expiry_time', $expiryTime);
            Session::put('expiry_timestamp', $expiryTime->timestamp);

            return redirect()->route('home');
        }
    }

    private function validateLogin($email, $password)
    {
        $errors = [];

        $existingUser = DB::select('SELECT * FROM users where email = ?', [$email]);
        if(!$existingUser)
            $errors[] = 'Email does not exists';
        else {
            $hashedPassword = $existingUser[0]->password;
            if(!Hash::check($password, $hashedPassword)){
                $errors[] = 'Invalid password';
            }
        }
        

        return $errors;
    }
}
