// Setup the specifications of the launch. This includes the
// instance type (e.g. t1.micro) and the latest Amazon Linux
// AMI id available. Note, you should always use the latest
// Amazon Linux AMI id or another of your choosing.
<?php
require_once 'sdk.class.php';

$image_id  = 'ami-a59f8fcc';//'ami-7fe7ed16';//'ami-af959cc6';//'ami-6f1f2d06';'ami-09d4e760';//'ami-a79badce';//'ami-7fd0e616';//'ami-553d0b3c';//'ami-3f417756';//'ami-61ac9b08';//'ami-fb536492';//'ami-3d556254';//'ami-a1695ec8';//'ami-399eaa50';//'ami-fbba8e92';//'ami-39476e50';//'ami-836f46ea';//'ami-f39cb29a';
$input = $argv[1];
$i = explode("_", $input)[0];
$retailer = explode("_", $input)[1];

for ($x=1; $x<=$i; $x++){
//echo $x.'_'.$retailer;

$ec2 = new AmazonEC2();
$spot_opt = array(
	'InstanceCount' => 1,
        'Type' => 'one-time', 
	'LaunchSpecification' => array(
		'ImageId' => $image_id,
		'SecurityGroup' => 'quick-start-1',
		'InstanceType' => 't1.micro',
                'UserData'=> base64_encode($x.'_'.$retailer),
                'KeyName'  => 'couponVodoo'   
	)
);	

// Request 1 x t1.micro instance with a bid price of $0.03.
$response = $ec2->request_spot_instances('0.02', $spot_opt);
echo($x);
//var_dump($response);
if (!$response->isOK()) 
{
	print_r($response);
	exit();
}
}
?>