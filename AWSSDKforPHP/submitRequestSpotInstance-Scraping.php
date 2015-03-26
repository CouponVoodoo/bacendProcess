// Setup the specifications of the launch. This includes the
// instance type (e.g. t1.micro) and the latest Amazon Linux
// AMI id available. Note, you should always use the latest
// Amazon Linux AMI id or another of your choosing.
<?php
require_once 'sdk.class.php';

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


#OpenConnections
if( $conn ) {

    }else{

         //  die( print_r( sqlsrv_errors(), true));
    }
$response1='';

$sqlToCheckNID ="truncate table scrapedproductsjabong";
 
$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'hbbh';
     die( print_r( sqlsrv_errors(), true));
} 

$sqlToCheckNID ="truncate table predictorcompiledresulttable";

$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'hbbh';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID ="truncate table predictorcompiledresulttableFlipkart";

$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'hbbh';
     die( print_r( sqlsrv_errors(), true));
}
$sqlToCheckNID ="truncate table predictorcompiledresulttableSnapdeal";

$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'hbbh';
     die( print_r( sqlsrv_errors(), true));
} 

$sqlToCheckNID ="truncate table predictorcompiledresulttableAmazon";

$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'hbbh';
     die( print_r( sqlsrv_errors(), true));
}
  

$image_id  = 'ami-602c7d08';//'ami-248bdd4c';//'ami-609acc08';//'ami-6e481e06';//'ami-422c7a2a';//'ami-7e0f7c16';//'ami-422c7a2a';//'ami-62b4df0a';//'ami-3e9cfa56';//'ami-50eb7a38';//'ami-fca03494';//'ami-8aea48e2';//'ami-7ee23b16';//'ami-e2558a8a';//'ami-0a73bb62';//'ami-4aaa6622';//'ami-1e35f576';//'ami-bcca0ed4';//'ami-b6f134de';//'ami-3adc2652';//'ami-3a827952';//'ami-7844bc10';//'ami-1036cb78';//'ami-6ccb3904';//,'ami-60ed1908';//'ami-fc6e8494';
 
$input = $argv[1];
echo $input;echo '---';
$i = explode("_", $input)[1];
$retailer = explode("_", $input)[0];
//echo $retailer;


$pos = strpos($retailer, 'flipkart');

if ($retailer == 'flipkart' || $retailer == 'zovi' || $retailer == 'zivame') { 
$serverType='t1.micro';
$bidPrice=.02;
echo 'micro';
}
else if ($retailer=='snapdeal'){
echo 'snap';
$image_id='ami-861588ee';//'ami-50e17338';//'ami-c8e072a0';//'ami-7a31a012';//'ami-2a65f142';//'ami-48299f20';//'ami-541ea93c';//'ami-3e5ffa56';//'ami-d219c0ba';//'ami-7006cd18';
//$serverType='m3.medium';
//$bidPrice=.4;
$serverType='t1.micro';
$bidPrice=.02;
}
else
{ echo 'micro';
$serverType='t1.micro';
$bidPrice=.02;
}
//echo strpos($retailer, 'zivame');

for ($x=1; $x<=$i; $x++){
//echo '6666';
echo $x.'_'.$retailer; 

$ec2 = new AmazonEC2();
$spot_opt = array(
	'InstanceCount' => 1,
        'Type' => 'one-time', 
	'LaunchSpecification' => array(
		'ImageId' => $image_id,
		'SecurityGroup' => 'quick-start-1',
		'InstanceType' => $serverType,
                'UserData'=> base64_encode($retailer.'_'.$x),
                'KeyName'  => 'couponVodoo'   
	)
);	

// Request 1 x t1.micro instance with a bid price of $0.03.
$response = $ec2->request_spot_instances($bidPrice, $spot_opt);
echo($x);
//var_dump($response);
if (!$response->isOK()) 
{
	print_r($response);
	exit();
}
}
?>