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
$sql = "SELECT userid FROM users where email ='".$_GET['email']."'";
// echo $sql;
// Check if there are results
if ($result = mysqli_query($con, $sql))
{
	if($result->num_rows>0){
		$row = mysqli_fetch_assoc($result);
		echo $row['userid'];
	}
	else{
		echo 0;
	}
}
 
// Close connections
mysqli_close($con);
?>