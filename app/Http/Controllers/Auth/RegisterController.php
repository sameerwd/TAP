<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

        // data = {"first_name":"sam", "last_name": "deshpande","email":"sam@desh","password":"****","user_type":"admin","os":"iOS","device":"moto","pushkey":"asdet"}    

        $data       = $_POST["data"];
        $decodeData = json_decode($data);
                $user_id = Auth::user()->id;
                $login_key = \Session::getId();

        if($data['user_type'] == 1)
        {
            return User::create([
                'firstname' => $data['first_name'],
                'lastname' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'userType' => $data['user_type'],
                'os' => $data['os'],
                'device' => $data['device'],
                'pushkey' => $data['pushkey'],
            ]);
        }
        else
        {
            return User::create([
                'title' => $data['title'],
                'firstname' => $data['first_name'],
                'lastname' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'userType' => $data['user_type'],
                'os' => $data['os'],
                'device' => $data['device'],
                'pushkey' => $data['pushkey'],
            ]);
        }
}
