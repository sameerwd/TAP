<?php
	require_once('config.php');
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "";
	
	$sql = "INSERT INTO comments(comment,postid,userid) values('".$_POST['comment']."',".$_POST['postid'].",".$_POST['userid'].")";

	$retval = mysqli_query($con, $sql);
	$commentid = mysqli_insert_id($con);
	mysqli_close($con);
	echo json_encode([
		"Message" => "The file ". basename($newfilename). " has been uploaded.",
		"Status" => "OK",
		"CommentID" => $commentid,
	]);
?>