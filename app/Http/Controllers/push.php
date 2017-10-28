<?php
	error_reporting(E_ALL);

//	$deviceToken = '0C3F688BD8503C9599A27AB949B266FDA5428633C53E277DF667EDABB90D81DB';
//$deviceToken = $_GET['pushkey'];
	// Put your private key's passphrase here:
    $passphrase = '123456';

    // Put your alert message here:
    //$message = 'Hello';
// 	echo $message;die;
	    ////////////////////////////////////////////////////////////////////////////////

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', 'tap_aps_pro.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $fp = stream_socket_client(
        'ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

    echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
    $body['aps'] = array(
        'alert' => $message,
        'sound' => 'default'
        );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result)
    {   
        echo 'Message not delivered' . PHP_EOL;
    }
    else
    {   
        echo 'Message successfully delivered' . PHP_EOL;

    }

    // Close the connection to the server
    fclose($fp);
?>