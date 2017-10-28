<?php
error_reporting(E_ALL);

require_once('config.php');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$announcementType = $_GET['announcementType'];
$sql = "";
$recNum = 0;
$pageItemsCount = 30;

if(isset($_GET['userid'])){
// 	echo $_GET['userid'];die;
	$userid = $_GET['userid'];
	if($announcementType==1){//show instructor posts
// 		$sql = "SELECT postid, post, type, users.userid, CONCAT( firstname, ' ', lastname ) as name, COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = posts.postid), 0 ) AS cnt FROM posts, users where users.userid = posts.userid and posts.userid = ".$userid." order by postid desc";
		$sql = "SELECT p.postid, p.post, p.type, u.userid, CONCAT_WS(' ',  u.firstname, u.lastname ) as name, 
		(SELECT COUNT(*) FROM comments c WHERE c.postid = p.postid) AS cnt, p.createdt
		FROM posts p JOIN
			 users u
			 ON u.userid = p.userid and p.userid = ".$userid."
		ORDER BY p.postid desc";
// 	 	echo $sql;die;
		$arrPosts = array();
		$tempArray = array();
		if ($result = mysqli_query($con, $sql))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$tempArray = $row;
				array_push($arrPosts, $tempArray);
			}
			echo json_encode($arrPosts);
		}
	}
	else{//show student posts
		$userType = 1;
		$sql = "SELECT ucid FROM user_course where userid = ".$userid;
	
		$arrUserCourse = array();
		if ($result = mysqli_query($con, $sql))
		{
			if($result->num_rows>0){
				while($row = $result->fetch_array(MYSQLI_NUM))
				{
					array_push($arrUserCourse,$row[0]);
				}
			
				$sql = "SELECT distinct userid FROM student_course where ucid in (".implode(',',$arrUserCourse).") ORDER BY userid";
				
				$arrUserID = array();
				if ($result = mysqli_query($con, $sql))
				{
					while($row = $result->fetch_array(MYSQLI_NUM))
					{
						array_push($arrUserID,$row[0]);
					}
				}
		
				if(count($arrUserID)>0){
					$sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
					COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
					FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;
	// 				echo $sql;die;
					$arrPosts = array();
					$tempArray = array();
					if ($result = mysqli_query($con, $sql))
					{
						while($row = $result->fetch_array(MYSQLI_ASSOC))
						{
				// 			array_push($arrPosts,$row["postid"],$row["post"],$row["cnt"],$row["name"]);
							$tempArray = $row;
							array_push($arrPosts, $tempArray);
						}
						echo json_encode($arrPosts);
					}
				}
				else{
				
				}
			}
			else{
				// $sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
// 				COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
// 				FROM posts p, users u where u.userid = p.userid and u.userid = ".$userid." and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;
// 				$arrPosts = array();
// 				$tempArray = array();
// 				if ($result = mysqli_query($con, $sql))
// 				{
// 					while($row = $result->fetch_array(MYSQLI_ASSOC))
// 					{
// 						$tempArray = $row;
// 						array_push($arrPosts, $tempArray);
// 					}
// 					echo json_encode($arrPosts);
// 				}
			}
		}
	}
	
}
// Close connections
mysqli_close($con);
?>