<?php
	error_reporting(E_ALL);
	require_once('config.php');
	
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$siteid = $_GET['siteid'];
	$os = $_GET['type'];
	
	$sql = "SELECT deviceid FROM token where os = '".$os."' and siteid = '".$siteid."'";
// 	echo $sql;
	if ($result = mysqli_query($con, $sql))
		{
			if($result->num_rows>0){
				$row = mysqli_fetch_assoc($result);
// 				echo $row['deviceid'];echo "<br>";
				$deviceToken = $row['deviceid'];
// 				include_file "push.php";

				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'aps_production.pem');
// 				stream_context_set_option($ctx, 'ssl', 'passphrase', '');

				$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, 
					STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, 
					$ctx);

				// Create the payload body
				$body['aps'] = array(
					'badge' => +1,
					'alert' => $message,
					'sound' => 'default'
				);

				$payload = json_encode($body);

				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));

				if (!$result)
					echo 'Message not delivered' . PHP_EOL;
				else
					echo 'Message successfully delivered amar'.$message. PHP_EOL;

				// Close the connection to the server
				fclose($fp);


			}
			else{
				echo json_encode([
						"status" => "no device token found",
					]);
			}
		}
	
// Close connections
	mysqli_close($con);
?>