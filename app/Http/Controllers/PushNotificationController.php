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

use App\Model\PushNotification;
use App\Model\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class PushNotificationController extends Controller
{

    
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
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 
        $pushNotificationObj = new PushNotification();

        $userid = $decodeData->user_id;
        $permission = $decodeData->permission;

        try{
            $activatePush = $pushNotificationObj->setPushPermission($userid,$permission);    
            return response($activatePush,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }

    public function saveDeviceKey()
    {
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $pushNotificationObj = new PushNotification();


        $deviceid = $decodeData->deviceid;
        $type = $decodeData->type;
        $siteid = $decodeData->siteid;
        $userid = $decodeData->userid;

        try{
            $saveDeviceKey = $pushNotificationObj->saveDeviceKey($deviceid,$type,$siteid,$userid);    
            return response($saveDeviceKey,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
        

    }


    public function savePushKey()
    {
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $pushNotificationObj = new PushNotification();


        $device = $decodeData->device;
        $os = $decodeData->os;
        $pushkey = $decodeData->pushkey;
        $userid = $decodeData->userid;

        
        try{
            $savePushKey = $pushNotificationObj->savePushKey($pushkey,$os,$device,$userid);
            return response($savePushKey,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }

    }


}    