<?php

// FileName             : CourseController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : Course Controller                   
//                          
// Last Modified By     :                        
// Last Modified On     :                       
// Modifications Done   :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use App\Model\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    public function listStudentCourses(Request $request)
    {
            $data       = json_encode($request->input());
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
    public function listInstructorCourses(Request $request)
    {
            $data       = json_encode($request->input());
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
    public function updateStudentCourse(Request $request)
    {
          $courseObj = new Course();
          $data = json_encode($request->input());
          $decodeData = json_decode($data);

          $course = $decodeData->course;
          $user_id = $decodeData->user_id;
    
          $sqlCheckValidCourseID = $courseObj->checkValidCourseId($course);


            if(count($sqlCheckValidCourseID) > 0)
            {
                $updateStudentCourse = $courseObj->updateStudentCourse($user_id,$course);
                return response($updateStudentCourse,200);
            }
            else{
                return response("Invalid Course ID",209);
            }
    }  

    /* This function creates a course for student*/

    public function createStudentCourse(Request $request)
    {

        // data = {"user_id":"2", "courses":"1"} course_ids  
                
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $courses = $decodeData->courses;
        $user_id = $decodeData->user_id;

            try{
                    $result = $courseObj->checkValidCourseId($courses);
                    $checkStudentCourse = $courseObj->checkStudentCourse($courses,$user_id);
                    //      echo $sqlCheckValidCourseID;
                    if (count($result) > 0 && count($checkStudentCourse) == 0)
                    {                
                        $saveStudentCourse = $courseObj->createStudentCourse($courses,$user_id);
                        return response(1,200);
                    }
                    else
                        return response("Course does not exist/Already added",206);
                    
            }catch(\Exception $e)
            {
                return response($e,400);
            }
    }


    /* This function creates a new course*/
    public function create(Request $request)
    {
        // data = {"user_id":"2", "courses":"SA", "expirydate":""} course_ids  
        
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();
        $courses = $decodeData->courses;
        $user_id = $decodeData->user_id;
        $codes = array();

        try{
                $checkCourse = $courseObj->checkInstructorCourse1($courses);
                if($checkCourse == 0)
                {        
                    $createCourse = $courseObj->createCourse($courses,$decodeData);
                    return response(1,200);
                }
                else
                    return response('Course already exists',205);
        }catch(\Exception $e)
        {
            return response($e,400);
        }


    }

    /* This function is used to update a course */
    public function updateCourse(Request $request)
    {
        // data = {"user_id":"2", "ucid":"2", "scid":"3","search_type":"basic_search", "courses":"2"} course_ids  

        $data       = json_encode($request->input());
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
                    return response('Course already exists',205);
                }
    }
    else{
            return response('Invalid',400);
        }

    }

    public function updateInstructorCourse(Request $request)
    {
        $data       = json_encode($request->input());
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

    public function resetCourse(Request $request)
    {
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $ucid = $decodeData->ucid;
        $expiry = $decodeData->expiry;

        try{
            $deleteCourse = $courseObj->deleteStudentCourse($ucid);
        
         if($deleteCourse){  
                $updateCourse = $courseObj->resetStudentCourse($ucid); 
                return response($updateCourse,200); 
            }
            else{
                return response("Course not found/deleted",207);
            }
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }       
    }

    public function deleteCourse(Request $request)
    {
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $ucid = $decodeData->ucid;
        $user_id = $decodeData->user_id;
        $course = $decodeData->course;

        try{
            $checkCourse = $courseObj->checkStudentCourse($ucid,$user_id);
        
         if($checkCourse > 0){
                
                $deleteCourse = $courseObj->deleteStudentCourse($ucid,$user_id,$course);       
                return response($deleteCourse,200); 
            }
            else{
                return response("Course not found/deleted",207);
            }
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }       
    }

    public function deleteInstructorCourse(Request $request)
    {
        $data       = json_encode($request->input());
        $decodeData = json_decode($data);
        //$user_id = Auth::user()->id;
        //$login_key = \Session::getId();
        $courseObj = new Course();

        $user_id = $decodeData->user_id;
        $course = $decodeData->course;

        try{
            $checkCourse = $courseObj->checkInstructorCourse($course);
        
         if($checkCourse > 0){
                
                $deleteCourse = deleteInstructorCourse($checkCourse);       
                return response($deleteCourse,200); 
            }
            else{
                return response("Course not found/deleted",207);
            }
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }       
    }

}
