<?php 

namespace App\Model;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use App\Model\AuditAnswer;
use App\Model\Organization;
use App\Model\User;
use App\Model\TrackCar;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;


class Chats extends Model {


	public function getPosts($userid)
	{	

		$userType = 1;

		if($userid)
		{
			$sql = "SELECT p.*,COALESCE((
		        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
		    ), 0 ) AS cnt, COALESCE(( 
		        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
		   ), 'N/A' ) AS `name` FROM posts p JOIN comments c ON p.userid = ".$userid." and userType = ".$userType." group by p.postid order by postid desc";
		   
		}
		else{
			$sql = "SELECT p.*,COALESCE((
		        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
		    ), 0 ) AS cnt, COALESCE(( 
		        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
		   ), 'N/A' ) AS `name` FROM posts p LEFT JOIN comments c ON p.postid = c.postid and userType = ".$userType." group by p.postid order by postid desc";
		}

		return DB::select($sql);

	}


	public function insertSubmitPost($insertArray)
	{
		return DB::table('posts')->insertGetId($insertArray);
	}

	public function sendPostNotfication($userid){
		$sql = "select userid, title, firstname, lastname, userType from users where userid = ".$userid." and status = 1";

		$getUser = DB::select($sql);

			if(count($getUser) > 0){				
				if($getUser[0]->userType == 2){//send notification to all students
					$user = $getUser[0]->firstname." ".$getUser[0]->lastname;
					$sql = "SELECT ucid FROM user_course where userid = ".$userid;
					$getInstructorCourse = DB::select($sql);
					$arrUserCourse = array();

						if(count($getInstructorCourse) > 0){
							foreach($getInstructorCourse as $courses)
							{
								array_push($arrUserCourse,$courses->ucid);
							}
							$arrUsers = array();
							$tempArray = array();
							
						$sql = "SELECT distinct users.userid, firstname, lastname, userType, title, device, pushkey FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
							
							$getUserData = DB::select($sql);
							$arrUsersIOS = array();
							
							if(count($getUserData) > 0)
							{	
								foreach($getUserData as $data)
								{
									$device = $data->device;
									if($device=="ios"){
										if($data->userid < 3){
											$deviceToken = $data->pushkey;
											array_push($arrUsersIOS,$deviceToken);
											//$message = "New Post added on TAP from ".$user;
											//include('push.php');
										}
									}
								}
							}
							if(count($arrUsersIOS)>0){
								$message = "New Post added on TAP from ".$user;
								//sendPush($arrUsersIOS,$message);
								return "true";
							}
						}
				}
			}
	}



}