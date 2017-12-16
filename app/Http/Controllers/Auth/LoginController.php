<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
                $data = json_encode($request->input());
                $decodeData = json_decode($data);
                $userObj = new User();
                
               $user = array(
                'email' => $decodeData->username,
                'password' => $decodeData->password,
                );
                
         //print_r($user);exit;      
                
        if (Auth::attempt($user)) {

               Session::put('user_key', md5(uniqid()));
            
            $user_key=Session::get('user_key');
            $userId = Auth::user()->id;
            //return $user->name;
            
            $returnArray = $userObj->checkUser($decodeData->username); 
                
            if(count($returnArray) > 0)
                return response($returnArray,200);
            else
                return response("User Not Active",1002);
        }
        return response("Incorrect Username or Password",1003);
        // authentication failure! lets go back to the login page     */          
    }
    

    // logout function
    public function logout(Request $request) {
        
        $data           = json_encode($request->input());
        $decodeData     = json_decode($data);
        $userObj    = new User(); 
        $user_id = $decodeData->user_id;
        $user_key = Session::get('user_key');   

            $status = $userObj->logout($user_id,$user_key); 
            Session::flush();
        if($status){
                        return array("status" => "success", "data" => $auditObj, "message" => "Logout Sucessfully!");
                        }else{
            return array("status" => "fail", "data" => null, "message" => "Error logging out!");
        }
    }
}
