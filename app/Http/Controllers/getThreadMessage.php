<?php
error_reporting(E_ALL);

require_once('config.php');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_GET['threadid'])){
	$threadid = $_GET['threadid'];
	
	$sql = "";
	if(isset($_GET['messageid'])){
		$messageid = $_GET['messageid'];
	}
	else{
		$messageid = 0;
	}
	if($messageid>0){
		$sql = "SELECT * FROM message where threadid =".$threadid." and msgid > ".$messageid." order by createdt asc";
	}
	else{
		$sql = "SELECT * FROM message where threadid =".$threadid." order by createdt asc";
	}
	
	$arrUsers = array();
	$tempArray = array();
	if ($result = mysqli_query($con, $sql))
	{
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$tempArray = $row;
			array_push($arrUsers, $tempArray);
		}
		echo json_encode($arrUsers);
	}
}
else{
	echo json_encode([
		"error" => "no threadid sent",
	]);
}
// Close connections
mysqli_close($con);
?>