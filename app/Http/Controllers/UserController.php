<?php

// FileName                     : UserController.php                 
// Author               : Sameer Deshpande                    
// Date of Creation     : 26/09/2017                        
// Description          : User Controller                   
//                          
// Last Modified By         :                        
// Last Modified On     :                       
// Modifications Done       :                   
//                          
// +--------------------------------------------------------------------------------------------------+//                       

namespace App\Http\Controllers;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    /* This function is to validate user in the system*/
    public function validateUser()
    {
        // data = {"user_id":"2","email":"2","password":"werty","pushkey":"","device":"ios"}    
        $userObj = new User();
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        
        $pushkey = $decodeData->pushkey;
        $device = $decodeData->device;
        $email = $decodeData->email; 


        try{
                $getUser = $userObj->checkUser($email);

                if(count($getUser) == 0)
                    return response("No User Found",200);        

                $updateUser = $userObj->updateUserLog($pushkey,$device,$getUser[0]->userid); 
                return response($updateUser,200);               
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
    }

    public function show()
    {
        $userObj = new User();
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;

        $listUsers = $userObj->getUsers();

        if(count($listUsers) > 0){
                
                return array("status" => "success", "data" => $listUsers, "message" => "User List");
            }
            else{
                return array("status" => "fail", "data" => null, "message" => "No User Found");
            }

    }

    public function getUserPost()
    {
        //data = {"userid":"2"}
        $userObj = new User();
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;

        try{
            $getUserPost = $userObj->getUserPost($userid);    
            return response($getUserPost,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
        

    }


    public function getUserCourses()
    {
        //data = {"userid":"2"}
        $userObj = new User();
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$userid = $_GET['userid'];
        $userid = $decodeData->userid; 

        try{
            $getUserCourses = $userObj->getUserCourse($userid);    
            return response($getUserCourses,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    
    }

    public function getSchools()
    {
        //data = {"schoolid":"2"}
        $userObj = new User();
        $data = $_POST["data"];
        $decodeData = json_decode($data);
        //$userid = $_GET['userid'];
        $schoolid = 0;

        if(isset($decodeData->schoolid))
            $schoolid = $decodeData->schoolid;

        try{
            $getSchools = $userObj->getSchools($schoolid);    
            return response($getSchools,200);
        }
        catch(\Exception $e)
        {
            return response("Bad Request. Please try again",400);
        }
    }

}
