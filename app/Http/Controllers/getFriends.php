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
	$sql = "SELECT ucid FROM student_course where userid = ".$userid;
// 	echo $sql;die;
	$arrUserCourse = array();
	if ($result = mysqli_query($con, $sql))
	{
		if($result->num_rows>0){
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				array_push($arrUserCourse,$row[0]);
			}
			$arrUsers = array();
			
			$sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM user_course, users where users.userid!=".$userid." and users.userid= user_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
			$tempArray = array();
			if ($result = mysqli_query($con, $sql))
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					$tempArray = $row;
					array_push($arrUsers, $tempArray);
				}
			}
			$sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
			$tempArray = array();
			if ($result = mysqli_query($con, $sql))
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					$tempArray = $row;
					array_push($arrUsers, $tempArray);
				}
			}
			echo json_encode($arrUsers);
		}
		else{
			$sql = "SELECT ucid FROM user_course where userid = ".$userid;
			$arrUserCourse = array();
			if ($result = mysqli_query($con, $sql)){
				if($result->num_rows>0){
					while($row = $result->fetch_array(MYSQLI_NUM))
					{
						array_push($arrUserCourse,$row[0]);
					}
			
					$sql = "SELECT distinct users.userid, firstname, lastname, email, userType, title FROM student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and ucid in (".implode(',',$arrUserCourse).") ORDER BY firstname";
					$arrUsers = array();
					$tempArray = array();
					if ($result = mysqli_query($con, $sql))
					{
						while($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$tempArray = $row;
							array_push($arrUsers, $tempArray);
						}
					}
					echo json_encode($arrUsers);
				}
				else{
					echo json_encode([
						"status" => "error",
						"message" => "No course found, please add course to see your peers",
					]);
				}
			}
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