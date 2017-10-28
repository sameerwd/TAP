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
	$courses = explode("$$$", $_POST['courses']);
	$codes = array();
	foreach($courses as $course) {
		$sqlCheckValidCourseID = "SELECT ucid FROM user_course where ucid =".$course;
// 		echo $sqlCheckValidCourseID;
		if ($result = mysqli_query($con, $sqlCheckValidCourseID))
		{
			if($result->num_rows>0){
				$row = mysqli_fetch_assoc($result);
				
				$sql = "insert into student_course(userid, ucid) values(".$_POST['userid'].",".$course.")";
// 			echo "\n".$sql;
		  		$retval = mysqli_query($con, $sql);
  				$codes[] = mysqli_insert_id($con);
			}
			
		}
	}
	echo implode(",", $codes);
	
// Close connections
	mysqli_close($con);	
?>