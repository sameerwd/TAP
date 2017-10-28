<?php
	error_reporting(E_ALL);
	// echo "hh hdd sss";
// 	print_r($_POST);
	require_once('config.php');
	// Create connection
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$sql = "";
	$userid = $_GET['userid'];;
	$ucid = $_GET['ucid'];
	$scid = $_GET['scid'];
	
	$sqlCheckValidCourseID = "SELECT ucid FROM user_course where ucid =".$ucid;
	
	if ($result = mysqli_query($con, $sqlCheckValidCourseID)){
		if($result->num_rows>0){
			$sqlCheckExistingCourseID = "SELECT * FROM student_course where ucid =".$ucid." and userid = ".$userid;
			if ($res = mysqli_query($con, $sqlCheckExistingCourseID)){
				if($res->num_rows<1){
					$row = mysqli_fetch_assoc($result);
					$sql = "update student_course set ucid = ".$ucid." where scid = ".$scid;
					$retval = mysqli_query($con, $sql);
					echo json_encode([
						"status" => "success",
					]);
				}
				else{
					echo json_encode([
						"status" => "CourseID already registered for user",
					]);
				}
			}
		}
		else{
			echo json_encode([
				"status" => "Invalid CourseID, please verify with your Instructor",
			]);
		}
	}

	
// Close connections
mysqli_close($con);
?>