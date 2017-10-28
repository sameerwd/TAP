<?php
// 	error_reporting(E_ALL);
// 	print_r($_POST);
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
		if(strlen($course)>0){
			$sql = "insert into user_course(course, userid, expirydate) values('".$course."',".$_POST['userid'].",'".$_POST['expiry']."')";
 			//echo $sql;
			$retval = mysqli_query($con, $sql);
			$codes[] = mysqli_insert_id($con);
		}
	}
	echo implode(",", $codes);
	
// Close connections
mysqli_close($con);
?>