<?php
//exit; 
require 'sdk.class.php';
$instance_id = $_GET["q"];
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
 
//$ec2 = new AmazonEC2();
 
//$response = $ec2->cancel_spot_instance_requests('sir-769afa02');
 
if ($instance_id=='i-a2384843'){exit;}

$ec2 = new AmazonEC2();

$response = $ec2->terminate_instances($instance_id);
 
if(!$response->isOK()){
	echo 'Error - Something went wrong' ;   
	print_r($response);
} 

$sql ="update [LaunchedServersInfo] set forcefullyTerminated = 'normal' where instanceid = (?) ";
$params = array($instance_id);
$response = sqlsrv_query($conn,$sql,$params);
sqlsrv_close( $conn );

?> 