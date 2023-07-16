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

        $errors = $this->validateRegister($email, $password, $repeat);
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        
        DB::insert('INSERT INTO users (name, email, password, admin, verified) VALUES (?, ?, ?, ?, ?)', [$name, $email, bcrypt($password), false, false]);
        return redirect()->route('success')->with('success', 'Registration successful!');
        
    }

    private function validateRegister($email, $password, $repeat)
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

        return $errors;
    }
}