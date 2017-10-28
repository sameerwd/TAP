<?php

require_once('config.php');
// Create connection
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "";
if(isset($_GET['school'])) {
    $school = $_GET['school'];
    $sql = "SELECT * FROM school where school_name like '%".$school."%' order by school_name ";
}else{
    $sql = "SELECT * FROM school order by school_name";
}
 
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