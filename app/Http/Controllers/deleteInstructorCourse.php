<?php

require_once('config.php');
// Create connection
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$ucid = $_GET['ucid'];
    $sql = "delete from user_course where ucid = ".$ucid;
    
	$retval = mysqli_query($con, $sql); 
// Close connections
mysqli_close($con);
?>