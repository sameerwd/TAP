<?php

// FileName             : StudentController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Student Controller                   
//                          
// Last Modified By     :                        
// Last Modified On     :                       
// Modifications Done   :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use App\Model\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
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

    public function delete()
    {
        // data = {"userid":"2","scid":"2"}    
        $studentObj = new Student();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $scid = $decodeData->scid;        

        $deleteStudentCourse = $studentObj->deleteStudentCourse($scid);

                if(!$deleteStudentCourse){
                  
                    return array("status" => "fail", "data" => null, "message" => "Could not delete course");
                }
                else{

                    return array("status" => "success", "data" => null, "message" => "Student course deleted successfully");
                }
     
    }

    public function getStudentCourses()
    {
        // data = {"userid":"2","scid":"2"}    
        $studentObj = new Student();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $userid = $decodeData->userid;        

        $getStudentCourses = $studentObj->getStudentCourse($userid);

                if(!$getStudentCourses){
                  
                    return array("status" => "fail", "data" => null, "message" => "No course found, please add course to see your peers");
                }
                else{

                    return array("status" => "success", "data" => null, "message" => "Student Courses");
                }
    }

    public function getStudents()
    {
        $studentObj = new Student();

        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $userid = $decodeData->userid;        

        $arrUserCourse = array();
        $getUserCourseIds = $studentObj->getUserCourseIds($userid);

        for($i = 0;$i < count($getUserCourseIds); $i++)
        {
            $arrUserCourse[$i] = $getUserCourseIds[$i]->ucid; 
        }

        $getStudents = $studentObj->getStudents($userid,$arrUserCourse);

        if(!$getStudents){
                  
                    return response("No Student Found",208);
                }
                else{

                    return response($getStudents,200);
                }
    }

    public function createStudentCourse()
    {

        $studentObj = new Student();

        //$data = "{"userid:"","courses":"2,3,4,5"}";
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId(); 

        $coursesArr = array();

        for($i=0;$i < count($decodeData->courses);$i++)
        {
            $coursesArr[$i] = $decodeData[$i]->courses;
        }

        $courses = explode(",", $coursesArr);        

        $arrUserCourse = array();
        foreach($courses as $courseid) { //TODO optimize

        $sqlCheckValidCourseID = $studentObj->getUserCourse($courseid);
        if(count($sqlCheckValidCourseID) > 0)
                $createStudent = $studentObj->createStudentCourse($decodeData->userid,$courseid);
        }

        if(!$createStudent){
                    return array("status" => "fail", "data" => null, "message" => "Student not registered");
                }
                else{
                    return array("status" => "success", "data" => null, "message" => "Student registered successfully");
                }
    }    

}
