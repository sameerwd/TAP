<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Model\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword()
    {

        //$data = '{"email":"amey@gmail.com"}'; 

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $userObj = new User();

        if(isset($decodeData->email) && $decodeData->email != "")
            $checkUser = $userObj->findUserByEmail($decodeData->email);
        else
            return array("status" => "fail", "data" => null,"message" => "Please enter a valid email");

        if($checkUser == 0)
            return array("status" => "fail", "data" => null,"message" => "Email is not registered in the system.");
    
        $password = rand(10,100);
        $email = $decodeData->email;
        

        //  echo $password;
        $updatePassword = $userObj->updateUserPassword(bcrypt($password),$email);

    
        if($updatePassword > 0){
             $subject = "Password help assistance - Get back your password";
             $message = "<b>Dear TAP user,</b><br><br>";
             $message .= "You are receiving this mail because you have asked for help regarding the password for ".$email."<br><br>";
             $message .= "Please use following temporary password to login.<br><br>";
             $message .= "Temporary Password: ".$password;
             $message .= "<br><br>Once you login you will be prompted to change your password.<br><br>";
             $message .= "Sincerely,<br>The Academic Point Team";
             
             $header = "From: The Academic Point webmaster@theacademicpointonline.com \r\n";
        //      $header = "Cc:afgh@somedomain.com \r\n";
             $header .= "MIME-Version: 1.0\r\n";
             $header .= "Content-type: text/html\r\n";
         
        //   $header = "From:The Academic Point \r\n";
        //   $header = "From: webmaster@theacademicpointonline.com' . "\r\n";
        //   $header .= "MIME-Version: 1.0\r\n";
        //   $header .= "Content-type: text/html\r\n";
        //   $header .= "From: webmaster@example.com' . "\r\n";
         
             $retval = mail ($email,$subject,$message,$header);
         
             if( $retval == true ) {
                return array("status" => "success", "data" => null,"message" => "Password sent successfully");
            }
            else{
                return array("status" => "fail", "data" => null,"message" => "Unable to send reset password. Please try again");
            }
        }
    }
}
