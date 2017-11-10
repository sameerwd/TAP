<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

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
        //$this->middleware('guest');
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
    protected function validator()
    {
        $data       = $_POST["data"];
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
    protected function create()
    {

        //$data = '{"first_name":"amey", "last_name": "jagtap","email":"amey@gmail.com","password":"amey123","user_type":"admin","os":"iOS","device":"moto","pushkey":"asdet"}'; 

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $userObj = new User();
                //$user_id = Auth::user()->id;
                //$login_key = \Session::getId();

        if(isset($decodeData->email) && $decodeData->email != "")
        {
            $email = $decodeData->email;
            $checkUserExixts = $userObj->findUserByEmail($email);

            if($checkUserExixts > 0)
                return array("status" => "success", "data" => null,"message" => "User already exists with this email."); 
        }


        if($decodeData->user_type == 'admin')
        {
            $userCreate = User::create([
                'firstname' => $decodeData->first_name,
                'lastname' => $decodeData->last_name,
                'email' => $decodeData->email,
                'password' => bcrypt($decodeData->password),
                'userType' => 1,
                'os' => $decodeData->os,
                'device' => $decodeData->device,
                'pushkey' => $decodeData->pushkey,
            ]);
        }
        else
        {
            $userCreate = User::create([
                'title' => $decodeData->title,
                'firstname' => $decodeData->first_name,
                'lastname' => $decodeData->last_name,
                'email' => $decodeData->email,
                'password' => bcrypt($decodeData->password),
                'userType' => 1,
                'os' => $decodeData->os,
                'device' => $decodeData->device,
                'pushkey' => $decodeData->pushkey,
            ]);
        }

        if(isset($userCreate->id)){
            return array("status" => "success", "data" => null,"message" => "User created successfully.");
        }
        else{
            return array("status" => "fail", "data" => null,"message" => "Unable to create user.");
        }
    }

    
}    
