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
// $page_num = $_GET['page_num']*10;

// $sql = "SELECT p.*, u.firstname, u.lastname FROM posts p, users u where p.userid = u.userid order by postid desc LIMIT ".$page_num.", 10";
// $sql = "SELECT c.postid, c.userid , COALESCE((SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt, COALESCE((SELECT CONCAT( firstname, ' ', lastname) FROM users WHERE userid = c.userid), 'N/A' ) AS `name` FROM posts p LEFT JOIN comments c ON c.postid = p.postid GROUP BY postid ORDER BY postid desc";
$userType = 1;
$sql = "";
// echo $_GET['userid'];die;
if(isset($_GET['userid'])){
	$userid = $_GET['userid'];
	$sql = "SELECT p.*,COALESCE((
        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
    ), 0 ) AS cnt, COALESCE(( 
        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
   ), 'N/A' ) AS `name` FROM posts p JOIN comments c ON p.userid = ".$userid." and userType = ".$userType." group by p.postid order by postid desc";
   echo $sql;die;
}
else{
	$sql = "SELECT p.*,COALESCE((
        SELECT COUNT( * ) FROM comments WHERE postid = p.postid 
    ), 0 ) AS cnt, COALESCE(( 
        SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid 
   ), 'N/A' ) AS `name` FROM posts p LEFT JOIN comments c ON p.postid = c.postid and userType = ".$userType." group by p.postid order by postid desc";
}

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