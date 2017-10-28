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
// 	$sql = "SELECT * FROM thread where sender =".$userid." or receiver = ".$userid." order by updatedttm desc";
	$sql = "SELECT t.*,CONCAT(usend.firstname, ' ', usend.lastname) sender_name, CONCAT(urec.firstname, ' ', urec.lastname) receiver_name
			FROM thread t
			JOIN users usend on usend.userid = t.sender
			JOIN users urec on urec.userid = t.receiver
			where sender = ".$userid." or receiver = ".$userid."
			order by updatedttm desc";
	
	$arrUsers = array();
	$tempArray = array();
	if ($result = mysqli_query($con, $sql))
	{
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$friend = 0;
			if($row["sender"]==$userid){
				$friend = $row["receiver"];
			}
			else{
				$friend = $row["sender"];
			}
			$row["friend"] = $friend;
			$tempArray = $row;
			array_push($arrUsers, $tempArray);
		}
		echo json_encode($arrUsers);
	}
}
else{

}
// Close connections
mysqli_close($con);
?>