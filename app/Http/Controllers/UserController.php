<?php

// FileName                     : CourseController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Course Controller                   
//                          
// Last Modified By         :                        
// Last Modified On     :                       
// Modifications Done       :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class UserController extends Controller
{

    User $userObj = new User;
    /*
    |--------------------------------------------------------------------------
    | Course Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the management of courses as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function index()
    {
        
    }

    /* This function is to validate user in the system*/
    public funtion validateUser()
    {
        // data = {"email":"2","search_type":"basic_search"}    
        
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;
        $login_key = \Session::getId(); 

        $getUser = $userObj->validateUser($data['email']);

            if($getUser > 0){
                
                return array("status" => "success", "data" => $getUser, "message" => "User Id");
            }
            else{
                return array("status" => "fail", "data" => null, "message" => "No User Found");
            }
    }    

}
