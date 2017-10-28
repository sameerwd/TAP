<?php

	function sendSinglePushMessage($deviceToken,$message,$pushtype,$threadid) {
		error_reporting(E_ALL);
	
		// Put your private key's passphrase here:
	    $passphrase = '123456';
	    //$message = "New Post added on TAP from ".$user;
	    $ctx = stream_context_create();
	    //stream_context_set_option($ctx, 'ssl', 'local_cert', 'tap_aps_pro.pem');
	    stream_context_set_option($ctx, 'ssl', 'local_cert', 'tap_aps_dev.pem');
	    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	    // Open a connection to the APNS server
	    /*$fp = stream_socket_client(
	        'ssl://gateway.push.apple.com:2195', $err,
	        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);*/
		$fp = stream_socket_client(
	        'ssl://gateway.sandbox.push.apple.com:2195', $err,
	        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	    if (!$fp)
	        exit("Failed to connect: $err $errstr" . PHP_EOL);
	
	//    echo 'Connected to APNS' . PHP_EOL;
	
	// Create the payload body
	    $body['aps'] = array(
	        'alert' => $message,
	        'sound' => 'default',
	        'pushtype' => $pushtype,
	        'threadid' => $threadid
	        );
	
	    // Encode the payload as JSON
	    $payload = json_encode($body);
	    
	    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		
	    // Send it to the server
	    $result = fwrite($fp, $msg, strlen($msg));
	
	    /*if (!$result)
	    {   
	        echo 'Message not delivered' . PHP_EOL;
	    }
	    else
	    {   
	        echo 'Message successfully delivered' . PHP_EOL;
	
	    }*/
	
	    // Close the connection to the server
	    	fclose($fp);
	    }
	    
	    
	    function sendSingleAndroidPushMessage($deviceToken,$message,$pushtype,$threadid,$sender) {
		error_reporting(E_ALL);
	
		// API access key from Google API's Console
		define( 'API_ACCESS_KEY', 'AIzaSyBAPtTEUxQF_FQQl2SFMcTQ5PuusXzK_jA' );
		$registrationIds = array( $deviceToken );
		// prep the bundle
		$msg = array
		(
			'alert' => $message,
	        	'vibrate'	=> 1,
			'sound'		=> 1,
		        'pushtype' => $pushtype,
		        'threadid' => $threadid,
		        'friend' => $sender
		);
		/*$msg = array
		(
			'message' 	=> 'here is a message. message',
			'title'		=> 'This is a title. title',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);*/
		$fields = array
		(
			'registration_ids' 	=> $registrationIds,
			'data'			=> $msg
		);
		 
		$headers = array
		(
		
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
	}
	
?>