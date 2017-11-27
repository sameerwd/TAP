<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use App\Model\Audit;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


use DB;
use Illuminate\Support\Facades\Session;

class User extends Model{


$announcementType = $_GET['announcementType'];
$userType = 1;
$sql = "";
$recNum = 0;
$pageItemsCount = 30;
$arrPosts = array();

if(isset($_GET['userid'])){
// 	echo $_GET['userid'];die;
	$userid = $_GET['userid'];
	if($announcementType==2){//show instructor posts
		$sql = "SELECT s.ucid FROM student_course s JOIN user_course u on s.ucid = u.ucid and s.userid = ".$userid." and u.expirydate >= CURDATE()";
		$arrUserCourse = array();
		
		if ($result = mysqli_query($con, $sql))
		{
			if($result->num_rows>0){
				while($row = $result->fetch_array(MYSQLI_NUM))
				{
					array_push($arrUserCourse,$row[0]);
				}
				$sql = "SELECT distinct userid FROM user_course where ucid in (".implode(',',$arrUserCourse).") ORDER BY userid";
				$arrUserID = array();
				if ($result = mysqli_query($con, $sql))
				{
					while($row = $result->fetch_array(MYSQLI_NUM))
					{
						array_push($arrUserID,$row[0]);
					}
					
					$sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
					COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
					FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid order by p.postid desc limit ".$recNum.",".$pageItemsCount;
				
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
			}
			else{
				echo json_encode($arrPosts);
			}
		}
		else{
			echo json_encode($arrPosts);
		}
	}
	else{
		$sql = "SELECT ucid FROM student_course where userid = ".$userid;
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
		
				$sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
				COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
				FROM posts p, users u where p.userid in (".implode(',',$arrUserID).") and u.userid = p.userid and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;
				//echo $sql;die;
				
				$tempArray = array();
				if ($result = mysqli_query($con, $sql))
				{
					while($row = $result->fetch_array(MYSQLI_ASSOC))
					{
			// 			array_push($arrPosts,$row["postid"],$row["post"],$row["cnt"],$row["name"]);
						$tempArray = $row;
						array_push($arrPosts, $tempArray);
					}
			// 		echo implode(',',$arrPosts);
					echo json_encode($arrPosts);
				}

			}
			else{
				$sql = "SELECT p.*,COALESCE(( SELECT COUNT( * ) FROM comments WHERE postid = p.postid), 0 ) AS cnt,
				COALESCE((SELECT CONCAT( firstname, ' ', lastname ) FROM users u WHERE u.userid = p.userid ), 'N/A' ) AS name 
				FROM posts p, users u where u.userid = p.userid and u.userid = ".$userid." and u.userType= ".$userType." order by p.postid desc limit ".$recNum.",".$pageItemsCount;

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
		}
		else{
			echo json_encode($arrPosts);
		}
	}
}
else{
	echo json_encode($arrPosts);
}




///************Instuctor Posts********************///
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


}