<?php
	require_once('config.php');
	require_once('sendMultiplePush.php');
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$user = "";
	//$userid = $_GET['userid'];
	$sql = "select userid, title, firstname, lastname, usertype from users where userid = ".$userid." and status = 1";
	$user = "";
	if ($result = mysqli_query($con, $sql))
	{
		if($result->num_rows>0){
			$row = mysqli_fetch_assoc($result);
			if($row['usertype'] == 2){//send notification to all students
				$user = $row['firstname'] . " " . $row['lastname'];
				$sql = "SELECT ucid FROM user_course where userid = ".$userid;
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
						
					$sql = "SELECT distinct users.userid, firstname, lastname, userType, title, device, pushkey FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
						$arrUsersIOS = array();
						$result = mysqli_query($con,$sql);
						while($row = $result->fetch_assoc())
						{
							$device = $row["device"];
                                                        echo $row["firstname"];
							if($device=="ios"){
								if($row["userid"]<3){
									$deviceToken = $row["pushkey"];
									array_push($arrUsersIOS,$deviceToken);
									//$message = "New Post added on TAP from ".$user;
									//include('push.php');
								}
							}
						}
						if(count($arrUsersIOS)>0){
							sendPush($arrUsersIOS,$user);
						}
					}
				}
			}
		}
	}
?>