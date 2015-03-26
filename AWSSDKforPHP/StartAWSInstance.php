<?php

require 'sdk.class.php';

$instance_id  = 'i-c690d3a0'; //Image ID, found at https://console.aws.amazon.com/ec2/v2/home?region=us-east-1#Instances:

$ec2 = new AmazonEC2();

//Start Instance
$response = $ec2->start_instances($instance_id);

//Stop Instance
//$response = $ec2->stop_instances($instance_id);

if(!$response->isOK()){
	echo 'Error - Something went wrong' ;   
	print_r($response);
}
?>