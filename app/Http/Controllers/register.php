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
	
	$sql = "";$userid = 0;
	if($_POST['user_type']==1){
		$sql = "insert into users(title, firstname, lastname, email, password, userType, os, device, pushkey) values('', '".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','".$_POST['password']."','".$_POST['user_type']."','".$_POST['os']."','".$_POST['device']."','".$_POST['pushkey']."')";
	}
	else{
		$sql = "insert into users(title, firstname, lastname, email, password, userType, os, device, pushkey) values('".$_POST['title']."','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','".$_POST['password']."','".$_POST['user_type']."','".$_POST['os']."','".$_POST['device']."','".$_POST['pushkey']."')";
	}
	$retval = mysqli_query($con, $sql);
	$userid = mysqli_insert_id($con);
// 	if(! $retval ){
// 	  die('Could not enter data: ' . mysql_error());
// 	}
// 	else{
		
// 		$sql = "insert into user_school(schoolid, userid) values(".$_POST['schoolid'].",".$userid.")";
// 		
// 		$retval = mysqli_query($con, $sql);
// 	}
	echo $userid;
// Close connections
mysqli_close($con);
?>