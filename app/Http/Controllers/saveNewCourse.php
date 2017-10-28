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

	$sql = "insert into user_course(course, expirydate, userid) values('".$_POST['course']."','".$_POST['expiry']."',".$_POST['userid'].")";
  	$retval = mysqli_query($con, $sql);
  	$courseid = mysqli_insert_id($con);
  	
	echo json_encode([
				"status" => "success",
				"courseid" => $courseid,
			]);
			
// Close connections
mysqli_close($con);
?>