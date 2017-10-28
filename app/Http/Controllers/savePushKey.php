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
	$userid = $_POST['userid'];
	$pushkey = $_POST['pushkey'];
	$os = $_POST['os'];
	$device = $_POST['device'];
	
	$sql = "update users set pushkey = ".$pushkey." and os = ".$os." and ."$device". where userid =".$userid;
		if ($result = mysqli_query($con, $sqlCheckValidCourseID))
		{
			if($result->num_rows>0){//valid ucid
				echo json_encode([
								"status" => "success",
							]);
			}
			else{
				echo json_encode([
						"status" => "Invalid data",
					]);
			}
		}
// Close connections
	mysqli_close($con);
?>