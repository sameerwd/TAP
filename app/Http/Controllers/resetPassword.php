<?php
	error_reporting(E_ALL);
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

	$sql = "SELECT userid, title, userType, lastname, firstname, email, imageStatus, lastlogindttm FROM users where email ='".$_POST['email']."' and forgotPassword ='".$_POST['forgotPassword']."' and status > 0";
// 	echo $sql;die;
	if ($result = mysqli_query($con, $sql))
	{
		if($result->num_rows>0){
			$row = mysqli_fetch_assoc($result);
		
			$sql = "update users set lastlogindttm = now(), password = '".$_POST['password']."', forgotPassword = '' where userid = ".$row['userid'];
			$retval = mysqli_query($con, $sql);
		
			header('Content-type: application/json');
			echo json_encode($row);
		}
	}
	else{
		echo json_encode([
				"status" => "0",
				"message" => "Incorrect password, please try again",
			]);
	}
	
// Close connections
mysqli_close($con);
?>