<?php
	error_reporting(E_ALL);
	require_once('config.php');
	// Create connection
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$course = $_GET['ucid'];
	
	$sqlCheckValidCourseID = "SELECT ucid FROM user_course where ucid =".$course." and expirydate >= CURDATE()";
		if ($result = mysqli_query($con, $sqlCheckValidCourseID))
		{
			if($result->num_rows>0){//valid ucid
				$sqlIfExistingCourseID = "SELECT * FROM student_course where ucid =".$course." and userid = ".$_GET['userid'];
				if ($result = mysqli_query($con, $sqlIfExistingCourseID)){
					if($result->num_rows>0){
							echo json_encode([
							"status" => "CourseID already registered for user",
						]);
					}
					else{
						$sql = "insert into student_course(userid, ucid) values(".$_GET['userid'].",".$course.")";

						$retval = mysqli_query($con, $sql);
						$codes[] = mysqli_insert_id($con);
						echo json_encode([
								"status" => "success",
							]);
					}
				}
			}
			else{
				echo json_encode([
						"status" => "Invalid CourseID",
					]);
			}
		}
	
// Close connections
	mysqli_close($con);