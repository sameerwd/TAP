<?php

require_once('config.php');
// Create connection
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$userid = $_GET['userid'];
	$month = $_GET['month'];
	$year = $_GET['year'];
	
	$sql = "SELECT a.assignmentid, u.course, a.courseid, a.description, DATE_FORMAT(duedate, '%Y-%m-%d %H:%i') AS duedate, a.title, u.userid FROM user_course u, assignment a where u.ucid = a.courseid and duedate > CURDATE() and MONTH(duedate) = ".$month." and YEAR(duedate) = ".$year." and u.userid = ".$userid." order by duedate asc";
//     echo $sql;die;
// Check if there are results
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