<?php
	error_reporting(E_ALL);
	// echo "hh hdd sss";
// 	print_r($_POST);
	require_once('config.php');
	require_once('sendMultiplePush.php');
	// Create connection
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$sql = "insert into assignment(title, description, duedate, userid, courseid) values('".$_POST['title']."','".$_POST['detail']."','".$_POST['duedate']."',".$_POST['userid'].",".$_POST['courseid'].")";
// 	echo $sql; die;
	$retval = mysqli_query($con, $sql);
	$userid = mysqli_insert_id($con);
	if(! $retval ){
	  die('Could not enter data: ' . mysql_error());
	}
 	else{
		sendPostNotfication($_POST['userid'],$_POST['courseid']);
 	}
	echo $userid;
// Close connections
	mysqli_close($con);
	
	function sendPostNotfication($userid, $ucid){
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
					/*$sql = "SELECT ucid FROM user_course where userid = ".$userid;
					$arrUserCourse = array();
					if ($result = mysqli_query($con, $sql))
					{
						if($result->num_rows>0){
							while($row = $result->fetch_array(MYSQLI_NUM))
							{
								array_push($arrUserCourse,$row[0]);
							}
							$arrUsers = array();
							$tempArray = array();
							
						$sql = "SELECT distinct users.userid, firstname, lastname, userType, title, device, pushkey, permissionAccepted FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
							$arrUsersIOS = array();
							$arrUsersPermissionsIOS = array();
							$permission = 1;
							$result = mysqli_query($con,$sql);
							while($row = $result->fetch_assoc())
							{
								$device = $row["device"];
		                                                if($device=="ios"){
									if($row["userid"]<3){
										$deviceToken = $row["pushkey"];
										$permission = $row["permissionAccepted"];
										array_push($arrUsersIOS,$deviceToken);
										array_push($arrUsersPermissionsIOS,$permission);
										//$message = "New Post added on TAP from ".$user;
										//include('push.php');
									}
								}
								
							}
							if(count($arrUsersIOS)>0){
								$message = "New assignment added on TAP from ".$user;
								//echo $arrUsersIOS;
								//echo $arrUsersPermissionsIOS;
								sendPush($arrUsersIOS,$message,'assignment',$arrUsersPermissionsIOS);
							}
						}
					}*/
				}
			}
		}
	}
?>