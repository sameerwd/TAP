<?php

// FileName             : AssignmentController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Assignment Controller                   
//                          
// Last Modified By         :                        
// Last Modified On     :                       
// Modifications Done       :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use Model\Assignment;
use Model\PushNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AssignmentController extends Controller
{

    Assignment $assignmentObj = new Assignment();
    PushNotification $pushNotification = new PushNotification();
    /*
    |--------------------------------------------------------------------------
    | Assignment Controller
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


    /* This function creates a new assignment*/
    public function create()
    {

        // data = {"userid":"2","search_type":"basic_search", "duedate":"", "courseid":"2"}    
        
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;
        $login_key = \Session::getId(); 

        $duedate = $data['duedate'];
        $userid = $data['userid'];
        $courseid = $data['courseid'];        

        $createAssignment = $assignmentObj->createAssignment($data);

                if(!$createAssignment){
                  
                    return array("status" => "fail", "data" => null, "message" => "Could not create assignment");
                }
                else{
                        $notify = $pushNotification->sendPostNotfication($userid,$courseid);

                return array("status" => "success", "data" => $createAssignment, "message" => "Assignment created successfully");
                }
    
    }

}
