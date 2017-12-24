<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\User;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPassword(Request $request)
    {
        $data = json_encode($request->input());

        $decodeData = json_decode($data);
        $userObj = new User();

    
        $email = $decodeData->email;
        $password = $decodeData->oldPassword;
        $newPassword = $decodeData->newPassword;

        $user = array('email' => $email,'password' => $password);
        if(Auth::attempt($user))
        {
            $getUserDetails = $userObj->getUserForReset($email);
            
                $userid = $getUserDetails[0]->userid;
                $updateResetPassword = $userObj->updateResetPassword($userid,$newPassword);
        
                return response()->json(['message' => 'Password Reset Successfully', 'data' => null, 'status' => 200]);
        }
        else{
            return response()->json(['message' => 'Incorrect Password', 'data' => null, 'status' => 1000]);
        }
    }
}
