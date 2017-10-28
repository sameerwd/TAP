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

use Model\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class CourseController extends Controller
{

    Course $courseObj = new Course();
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
            $courseObj->getCourseController();
    }


    /* This function updates the student course details*/  //TODO Check for the functionality with Upendra.
    public function updateStudentCourse()
    {
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
        $user_id = Auth::user()->id;
        $login_key = \Session::getId();

        $courses = explode(",", $data['courses']);
        $codes = array();
            foreach($courses as $course) {
                $result = $courseObj->checkValidCourseId($course);
                //      echo $sqlCheckValidCourseID;
                if (count($result) > 0)
                {                
                    $createStudentCourse = $courseObj->createStudentCourse($course,$data['user_id']);
                }
            }
    }


    /* This function creates a new course*/
    public function create()
    {
        // data = {"user_id":"2","search_type":"basic_search", "courses":1,2,3,4} course_ids  
        
        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;
        $login_key = \Session::getId();

        $courses = explode(",", $data['courses']);

        $codes = array();
        foreach($courses as $course) {
            if(strlen($course)>0){
                
                $createCourse = $courseObj->createCourse($course);
            }
        }
    }

    /* This function is used to update a course */
    public function update()
    {
        // data = {"user_id":"2", "ucid":"2", "scid":"3","search_type":"basic_search", "courses":1,2,3,4} course_ids  

        $data       = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;
        $login_key = \Session::getId();

    $userid = $data['userid'];;
    $ucid = $data['ucid'];
    $scid = $data['scid'];
    
    $result = $courseObj->checkValidCourseId($ucid);
    
    if (count($result) > 0){

            $resultStudentCourse = $courseObj->checkValidStudentCourseId($ucid,$userid);
            
            if (count($result) > 0){

                    $updateCourse = $courseObj->updateStudentCourse($ucid,$scid);
                    echo json_encode([
                        "status" => "success",
                    ]);
                }
                else{
                    echo json_encode([
                        "status" => "CourseID already registered for user",
                    ]);
                }
            
    }
    else{
            echo json_encode([
                "status" => "Invalid CourseID, please verify with your Instructor",
            ]);
        }

}
