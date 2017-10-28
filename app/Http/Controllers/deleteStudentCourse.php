<?php

require_once('config.php');
// Create connection
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$scid = $_GET['scid'];
    $sql = "delete from student_course where scid = ".$scid;
    
	$retval = mysqli_query($con, $sql); 
// Close connections
mysqli_close($con);
?>