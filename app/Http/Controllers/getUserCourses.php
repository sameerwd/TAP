<?php
error_reporting(E_ALL);

require_once('config.php');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "";
if(isset($_GET['userid'])){
	$userid = $_GET['userid'];

	$sql = "SELECT * FROM user_course u where u.userid = ".$userid;
}

if ($result = mysqli_query($con, $sql))
{
	$resultArray = array();
	$tempArray = array();
 
	while($row = $result->fetch_object())
	{
		$tempArray = $row;
	    array_push($resultArray, $tempArray);
	}
	echo json_encode($resultArray);
}
mysqli_close($con);
?>