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
	$field = $_GET['field'];
	$value = $_GET['value'];
	$sql = "update users set ".$field." = '".$value."',updatedt = now() where userid = ".$_GET['userid'];
	$retval = mysqli_query($con, $sql);
// 	echo $sql;
// 	if($_POST['user_type']==1){
// 		$sql = "insert into users(firstname, lastname, email, password, userType) values('".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','".$_POST['password']."','".$_POST['user_type']."')";
// 	}
// 	else{
// 		$sql = "insert into users(title, firstname, lastname, email, password, userType) values('".$_POST['title']."','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','".$_POST['password']."','".$_POST['user_type']."')";
// 	}
	
// 	$userid = mysqli_insert_id($con);
// 	if(! $retval ){
// 	  die('Could not enter data: ' . mysql_error());
// 	}
// 	else{
		
// 		$sql = "insert into user_school(schoolid, userid) values(".$_POST['schoolid'].",".$userid.")";
// 		
// 		$retval = mysqli_query($con, $sql);
// 	}
	echo json_encode([
				"status" => "success",
			]);
// Close connections
mysqli_close($con);
?>