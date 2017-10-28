<?php
	require_once('config.php');
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "";
	
	$sql = "INSERT INTO token(deviceid,os,siteid,userid) values('".$_POST['deviceid']."','".$_POST['type']."','".$_POST['siteid']."',".$_POST['userid'].")";

	$retval = mysqli_query($con, $sql);
	
	mysqli_close($con);
	echo json_encode([
		"Message" => "Device token  saved",
		"Status" => "OK",
		"SQL" => $sql,
	]);
?>