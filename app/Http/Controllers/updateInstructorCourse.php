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
	
	$sql = "update user_course set course = '".$_POST['course']."', expirydate = '".$_POST['expiry']."', userid = ".$_POST['userid']." where ucid = ".$_POST['ucid'];
// 	echo $sql; die;
	$retval = mysqli_query($con, $sql);
// 	$userid = mysqli_insert_id($con);
	if(! $retval ){
	  die('Could not enter data: ' . mysql_error());
	}
	else{
		echo json_encode([
				"status" => "success",
			]);
	}

	mysqli_close($con);
?>