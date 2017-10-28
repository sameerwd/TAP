<?php
error_reporting(E_ALL);
// Create connection
require_once('config.php');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$page_num = $_GET['page_num']*10;
$postid = $_GET['postid'];
// $sql = "SELECT c.*, u.firstname, u.lastname FROM comments c, users u where c.userid = u.userid and postid = ".$postid." order by commentid LIMIT ".$page_num.", 10";
$sql = "SELECT c.*, u.firstname, u.lastname FROM comments c, users u where c.userid = u.userid and postid = ".$postid." order by commentid";

if ($result = mysqli_query($con, $sql))
{
	// If so, then create a results array and a temporary one
	// to hold the data
	$resultArray = array();
	$tempArray = array();
 
	// Loop through each row in the result set
	while($row = $result->fetch_object())
	{
		// Add each row into our results array
		$tempArray = $row;
	    array_push($resultArray, $tempArray);
	}
 
	// Finally, encode the array to JSON and output the results
	echo json_encode($resultArray);
}
 
// Close connections
mysqli_close($con);
?>