<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/../../../vendor/autoload.php';
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_SwiftException;  

class VerifyController extends \Illuminate\Routing\Controller
{
    public function sendToken(){
        $userId = Session::get('user_id');
        $userEmail = DB::select('SELECT email from users where id = ?', [$userId])[0]->email;
        $isVerified = Session::get('verified');
        if(!$isVerified){
            $token = "";
            $token = bin2hex(random_bytes(10));

            DB::insert('INSERT INTO verify (id_user, email, token) VALUES (?, ?, ?)', [$userId, $userEmail, $token]);

            try{
                $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
                        ->setUsername('rot6980@gmail.com')
                        ->setPassword('xcyoxtgmegexlycb');
                $mailer = new Swift_Mailer($transport);

                $body = "<p>Your account verification token is:</p> <p style='color:red;'>$token</p>";
                $message = (new Swift_Message('Verify your account'))
                    ->setFrom(['rot6980@gmail.com' => 'Appointment Calendar'])
                    ->setTo($userEmail)
                    ->setBody($body)
                    ->setContentType('text/html');
                $mailer->send($message);

                return redirect()->route('code');
            }
            catch(Swift_SwiftException $e){
                echo $e->getMessage();
            }
        }
        else {
            $errors[] = 'Your account is verified';
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function verifyCode(Request $request){
        $code = $request->input('code');
        $existingCode = DB::select('SELECT * FROM verify WHERE token = ?', [$code]);

        if($existingCode){
            $userId = $existingCode[0]->id_user;
            DB::update('UPDATE users SET verified = ? WHERE id = ?', [true, $userId]);
            DB::delete('DELETE FROM verify WHERE token = ?', [$code]);
            Session::put('verified', 1);
            return redirect()->route('home');
        }
        else{
            $errors[] = 'The code is not valid';
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
}
