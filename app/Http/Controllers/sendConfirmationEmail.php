<?php
	error_reporting(E_ALL);


	$name = $_GET['name'];
	$email = $_GET['email'];

	
	 $subject = "Welcome to The Academic Point";
	 
	 $message = "<b>Dear ".$name."</b>";
	 $message .= "<h1>\n Thank you for downloading The Academic Point.</h1><br><br>";
// 	 $message .= "This is a place where you can get access to informations of your university and can stay in contact with your friends and collegues";
	 $message .= "We hope you enjoy the app and all the great features it has to offer <br><br>";
	 $message .= "Sincerly,<br><br>";
	 $message .= "The Academic Point Team";

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
		echo "Message sent successfully...";
	 }else {
		echo "Message could not be sent...";
	 }
?>