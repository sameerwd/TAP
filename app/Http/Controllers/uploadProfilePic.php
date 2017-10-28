<?php
	require_once('config.php');
	error_reporting( E_ALL );
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
		$userid = $_POST['userid'];
		$target_dir = "profilePic/";
		
		$newfilename = $target_dir.$_POST['userid'] . '.jpg';
		if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename)) {
			$sql = "update users set imageStatus = 1 where userid = ".$userid;
			$retval = mysqli_query($con, $sql);
		
			if(! $retval ){
			  die('Could not enter data: ' . mysql_error());
			}
			
			echo json_encode([
				"Message" => "The file ". basename($newfilename). " has been uploaded.",
				"Status" => "OK",
			]);
		} else {
			file_put_contents($newfilename, base64_decode($_POST['userfile']));
			/*echo json_encode([
				"Message" => "Sorry, there was an error uploading your file.",
				"Status" => "Error",
				"FilePath" => $newfilename,
			]);*/
		}
?>