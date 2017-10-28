<?php

require_once('config.php');
// Create connection
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$asid = $_GET['assignmentid'];
    $sql = "delete from assignment where assignmentid = ".$asid;
    
	$retval = mysqli_query($con, $sql); 
// Close connections
mysqli_close($con);
?>