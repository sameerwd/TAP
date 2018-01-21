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
use Illuminate\Http\Request;
use DB;

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
    public function create(Request $request)
    {

        //data = {"userid":"2","search_type":"basic_search", "duedate":"", "courseid":"2","title":"wqeerd","description":"asdasd"}    
        $assignmentObj = new Assignment();
        $pushNotification = new PushNotification();

        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $duedate = $decodeData->duedate;
        $userid = $decodeData->userid;
        $courseid = $decodeData->courseid;       

            try{
                    $checkDuplicateAssignment = $assignmentObj->checkDuplicateAssignment($decodeData->title,$userid);

                    if($checkDuplicateAssignment == 0)
                    {
                        $createAssignment = $assignmentObj->createAssignment($decodeData);

                        //$notify = $pushNotification->sendPostNotfication($userid,$courseid);    
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
    public function listAssignment(Request $request)
    {
        $assignmentObj = new Assignment();

        //$data = '{"usertype":"2", "userid": "2","courseid":"3"}';
        $data = json_encode($request->input());
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

    public function listAssignmentByMonth(Request $request)
    {

        $assignmentObj = new Assignment();

        //$data = '{"month":"2", "userid": "2","year":"3"}';
        $data = json_encode($request->input());
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

    public function deleteAssignment(Request $request)
    {

        $assignmentObj = new Assignment();

        //$data = '{"month":"student", "userid": "2","year":"3"}';
        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        $assignmentId = $decodeData->assignmentId;

        try{

            if(isset($assignmentId) && $assignmentId != "")
            {
                $checkAssignmentExists = $assignmentObj->getAssignmentById($assignmentId);
                    
                if($checkAssignmentExists == 0)
                    return response("No Assignments Found",201);
   
                $deleteAssignment = $assignmentObj->deleteAssignment($assignmentId);    
                return response("Assignment Deleted Successfully",200);
            }
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }

    public function getAssignmentByDate(Request $request)
    {

        $assignmentObj = new Assignment();

        //$data = '{"duedate":"12-23-2017", "userid": "2","year":"3"}';
        $data = json_encode($request->input());
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

    public function updateAssignment(Request $request)
    {

        $assignmentObj = new Assignment();

        $data = json_encode($request->input());
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
                    return response("No Assignments Found",201);
                
            $updateAssignment = $assignmentObj->updateAssignment($title,$detail,$duedate,$courseid,$assignmentid);
            return response($updateAssignment,200);
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
        
    }


    public function getFriends(Request $request)
    {

        $assignmentObj = new Assignment();

        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        //$userid = Auth::user()->id;
        //$login_key = \Session::getId(); 
        
        $userid = $decodeData->userid;        

        try{

        $sql = "SELECT ucid FROM student_course where userid = ".$userid;
        $getUserCourses = DB::select($sql);

        $arrUserCourse = array();
        if (count($getUserCourses) > 0)
        {
        
            foreach($getUserCourses as $userCourses)
            {
                array_push($arrUserCourse,$userCourses->ucid);
            }
            $arrUsers = array();
            
            $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM user_course, users where users.userid!=".$userid." and users.userid= user_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";

            $getUserInfo = DB::select($sql);

            if (count($getUserInfo) > 0)
            {
                foreach($getUserInfo as $users)
                {
                    array_push($arrUsers, $users);
                }
            }
            $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";

            $getStudentInfo = DB::select($sql);

            
            if(count($getStudentInfo) > 0)
            {
                foreach($getStudentInfo as $students)
                {
                    array_push($arrUsers, $students);
                }
            }
            
            return response($arrUsers,200);
        }
        else{
            
                $sql = "SELECT ucid FROM user_course where userid = ".$userid;
                $getUserCourses = DB::select($sql);

                $arrUserCourse = array();
                if (count($getUserCourses) > 0)
                {
        
                    foreach($getUserCourses as $userCourses)
                    {
                        array_push($arrUserCourse,$userCourses->ucid);
                    }
                
                    $arrUsers = array();
            
                    $sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";

                    $getUserInfo = DB::select($sql);

                    if (count($getUserInfo) > 0)
                    {
                        foreach($getUserInfo as $users)
                        {
                            array_push($arrUsers, $users);
                        }
                    }
                    return response($arrUsers,200);
                }
                else{
                    return response()->json(['message' => 'Friends not found', 'data' => null, 'status' => 207]);
                }
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'Bad Request. Please try again', 'data' => null, 'status' => 400]);
        }
    
    }

}
