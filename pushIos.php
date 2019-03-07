<?php
define("SOUND", "default");

function applepush($deviceToken,$payload){


	$payload = json_encode($payload);
	$apnsHost = 'gateway.push.apple.com'; // production
	//$apnsHost = 'gateway.sandbox.push.apple.com'; //dev 
	$apnsPort = '2195';
	$apnsCert = 'yourpemfilename.pem';//change it with your pem file name
	$passPhrase = '';
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);		 
	$apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
	
	if($apnsConnection == false){
	  echo "False";//return;
	  exit;
	} 
	$apnsMessage = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
	if(fwrite($apnsConnection, $apnsMessage)) {

	}
	unset($payload);
	fclose($apnsConnection);	
}

$payload['aps'] = array('alert'=>$message, 'sound' => SOUND);//You can add any more data if want to send in this array

applepush($id,$payload);// here id is device id on which you want to send push

?>