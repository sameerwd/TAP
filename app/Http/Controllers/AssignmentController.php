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

use App\Model\Assignment;
use App\Model\PushNotification;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AssignmentController extends Controller
{

    
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
        $assignmentObj = new Assignment();
        $pushNotification = new PushNotification();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $duedate = $decodeData->duedate;
        $userid = $decodeData->userid;
        $courseid = $decodeData->courseid;        

        $createAssignment = $assignmentObj->createAssignment($data);

                if(!$createAssignment){
                  
                    return array("status" => "fail", "data" => null, "message" => "Could not create assignment");
                }
                else{
                        $notify = $pushNotification->sendPostNotfication($userid,$courseid);

                    return array("status" => "success", "data" => $createAssignment, "message" => "Assignment created successfully");
                }
    
    }


    /*
        List the assignments    
    */
    public function listAssignment()
    {
        $assignmentObj = new Assignment();

        //$data = '{"usertype":"2", "userid": "2","courseid":"3"}';
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        

        $userType = $decodeData->usertype;
        $userid = $decodeData->userid;
        $courseid = $decodeData->courseid;
    
    
    
        $getAssignment = $assignmentObj->getAssignmentList($userType,$courseid,$userid);
        
        // Check if there are results
        if ($getAssignment != null && count($getAssignment) > 0)
        {
            // Finally, encode the array to JSON and output the results
            return array("status" => "success", "data" => $getAssignment, "message" => "Assignment List");
        }
        else
        {
            return array("status" => "fail", "data" => null, "message" => "No assignments found");
        }         
    }

    public function listAssignmentByMonth()
    {

        $assignmentObj = new Assignment();

        //$data = '{"month":"student", "userid": "2","year":"3"}';
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        

        $month = $decodeData->month;
        $userid = $decodeData->userid;
        $year = $decodeData->year;
    
        $getAssignment = $assignmentObj->getAssignmentByMonth($month,$year,$userid);
        
        // Check if there are results
        if ($getAssignment != null && count($getAssignment) > 0)
        {
            // Finally, encode the array to JSON and output the results
            return array("status" => "success", "data" => $getAssignment, "message" => "Assignment List");
        }
        else
        {
            return array("status" => "fail", "data" => null, "message" => "No assignments found");
        }
    
    }

    public function deleteAssignment()
    {

        $assignmentObj = new Assignment();

        //$data = '{"month":"student", "userid": "2","year":"3"}';
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        $assignmentId = $decodeData->assignmentId;

        if(isset($assignmentId) && $assignmentId != "")
        {
            $checkAssignmentExists = $assignmentObj->checkAssignment($assignmentId);

            if($checkAssignmentExists == 0)
                return array("status" => "success", "data" => null, "message" => "No assignments found");
        }

        $deleteAssignment = $assignmentObj->deleteAssignment($assignmentId);    
        
        if($deleteAssignment)
            return array("status" => "success", "data" => null, "message" => "Assignment deleted");   
    }
}
