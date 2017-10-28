<?php
error_reporting(E_ALL);

require_once('config.php');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$userid = $_GET['userid'];
	$sql = "SELECT ucid FROM user_course where userid = ".$userid;
	$arrUserCourse = array();
	if ($result = mysqli_query($con, $sql)){
		if($result->num_rows>0){
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				array_push($arrUserCourse,$row[0]);
			}
			$arrUsers = array();
			$sql = "SELECT users.userid, firstname, lastname, email, course, user_course.ucid FROM user_course, student_course, users where users.userid!=".$userid." and users.userid= student_course.userid and user_course.ucid = student_course.ucid and user_course.ucid in (".implode(',',$arrUserCourse).") order by course";
			
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
	}
	
mysqli_close($con);
?>