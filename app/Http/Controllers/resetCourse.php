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
	$ucid = $_GET['ucid'];
	$expiry = $_GET['expiry'];
	$sql = "delete from student_course where ucid = ".$ucid;
	$retval = mysqli_query($con, $sql);
	
	$sql = "update user_course set expirydate = curdate() where ucid = ".$ucid;
//	echo $sql; die;
	$retval = mysqli_query($con, $sql);
	echo json_encode([
				"status" => "success",
				"message" => "course has been successfully updated",
			]);
// Close connections
mysqli_close($con);
?>