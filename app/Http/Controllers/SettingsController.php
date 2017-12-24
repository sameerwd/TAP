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

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Model\SystemUpdates;
use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
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


    public function getTAPPosts(Request $request)
    {
        
        $data = json_encode($request->input());

        $decodeData = json_decode($data);

        $announcementType = $decodeData->announcementType;
        $userid = $decodeData->userid;
        $userType = 1;
        $sql = "";
        $recNum = 0;
        $pageItemsCount = 30;
        $arrPosts = array();
    
        if($announcementType==2){//show instructor posts
        $sql = "SELECT s.ucid FROM student_course s JOIN user_course u on s.ucid = u.ucid and s.userid = ".$userid." and u.expirydate >= CURDATE()";

        $getUserCoursePost = DB::select($sql);

        $arrUserCourse = array();
        
        if(count($getUserCoursePost) > 0)
        {
                foreach($getUserCoursePost as $userCoursePost)
                {
                    array_push($arrUserCourse,$userCoursePost->ucid);
                }

                $sql = "SELECT distinct userid FROM user_course where ucid in (".implode(',',$arrUserCourse).") ORDER BY userid";
                $getUserId = DB::select($sql);

                $arrUserID = array();
                if (count($getUserId) > 0)
                {
                    foreach($getUserId as $userId)
                    {
                        array_push($arrUserID,$userId->userid);
                    }
                    
                    $sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
                    COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
                    FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid order by p.postid desc limit ".$recNum.",".$pageItemsCount;

                    $getInstructorTAPPosts = DB::select($sql); 
                
                    
                    if (count($getInstructorTAPPosts) > 0)
                    {
                        foreach($getInstructorTAPPosts as $instructorPost)
                        {
                            array_push($arrPosts, $instructorPost);
                        }
                        return response()->json(['message' => 'TAP Posts', 'data' => $arrPosts, 'status' => 200]);
                    }

                    return response()->json(['message' => 'No User Found', 'status' => 1013]);
                } 
        }
        else{
            return response()->json(['message' => 'No Courses Found', 'status' => 1007]);
        }
    }
    else{
        $sql = "SELECT ucid FROM student_course where userid = ".$userid;
        $getUserCoursePost = DB::select($sql);

        $arrUserCourse = array();
        
           if(count($getUserCoursePost) > 0){
                foreach($getUserCoursePost as $userCoursePost)
                {
                    array_push($arrUserCourse,$userCoursePost->ucid);
                }
            
                $sql = "SELECT distinct userid FROM student_course where ucid in (".implode(',',$arrUserCourse).") ORDER BY userid";
                

                $arrUserID = array();

                $getUserId = DB::select($sql);

                $arrUserID = array();
                if (count($getUserId) > 0)
                {
                    foreach($getUserId as $userId)
                    {
                        array_push($arrUserID,$userId->userid);
                    }
        
                $sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
                COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
                FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;
                //echo $sql;die;
                
                $getTAPPosts = DB::select($sql); 
                
                    
                    if (count($getTAPPosts) > 0)
                    {
                        foreach($getTAPPosts as $tapPost)
                        {
                            array_push($arrPosts, $tapPost);
                        }
                        return response()->json(['message' => 'TAP Posts', 'data' => $arrPosts, 'status' => 200]);
                    }

                    return response()->json(['message' => 'No Posts Found', 'status' => 1012]);
                }

                return response()->json(['message' => 'No User Found', 'status' => 1013]);

            }
            else{
                $sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
                COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
                FROM posts p, users u where u.userid = p.userid and u.userid = ".$userid." and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;

                $getTAPPosts = DB::select($sql); 
                
                    
                    if (count($getTAPPosts) > 0)
                    {
                        foreach($getTAPPosts as $tapPost)
                        {
                            array_push($arrPosts, $tapPost);
                        }
                        return response()->json(['message' => 'TAP Posts', 'data' => $arrPosts, 'status' => 200]);
                    }
                return response()->json(['message' => 'No Posts Found', 'status' => 1012]);    
            }
        }

        /*$userType = 1;
        $sql = "";

        if(isset($_GET['userid'])){
            $userid = $_GET['userid'];
            $sql = "SELECT p.*,COALESCE((SELECT COUNT( * ) FROM comments WHERE postid = p.postid ), 0 ) AS cnt, COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS `name` FROM posts p JOIN comments c ON p.userid = ".$userid." and userType = ".$userType." group by p.postid order by postid desc";
            }
        else{
            $sql = "SELECT p.*,COALESCE((SELECT COUNT( * ) FROM comments WHERE postid = p.postid ), 0 ) AS cnt, COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS `name` FROM posts p LEFT JOIN comments c ON p.postid = c.postid and userType = ".$userType." group by p.postid order by postid desc";
        }

        if ($result = mysqli_query($con, $sql))
        {
            // If so, then create a results array and a temporary one
            // to hold the data
            $resultArray = array();
            $tempArray = array();
 
            // Loop through each row in the result set
            while($row = $result->fetch_object())
            {
                // Add each row into our results array
                $tempArray = $row;
                array_push($resultArray, $tempArray);
            }
         
            // Finally, encode the array to JSON and output the results
            echo json_encode($resultArray);
        }*/
    }

    public function getTAPInstructorPosts(Request $request)
    {
        $data = json_encode($request->input());

        $decodeData = json_decode($data);

        $announcementType = $decodeData->announcementType;
        $userid = $decodeData->userid;
        $sql = "";
        $recNum = 0;
        $pageItemsCount = 30;

        if($announcementType==1){//show instructor posts
//      $sql = "SELECT postid, post, type, users.userid, CONCAT( firstname, ' ', lastname ) as name, COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = posts.postid), 0 ) AS cnt FROM posts, users where users.userid = posts.userid and posts.userid = ".$userid." order by postid desc";
        $sql = "SELECT p.postid, p.post, p.type, u.userid, CONCAT_WS(' ',  u.firstname, u.lastname ) as name, 
        (SELECT COUNT(*) FROM comments c WHERE c.postid = p.postid) AS cnt, p.createdt
        FROM posts p JOIN
             users u
             ON u.userid = p.userid and p.userid = ".$userid."
        ORDER BY p.postid desc";
//      echo $sql;die;
        $arrPosts = array();
        
        $getUserPosts = DB::select($sql);
        if (count($getUserPosts) > 0)
        {
            foreach($getUserPosts as $userPosts)
            {
                array_push($arrPosts, $userPosts);
            }
            return response()->json(['message' => 'Instructor Posts', 'data' => $arrPosts, 'status' => 200]);
        }
        return response()->json(['message' => 'No Posts Found', 'status' => 1012]);
    }
    else{//show student posts
        $userType = 1;
        $sql = "SELECT ucid FROM user_course where userid = ".$userid;
    
        $arrUserCourse = array();

        $getUserCoursePost = DB::select($sql);

            if(count($getUserCoursePost) > 0){
                foreach($getUserCoursePost as $userCoursePost)
                {
                    array_push($arrUserCourse,$userCoursePost->ucid);
                }
            
                $sql = "SELECT distinct userid FROM student_course where ucid in (".implode(',',$arrUserCourse).") ORDER BY userid";
                
                $arrUserID = array();

                $getUsers = DB::select($sql);
                if (count($getUsers) > 0)
                {
                    foreach($getUsers as $users)
                    {
                        array_push($arrUserID,$users->userid);
                    }
                }
        
                if(count($arrUserID)>0){
                    $sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
                    COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
                    FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;
    //              echo $sql;die;
                    $arrPosts = array();
                    
                    $getInstructorTAPPosts = DB::select($sql);
                    
                    if (count($getInstructorTAPPosts) > 0)
                    {
                        foreach($getInstructorTAPPosts as $instructorTAPPosts)
                        {
                            array_push($arrPosts, $instructorTAPPosts);
                        }
                        return response()->json(['message' => 'Instructor Posts', 'data' => $arrPosts, 'status' => 200]);
                    }
                }
                else{
                        return response()->json(['message' => 'Instructor Posts', 'data' => $arrPosts, 'status' => 200]);
                }
            }
            else
                return response()->json(['message' => 'No Courses Found', 'status' => 1007]);
    }
}

}
