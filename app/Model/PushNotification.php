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


class PushNotification extends Model {


	public function setPushPermission($userid,$permission)
	{
		return DB::table('user')->where('userid',$userid)->update(array('isPermitted' => $permission));
	}


	public function sendPostNotfication($userid,$courseid)
	{
		$sql = "select userid, title, firstname, lastname, usertype from users where userid = ".$userid." and status = 1";
		$user = "";
		$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
		if ($result = mysqli_query($con, $sql))
		{
			if($result->num_rows>0){
				$row = mysqli_fetch_assoc($result);
				if($row['usertype'] == 2){//send notification to all students
					$user = $row['title'] . " " . $row['firstname'] . " " . $row['lastname'];
					$sql = "SELECT distinct users.userid, firstname, lastname, userType, title, device, pushkey, permissionAccepted FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid= ".$ucid." ORDER BY firstname";
					$arrUsersIOS = array();
					$arrUsersAndroid = array();
					$arrUsersPermissionsIOS = array();
					$arrUsersPermissionsAndroid = array();
					$permission = 1;
					$result = mysqli_query($con,$sql);
					while($row = $result->fetch_assoc())
					{
						$device = $row["device"];
                                                if($device=="ios"){
							$deviceToken = $row["pushkey"];
							$permission = $row["permissionAccepted"];
							array_push($arrUsersIOS,$deviceToken);
							array_push($arrUsersPermissionsIOS,$permission);
						}
						else if($device=="android"){
							$deviceToken = $row["pushkey"];
							$permission = $row["permissionAccepted"];
							if($permission==1){
								array_push($arrUsersAndroid,$deviceToken);
							}
						}
					}
					if(count($arrUsersIOS)>0){
						$message = "New assignment added on TAP from ".$user;
						//echo $arrUsersIOS;
						//echo $arrUsersPermissionsIOS;
						sendPush($arrUsersIOS,$message,'assignment',$arrUsersPermissionsIOS);
					}
					else if(count($arrUsersAndroid)>0){
						$message = "New assignment added on TAP from ".$user;
						//echo $arrUsersIOS;
						//echo $arrUsersPermissionsIOS;
						
						sendPushAndroid($arrUsersAndroid, array('message' => $message));
					}
	}


}