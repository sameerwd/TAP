<?php

function sendPush($arrUsers,$message,$pushtype,$arrUsersPermissionsIOS) {
	error_reporting(E_ALL);

	// Put your private key's passphrase here:
    $passphrase = '123456';
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

 //   echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
    $body['aps'] = array(
        'alert' => $message,
        'sound' => 'default',
        'pushtype' => $pushtype
        );

    // Encode the payload as JSON
    $payload = json_encode($body);
	$i = 0;
	foreach($arrUsers as $pushToken) {
                    // Put your device token here (without spaces):
        	//$pushToken = $val['pushkey'];
        	// Build the binary notification
        	if($arrUsersPermissionsIOS[$i]==1){
        		$msg = chr(0) . pack('n', 32) . pack('H*', $pushToken) . pack('n', strlen($payload)) . $payload;
	
		    // Send it to the server
		    $result = fwrite($fp, $msg, strlen($msg));
        	}
	    
		$i++;
	    /*if (!$result)
	    {   
	        echo 'Message not delivered' . PHP_EOL;
	    }
	    else
	    {   
	        echo 'Message successfully delivered' . PHP_EOL;
	
	    }*/
    	}
    

    // Close the connection to the server
    fclose($fp);
    }
    
    function sendPushAndroid($data, $ids) {
	error_reporting(E_ALL);
	
	// Insert real GCM API key from the Google APIs Console
	    // https://code.google.com/apis/console/        
	    $apiKey = 'AIzaSyBAPtTEUxQF_FQQl2SFMcTQ5PuusXzK_jA';
	
	    // Set POST request body
	    $post = array(
	                    'registration_ids'  => $ids,
	                    'data'              => $data,
	                 );
	
	    // Set CURL request headers 
	    $headers = array( 
	                        'Authorization: key=' . $apiKey,
	                        'Content-Type: application/json'
	                    );
	
	    // Initialize curl handle       
	    $ch = curl_init();
	
	    // Set URL to GCM push endpoint     
	    curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
	
	    // Set request method to POST       
	    curl_setopt($ch, CURLOPT_POST, true);
	
	    // Set custom request headers       
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	    // Get the response back as string instead of printing it       
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	    // Set JSON post data
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
	
	    // Actually send the request    
	    $result = curl_exec($ch);
	
	    // Handle errors
	    if (curl_errno($ch))
	    {
	        echo 'GCM error: ' . curl_error($ch);
	    }
	
	    // Close curl handle
	    curl_close($ch);
	
	    // Debug GCM response       
	    echo $result;
        }
?>