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

use App\Model\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class ProfileController extends Controller
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


    /*Upload user profile picture*/
    public function uploadProfilePic()
    {
        $userid = $_POST['userid'];
        $target_dir = "profilePic/";
        
        $newfilename = $target_dir.$_POST['userid'] . '.jpg';
        if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename)) {
            $sql = "update users set imageStatus = 1 where userid = ".$userid;
            $retval = mysqli_query($con, $sql);
        
            if(! $retval ){
              die('Could not enter data: ' . mysql_error());
            }
            
            echo json_encode([
                "Message" => "The file ". basename($newfilename). " has been uploaded.",
                "Status" => "OK",
            ]);
        } else {
            file_put_contents($newfilename, base64_decode($_POST['userfile']));
            /*echo json_encode([
                "Message" => "Sorry, there was an error uploading your file.",
                "Status" => "Error",
                "FilePath" => $newfilename,
            ]);*/
        }
    }

}
