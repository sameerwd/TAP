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
 
// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT userid, title, userType, lastname, firstname, email, imageStatus, lastlogindttm, 0 as forgotPassword, permissionAccepted FROM users where email ='".$_GET['email']."' and password ='".$_GET['password']."' and status > 0";
// Check if there are results
if ($result = mysqli_query($con, $sql))
{
	if($result->num_rows>0){
		$row = mysqli_fetch_assoc($result);
		
		$sql = "update users set lastlogindttm = now(), pushkey = '".$_GET['pushkey']."', device = '".$_GET['device']."' where userid = ".$row['userid'];
		$retval = mysqli_query($con, $sql);
		
		header('Content-type: application/json');
		echo json_encode($row);
	}
	else{//invalid email/password, check for forgot password
		$sql = "SELECT userid, title, userType, lastname, firstname, email, imageStatus, lastlogindttm, 1 as forgotPassword, permissionAccepted FROM users where email ='".$_GET['email']."' and forgotPassword ='".$_GET['password']."' and status > 0";
		if ($result = mysqli_query($con, $sql)){
			if($result->num_rows>0){
				$row = mysqli_fetch_assoc($result);

				$sql = "update users set lastlogindttm = now(), pushkey = '".$_GET['pushkey']."', device = '".$_GET['device']."' where userid = ".$row['userid'];
				$retval = mysqli_query($con, $sql);
		
				header('Content-type: application/json');
				echo json_encode($row);
			}
			else{
				echo json_encode([
				"error" => "1",
				"message" => "Incorrect email/password, please try after some time.",
			]);
			}
		}
		else{
			echo json_encode([
				"error" => "1",
				"message" => "Incorrect email/password, please try after some time.",
			]);
		}
	}
}
else{
	echo "error";
}
// Close connections
mysqli_close($con);
?>