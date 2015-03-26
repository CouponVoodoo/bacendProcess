<?php
require 'sdk.class.php';
$image_id  = 'ami-6f1f2d06';'ami-09d4e760';//'ami-a79badce';//'ami-7fd0e616';//'ami-553d0b3c';//'ami-3f417756';//'ami-61ac9b08';//'ami-fb536492';//'ami-3d556254';//'ami-a1695ec8';//'ami-399eaa50';//'ami-fbba8e92';//'ami-39476e50';//'ami-836f46ea';//'ami-f39cb29a';
$input = $argv[1];
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

