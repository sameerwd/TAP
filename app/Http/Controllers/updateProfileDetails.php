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

	if($_POST['password']){
		$sql = "update users set firstname = '".$_POST['first_name']."', lastname ='".$_POST['last_name']."', password = '".$_POST['password']."' where userid = ".$_POST['userid'];
	}
	else{
		$sql = "update users set firstname = '".$_POST['first_name']."', lastname ='".$_POST['last_name']."' where userid = ".$_POST['userid'];
	}	
	$retval = mysqli_query($con, $sql);
	if($retval){
		echo json_encode([
				"status" => "1",
				"message" => "Your details are successfully updated",
				"sql" => $sql,
			]);
	}
	else{
		echo json_encode([
				"status" => "0",
				"message" => "Unable to update details right now, please try after some time",
				"sql" => $sql,
			]);
	}
// Close connections
mysqli_close($con);
?>