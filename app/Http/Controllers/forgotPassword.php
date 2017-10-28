<?php
	error_reporting(E_ALL);
	// echo "hh hdd sss";
// 	print_r($_POST);
	require_once('config.php');
	require_once('randomPassword.php');
	// Create connection
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 	$email = $_GET['email'];
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$password = random_password(8);
// 	echo $password;
	$sql = "update users set forgotPassword = '".$password."' where email = '".$email."'";
	
	$retval = mysqli_query($con, $sql);
	if($retval){
		 $subject = "Password help assistance - Get back your password";
		 $message = "<b>Dear TAP user</b><br><br>";
		 $message .= "You are receiving this mail because you have asked for help regarding the password for ".$email."<br><br>";
		 $message .= "Please use following temporary password to login.<br><br>";
		 $message .= "Temporary Password: ".$password;
		 $message .= "<br><br>Once you login you will be prompted to change your password.<br><br>";
		 $message .= "Sincerely,<br>The Academic Point Team";
		 
		 $header = "From: The Academic Point webmaster@theacademicpointonline.com \r\n";
	//      $header = "Cc:afgh@somedomain.com \r\n";
		 $header .= "MIME-Version: 1.0\r\n";
		 $header .= "Content-type: text/html\r\n";
	 
	// 	 $header = "From:The Academic Point \r\n";
	// 	 $header = "From: webmaster@theacademicpointonline.com' . "\r\n";
	// 	 $header .= "MIME-Version: 1.0\r\n";
	// 	 $header .= "Content-type: text/html\r\n";
	// 	 $header .= "From: webmaster@example.com' . "\r\n";
	 
		 $retval = mail ($email,$subject,$message,$header);
	 
		 if( $retval == true ) {
			 echo json_encode([
					"status" => "1",
					"message" => "Temporary password has been sent to your email. Please login using temporary password.",
				]);
		 }else {
			echo json_encode([
				"status" => "0",
				"message" => "Unable to reset password right now, please try after some time.",
			]);
		 }
	}
	else{
		echo json_encode([
				"status" => "0",
				"message" => "Unable to reset password right now, please try after some time.",
			]);
	}
// Close connections
mysqli_close($con);
?>