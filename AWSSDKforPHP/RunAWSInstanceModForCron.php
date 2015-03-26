<?php

require 'sdk.class.php';
$image_id  = 'ami-37674e5e';//'ami-f39cb29a';//'ami-bddef1d4';//'ami-d52d00bc';//'ami-f992b090';//'ami-e982a280';//'ami-031d3c6a';//'ami-3b6e4952';//'ami-d3e1bb4';//'ami-61597c08'; //Image ID, found at https://console.aws.amazon.com/ec2/v2/home?region=us-east-1#Instances:
$input = $_GET["q"];
$i = explode("_", $input)[0];
$retailer = explode("_", $input)[1];
for ($x=1; $x<=$i; $x++){
$ec2 = new AmazonEC2();
//Start Instance
echo $x;
$response = $ec2->run_instances($image_id, 1, 1, array(
    'SecurityGroup' => 'quick-start-1','KeyName' => 'couponVodoo','InstanceType' => 't1.micro','UserData' => base64_encode($x.'_'.$retailer)
));

if(!$response->isOK()){
	echo 'Error - Something went wrong' ;   
	print_r($response);} 
}
?>

