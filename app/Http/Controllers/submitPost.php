<?php
	require_once('config.php');
	require_once('sendMultiplePush.php');
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "";
	// post =1 for text, =2 text and image
	$sql = "INSERT INTO posts(post,type,userid) values('".$_POST['post']."',".$_POST['type'].",".$_POST['userid'].")";
	
	$retval = mysqli_query($con, $sql);
	$postid = mysqli_insert_id($con);
	
//	$userid = $_POST['userid'];
//	$usertype = $_POST['usertype'];
	//include(sendPostNotification.php);
	sendPostNotfication($_POST['userid']);
	mysqli_close($con);

	if($_POST['type']==2){
		$target_dir = "pictures/";
		
		$newfilename = $target_dir.$postid . '.jpg';

		if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename)) {
			echo json_encode([
				"Message" => "The file ". basename($newfilename). " has been uploaded.",
				"Status" => "OK",
			]);
		} else {
			file_put_contents($newfilename, base64_decode($_POST['userfile']));
			/*echo json_encode([
				"Message" => "There was an error uploading file.",
				"Status" => "Error",
			]);*/
		}
	}
	
	function sendPostNotfication($userid){
		$sql = "select userid, title, firstname, lastname, usertype from users where userid = ".$userid." and status = 1";
		$user = "";
		$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
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
								$message = "New Post added on TAP from ".$user;
								sendPush($arrUsersIOS,$message);
							}
						}
					}
				}
			}
		}
	}
?>