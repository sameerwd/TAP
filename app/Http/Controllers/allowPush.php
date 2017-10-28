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
	$userid = $_GET['userid'];
	$permission = $_GET['permission'];

	$sql = "update users set permissionAccepted = ".$_GET['permission']." where userid = ".$_GET['userid'];
	
	$retval = mysqli_query($con, $sql);
	if($retval){
		echo json_encode([
			"error" => 0,
			"message" => "Push notification permission updated successfully.",
		]);
	}
	else{
		echo json_encode([
			"error" => 1,
			"message" => "Unable to update permissions right now, please try after some time.",
		]);
	}
// Close connections
mysqli_close($con);
?>