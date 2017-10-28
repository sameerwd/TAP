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
	$sql = "SELECT s.scid, uc.ucid, uc.course, uc.userid, uc.expirydate, u.firstname, lastname FROM student_course s, user_course uc, users u where uc.ucid = s.ucid and u.userid = uc.userid and s.userid = ".$userid." and uc.expirydate >= CURDATE()";
// 	echo $sql;die;
	if ($result = mysqli_query($con, $sql))
	{
		if($result->num_rows>0){
			$arrUserCourse = array();
			$tempArray = array();
			if ($result = mysqli_query($con, $sql))
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					$tempArray = $row;
					array_push($arrUserCourse, $tempArray);
				}
				echo json_encode($arrUserCourse);
			}
		}
		else{
			echo json_encode([
				"status" => "error",
				"message" => "No course found, please add course to see your peers",
			]);
		}
	}
	else{
		echo json_encode([
				"status" => "error",
				"message" => "No course found, please add course to see your peers",
			]);
	}
}
else{

}
// Close connections
mysqli_close($con);
?>