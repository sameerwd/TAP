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

use Model\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class CourseController extends Controller
{

    Course courseObj = new Course;
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
            courseObj->getCourseController();
    }


    /* This function updates the student course details*/
    public function updateStudentCourse()
    {

    }

    /* This function creates a course for student*/

    public function createStudentCourse()
    {

    }


    /* This function creates a new course*/
    public function create()
    {
        
    }

}
