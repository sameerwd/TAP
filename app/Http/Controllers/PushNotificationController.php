<?php

// FileName                     : PushNotificationController.php                 
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

use Model\PushNotification;
use Model\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class PushNotificationController extends Controller
{

    PushNotification $pushNotificationObj = new PushNotification();
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


    public function activatePush()
    {
       // data = {"user_id":"2","search_type":"basic_search", "permission":"1"} course_ids    
        
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;
        $login_key = \Session::getId(); 

        $userid = $data['userid'];
        $permission = $data['permission'];

        $activatePush = $pushNotificationObj->setPushPermission($userid,$permission);

    
        if($activatePush){
            return array("status" => "success", "data" => null,"message" => "Push notification permission updated successfully.");
        }
        else{
            return array("status" => "fail", "data" => null,"message" => "Unable to update permissions right now, please try after some time.");
        }
    }


}    