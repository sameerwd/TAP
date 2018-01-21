<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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


    /*Index method*/
    public function index()
    {
        echo "Welcome!Please Register!";
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
                $user_id = Auth::user()->id;
                $login_key = \Session::getId();
        
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $request)
    {

        //$data = '{"first_name":"amey", "last_name": "jagtap","email":"amey@gmail.com","password":"amey123","user_type":"admin","os":"iOS","device":"moto","pushkey":"asdet"}'; 

        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        $userObj = new User();
                //$user_id = Auth::user()->id;
                //$login_key = \Session::getId();

        if(isset($decodeData->email) && $decodeData->email != "")
        {
            $email = $decodeData->email;
            $checkUserExixts = $userObj->findUserByEmail($email);

            if($checkUserExixts > 0)
                return response("User already exists",212);
        }

            $userCreate = User::create([
                'title' => $decodeData->title,
                'firstname' => $decodeData->first_name,
                'lastname' => $decodeData->last_name,
                'email' => $decodeData->email,
                'password' => bcrypt($decodeData->password),
                'userType' => $decodeData->user_type,
                'os' => $decodeData->os,
                'device' => $decodeData->device,
                'pushkey' => $decodeData->pushkey,
            ]);

        if(isset($userCreate->id)){
            return response($userCreate->id,200);
        }
        else{
            return response("Bad Request,please try again.",400);
        }
    }

    /**
     * Checks the email in the system.
     *
     * @param  $email
     * @return Boolean status
     */
    public function checkEmail(Request $request)
    {
        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        $userObj = new User();

        $email = $decodeData->email;

        try{
            $checkEmail = $userObj->checkUser($email);
            return response($checkEmail,200);
        }catch(\Exception $e)
        {
            return response($e,400);
        }    
    }
    
}    
