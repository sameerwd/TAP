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
use Illuminate\Http\Request;

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
    public function validateUser(Request $request)
    {
        // data = {"user_id":"2","email":"2","password":"werty","pushkey":"","device":"ios"}    
        $userObj = new User();
        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        
        $pushkey = $decodeData->pushkey;
        $device = $decodeData->device;
        $email = $decodeData->email; 

        try{
                $getUser = $userObj->checkUser($email);

                if(count($getUser) == 0)
                    return response("No User Found",208);        

                $updateUser = $userObj->updateUserLog($pushkey,$device,$getUser[0]->userid); 
                return response($updateUser,200);               
        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
    }

    public function show(Request $request)
    {
        $userObj = new User();
        $data = json_encode($request->input());
        $decodeData = json_decode($data);
        $user_id = Auth::user()->id;

        $listUsers = $userObj->getUsers();

        if(count($listUsers) > 0){
                return response($listUsers,200);
            }
            else{
                return response('Not Found',210);
            }

    }

    public function getUserPost(Request $request)
    {
        //data = {"userid":"2"}
        $userObj = new User();
        $data = json_encode($request->input());
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


    public function getUserCourses(Request $request)
    {
        //data = {"userid":"2"}
        $userObj = new User();
        $data = json_encode($request->input());
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

    public function getSchools(Request $request)
    {
        //data = {"schoolid":"2"}
        $userObj = new User();
        $data = json_encode($request->input());
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

    public function updateProfile(Request $request)
    {
        $userObj = new User();
        $data = json_encode($request->input());
        $decodeData = json_decode($data);

        $first_name = $decodeData->first_name;
        $last_name = $decodeData->last_name;
        $userid = $decodeData->userid;
        $password = $decodeData->password;

        try{

            if(isset($password) && $password != "")
                $updateArray = array("firstname" => $first_name, "lastname" => $last_name, "password" => bcrypt($password));
            else
                $updateArray = array("firstname" => $first_name, "lastname" => $last_name);

            $getUpdateProfile = $userObj->updateUserProfile($updateArray,$userid);

            return response()->json(['message' => 'Profile Updated', 'status' => 200]); 
        }
        catch(\Exception $e)
        {
            return response($e,400);   
        }

    }

    public function uploadProfilePic(Request $request)
    {
        $userObj = new User();
        $data = json_encode($request->input());
        $decodeData = json_decode($data);

        $userid = $decodeData->userid;
        $userFile = $decodeData->userFile;
        $target_dir = "/profilePic/";
        
        $newfilename = public_path().$target_dir.$userid.'.jpg';

        try{

            if(file_put_contents($newfilename, base64_decode($userFile)))
            {
                $updateProfileStatus = $userObj->updateProfileImageStatus($userid);
                return response()->json(['message' => 'Profile Picture Updated', 'status' => 200]);
            }
            else{
                return response()->json(['message' => 'Error uploading picture, please try again', 'status' => 400]); 
            }

        }
        catch(\Exception $e)
        {
            return response($e,400);
        }
        
    }

}
