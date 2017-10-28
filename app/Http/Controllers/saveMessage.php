<?php
	error_reporting(E_ALL);
	require_once('config.php');
	require_once('sendSinglePush.php');
	// Create connection
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$message = $_POST['message'];
	$friend = $_POST['friend'];
	$userid = $_POST['userid'];
	$threadid = 0;
	$sqlThread = "SELECT threadid FROM thread where (sender =".$friend." and receiver = ".$userid.") or (sender =".$userid." and receiver = ".$friend.")";
	
	if ($result = mysqli_query($con, $sqlThread))
	{
		if($result->num_rows>0){//valid threadid
			$row = mysqli_fetch_assoc($result);
			$threadid = $row["threadid"];
			
			$sqlThread = "update thread set message = '".$message."' where threadid = ".$threadid;
			$retval = mysqli_query($con, $sqlThread);
		}
		else{
			$sqlThread = "insert into thread(message, sender, receiver) values('".$message."',".$userid.", ".$friend.")";
			$retval = mysqli_query($con, $sqlThread);
			$threadid = (string)mysqli_insert_id($con);
		}
		
		$sql = "insert into message (threadid, msg, sender) values (".$threadid.",'".$message."',".$userid.")";
		if ($result = mysqli_query($con, $sql)){
			$messageid = mysqli_insert_id($con);
			$permission = 1;
			$device = '';
			$sql = "SELECT pushkey, permissionAccepted, device FROM users where userid=".$friend;
			if ($result = mysqli_query($con, $sql)){
				if($result->num_rows>0){//valid device token
					$row = mysqli_fetch_assoc($result);
					$deviceToken = $row["pushkey"];
					$permission = $row["permissionAccepted"];
					$device = $row["device"];
				}
			}
			$sql = "SELECT concat(firstname,' ', lastname) as name FROM users where userid =".$userid;
			if ($result = mysqli_query($con, $sql)){
				if($result->num_rows>0){//valid name
					$row = mysqli_fetch_assoc($result);
					$message = "New message from ".$row["name"];
				}
			}
			if($permission==1){
				if($device=='ios'){
					sendSinglePushMessage($deviceToken,$message,'message',$threadid);
				}
				else{
					sendSingleAndroidPushMessage($deviceToken,$message,'message',$threadid,$userid);
				}
			}
		}
		echo json_encode([
		"error" => "",
		"status" => "message saved successfully",
		"threadid" => $threadid,
		"messageid" => $messageid,
		]);
	}
	
// Close connections
	mysqli_close($con);
?>