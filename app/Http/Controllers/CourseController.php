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

use App\Model\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class CourseController extends Controller
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


    /* This function lists the current student courses*/
    public function listStudentCourses()
    {
            $data       = $_POST["data"];
            $decodeData = json_decode($data);
            //$user_id = Auth::user()->id;
            //$login_key = \Session::getId();
            $courseObj = new Course();
            $user_id = $decodeData->user_id;
            $ucid = $decodeData->ucid;

            try{
                    $getStudentCourses = $courseObj->getStudentCourse($user_id,$ucid);
                    return response($getStudentCourses,200);
            }
            catch(\Exception $e)
            {
                return response($e,400);
            }
    }


    /*This function lists instructor courses*/
    public function listInstructorCourses()
    {
            $data       = $_POST["data"];
            $decodeData = json_decode($data);
            //$user_id = Auth::user()->id;
            //$login_key = \Session::getId();
            $courseObj = new Course();
            $user_id = $decodeData->user_id;

            try{
                    $getInstructorCourses = $courseObj->getInstructorCourse($user_id);
                    return response($getInstructorCourses,200);
            }
            catch(\Exception $e)
            {
                return response($e,400);
            }
    }


    /* This function updates the student course details*/  //TODO Check for the functionality with Upendra.
    public function updateStudentCourse()
    {
          $courseObj = new Course();
          $course = $_GET['ucid'];
    
        $sqlCheckValidCourseID = "SELECT ucid FROM user_course where ucid =".$course." and expirydate >= CURDATE()";
        if ($result = mysqli_query($con, $sqlCheckValidCourseID))
        {
            if($result->num_rows>0){//valid ucid
                $sqlIfExistingCourseID = "SELECT * FROM student_course where ucid =".$course." and userid = ".$_GET['userid'];
                if ($result = mysqli_query($con, $sqlIfExistingCourseID)){
                    if($result->num_rows>0){
                            echo json_encode([
                            "status" => "CourseID already registered for user",
                        ]);
                    }
                    else{
                        $sql = "insert into student_course(userid, ucid) values(".$_GET['userid'].",".$course.")";

                        $retval = mysqli_query($con, $sql);
                        $codes[] = mysqli_insert_id($con);
                        echo json_encode([
                                "status" => "success",
                            ]);
                    }
                }
            }
            else{
                echo json_encode([
                        "status" => "Invalid CourseID",
                    ]);
            }
        }  
    }

    /* This function creates a course for student*/

    public function createStudentCourse()
    {

        // data = {"user_id":"2","search_type":"basic_search", "courses":1,2,3,4} course_ids  
                
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $courses = explode(",", $data['courses']);
        $codes = array();

            try{
                foreach($courses as $course) {
                    $result = $courseObj->checkValidCourseId($course);
                    //      echo $sqlCheckValidCourseID;
                    if (count($result) > 0)
                    {                
                        $createStudentCourse[] = $courseObj->createStudentCourse($course,$data['user_id']);
                    }
                }

                return response(1,200);
            }catch(\Exception $e)
            {
                return response($e,400);
            }
    }


    /* This function creates a new course*/
    public function create()
    {
        // data = {"user_id":"2","search_type":"basic_search", "courses":1,2,3,4, "expirydate":""} course_ids  
        
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();
        $courses = explode(",", $decodeData->courses);
        $codes = array();

        try{
        foreach($courses as $course) {
            if(strlen($course)>0){
                
                $createCourse[] = $courseObj->createCourse($course,$decodeData);
            }
        }
            return response(1,200);
        }catch(\Exception $e)
        {
            return response($e,400);
        }


    }

    /* This function is used to update a course */
    public function updateCourse()
    {
        // data = {"user_id":"2", "ucid":"2", "scid":"3","search_type":"basic_search", "courses":1,2,3,4} course_ids  

        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();
        $userid = $decodeData->user_id;
        $ucid = $decodeData->ucid;
        $scid = $decodeData->scid;
    
    $result = $courseObj->checkValidCourseId($ucid);
    
    if (count($result) > 0){

            $resultStudentCourse = $courseObj->checkValidStudentCourseId($ucid,$userid);
            
            if (count($result) > 0){

                    $updateCourse = $courseObj->updateStudentCourse($ucid,$scid);
                    
                    return response($updateCourse,200);
                }
                else{
                    return response('Already Exists',205);
                }
            
    }
    else{
            return response('Invalid',400);
        }

    }

    public function updateInstructorCourse()
    {
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();
        
        $userid = $decodeData->user_id;
        $ucid = $decodeData->ucid;
        $course = $decodeData->course;
        $expiry = $decodeData->expiry;
    
        try{
            $updateInstructorCourse = $courseObj->updateInstructorCourse($course,$expiry,$userid,$ucid);
            return response($updateInstructorCourse,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
        
    }

    public function resetCourse()
    {
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $ucid = $decodeData->ucid;
        $expiry = $decodeData->expiry;

        $deleteCourse = $courseObj->deleteStudentCourse($ucid);
        
         if($deleteCourse){  
                $updateCourse = $courseObj->resetStudentCourse($ucid); 
                return array("status" => "success", "data" => null, "message" => "Course Reset Successfully");
            }
            else{
                return array("status" => "fail", "data" => null, "message" => "Cannot Reset Course");
            }
    }

}
