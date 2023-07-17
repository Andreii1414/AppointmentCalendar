<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends \Illuminate\Routing\Controller
{
    public function registerUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $repeat = $request->input('repeat');

        $userIp = $request->ip();

        $errors = $this->validateRegister($email, $password, $repeat, $userIp);
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        
        DB::insert('INSERT INTO users (name, email, password, admin, verified) VALUES (?, ?, ?, ?, ?)', [$name, $email, bcrypt($password), false, false]);
        $countIp = DB::select('SELECT acc_count as cnt FROM userip where ip = ?', [$userIp])[0]->cnt;
        if($countIp === 0)
        {
            DB::insert('INSERT INTO userip (ip, acc_count) VALUES (?, ?)', [$userIp, 1]);
        }
        else {
            DB::update('UPDATE userip SET acc_count = ? where ip = ?', [$countIp + 1, $userIp]);
        }
        
        return redirect()->route('success')->with('success', 'Registration successful!');
        
    }

    private function validateRegister($email, $password, $repeat, $userIp)
    {
        $errors = [];
        if ($password !== $repeat)
            $errors[] = 'Passwords do not match';

        if (strlen($password) < 8)
            $errors[] = 'Password must be at least 8 characters';

        if (!preg_match('/\d/', $password))
            $errors[] = 'Password must contain at least one number';

        $existingEmail = DB::select('SELECT * FROM users where email = ?', [$email]);
        if($existingEmail)
            $errors[] = 'Email already exists';


        $countIp = DB::select('SELECT acc_count as cnt FROM userip where ip = ?', [$userIp])[0]->cnt;
        if($countIp >= 2)
        {
            $errors[] = 'You have reached the limit of 2 accounts per IP';
        }

        $domain = substr(strrchr($email, "@"), 1);
        $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'mail.com', 'protonmail.com', 'icloud.com', 'aol.com'];
        
        $domText = $allowedDomains[0];
        for($i = 1; $i < count($allowedDomains); $i++){
            $domText .= ', ' . $allowedDomains[$i];
        }

        if(!in_array($domain, $allowedDomains)){
            $errors[] = 'Invalid email domain. Please use: ' . $domText;
        }

        return $errors;
    }
}