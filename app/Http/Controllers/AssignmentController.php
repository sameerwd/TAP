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

        //data = {"userid":"2","search_type":"basic_search", "duedate":"", "courseid":"2","title":"wqeerd","description":"asdasd"}    
        $assignmentObj = new Assignment();
        $pushNotification = new PushNotification();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $duedate = $decodeData->duedate;
        $userid = $decodeData->userid;
        $courseid = $decodeData->courseid;       

            try{
                    $checkDuplicateAssignment = $assignmentObj->checkDuplicateAssignment($decodeData->title,$user_id);

                    if($checkDuplicateAssignment == 0)
                    {
                        $createAssignment = $assignmentObj->createAssignment($decodeData);

                        $notify = $pushNotification->sendPostNotfication($userid,$courseid);    
                        return response($createAssignment,200);
                    }
                    else
                        return response('Assignment already exists',205);
            }
            catch(\Exception $e)
            {
                return response($e,400);
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
        
        // Check if there are results
        try{

            $getAssignment = $assignmentObj->getAssignmentList($userType,$courseid,$userid);
            return response($getAssignment,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }         
    }

    public function listAssignmentByMonth()
    {

        $assignmentObj = new Assignment();

        //$data = '{"month":"2", "userid": "2","year":"3"}';
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        

        $month = $decodeData->month;
        $userid = $decodeData->userid;
        $year = $decodeData->year;
    
        $getAssignment = $assignmentObj->getAssignmentByMonth($month,$year,$userid);
        
        // Check if there are results
        try{

            $getAssignment = $assignmentObj->getAssignmentByMonth($month,$year,$userid);
            return response($getAssignment,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
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

        try{

            if(isset($assignmentId) && $assignmentId != "")
            {
                $checkAssignmentExists = $assignmentObj->getAssignmentById($assignmentId);
                    
                if($checkAssignmentExists == 0)
                    return response("No Assignments Found",200);
   
                $deleteAssignment = $assignmentObj->deleteAssignment($assignmentId);    
                return response("Assignment Deleted Successfully",200);
            }
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }

    public function getAssignmentByDate()
    {

        $assignmentObj = new Assignment();

        //$data = '{"duedate":"12-23-2017", "userid": "2","year":"3"}';
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;

        $userid = $decodeData->userid;
        $duedate = $decodeData->duedate;

        try{

            $getAssignmentByDate = $assignmentObj->getAssignmentByDate($userid,$duedate);
            return response($getAssignmentByDate,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
                
    }

    public function updateAssignment()
    {

        $assignmentObj = new Assignment();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $duedate = $decodeData->duedate;
        $title = $decodeData->title;
        $courseid = $decodeData->courseid;
        $assignmentid = $decodeData->assignmentid;
        $detail = $decodeData->detail;        

        try{
            $checkAssignmentExists = $assignmentObj->getAssignmentById($assignmentid);
                    
                if($checkAssignmentExists == 0)
                    return response("No Assignments Found",200);
                
            $updateAssignment = $assignmentObj->updateAssignment($title,$detail,$duedate,$courseid,$assignmentid);
            return response($updateAssignment,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
        
    }


    public function getFriends()
    {

        $assignmentObj = new Assignment();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $userid = Auth::user()->id;
        //$login_key = \Session::getId(); 
        $duedate = $decodeData->duedate;
        $title = $decodeData->title;
        $courseid = $decodeData->courseid;
        $assignmentid = $decodeData->assignmentid;
        $detail = $decodeData->detail;        

        try{
            $updateAssignment = $assignmentObj->updateAssigment($title,$detail,$duedate,$courseid,$assignmentid);
            return response($updateAssignment,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }


        $sql = "SELECT ucid FROM student_course where userid = ".$userid;
//  echo $sql;die;
    $arrUserCourse = array();
    if ($result = mysqli_query($con, $sql))
    {
        if($result->num_rows>0){
            while($row = $result->fetch_array(MYSQLI_NUM))
            {
                array_push($arrUserCourse,$row[0]);
            }
            $arrUsers = array();
            
            $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM user_course, users where users.userid!=".$userid." and users.userid= user_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
            $tempArray = array();
            if ($result = mysqli_query($con, $sql))
            {
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $tempArray = $row;
                    array_push($arrUsers, $tempArray);
                }
            }
            $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
            $tempArray = array();
            if ($result = mysqli_query($con, $sql))
            {
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $tempArray = $row;
                    array_push($arrUsers, $tempArray);
                }
            }
            echo json_encode($arrUsers);
        }
        else{
            $sql = "SELECT ucid FROM user_course where userid = ".$userid;
            $arrUserCourse = array();
            if ($result = mysqli_query($con, $sql)){
                if($result->num_rows>0){
                    while($row = $result->fetch_array(MYSQLI_NUM))
                    {
                        array_push($arrUserCourse,$row[0]);
                    }
            
                    $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
                    $arrUsers = array();
                    $tempArray = array();
                    if ($result = mysqli_query($con, $sql))
                    {
                        while($row = $result->fetch_array(MYSQLI_ASSOC))
                        {
                            $tempArray = $row;
                            array_push($arrUsers, $tempArray);
                        }
                    }
                    echo json_encode($arrUsers);
                }
                else{
                    echo json_encode([
                        "status" => "error",
                        "message" => "No course found, please add course to see your peers",
                    ]);
                }
            }
        }
    }
    else{
        echo json_encode([
                "status" => "error",
                "message" => "No course found, please add course to see your peers",
            ]);
    }
    }
}
