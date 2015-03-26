<?php
 //sleep(2000);
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$sql = 'update cachedCouponFinderResults set resultstatus = 0';

$response = sqlsrv_query($conn,$sql);
sqlsrv_close( $conn );

exec("php.exe submitRequestSpotInstance.php 30_flipkart");
//exec("php.exe submitRequestSpotInstance.php 67_jabong");
exec("php.exe submitRequestSpotInstance.php 10_firstcry");
echo 'step 1';
exit;
sleep(3600);
system('cmd /c C:\CronJobs\forcedServerTermination.bat'); 
//sleep(2000);

//exec("php.exe submitRequestSpotInstance.php 80_myntra");
//exec("php.exe submitRequestSpotInstance.php 32_shopclues");
//system('cmd /c C:\CronJobs\forcedServerTermination.bat'); 

//exec("php.exe submitRequestSpotInstance.php 80_myntra");

// 
echo 'step 2';
//exec("php.exe submitRequestSpotInstance.php 20_snapdeal");
sleep(4000);
system('cmd /c C:\CronJobs\forcedServerTermination.bat'); 


//exec("php.exe RunAWSInstanceMod.php 10_indiatimes");

//exec("php.exe submitRequestSpotInstance.php 60_flipkart");
//system('cmd /c C:\CronJobs\forcedServerTermination.bat'); 
sleep(2000);

echo 'step 3';

//exec("php.exe submitRequestSpotInstance.php 1_firstcry");
//exec("php.exe RunAWSInstanceMod.php 10_indiatimes");

sleep(1600);
system('cmd /c C:\CronJobs\forcedServerTermination.bat');  
 echo 'step 4';
echo 'servers launched';
sleep(1500);
echo 'strt';

$i=1;
$j=1;
while (1<100) {
	$j=$j+1;
while ($i<100){
echo $i;
system('cmd /c C:\CronJobs\forcedServerTermination.bat'); 

$i=$i+1;
echo $i.'------';
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$sql = "update cachedCouponFinderResults set nodestatus = 2 where  resultstatus = 1 and nodestatus <> 2 and Result not like '%bestcoupon%'";
$response = sqlsrv_query($conn,$sql);
sqlsrv_close( $conn );
echo 'step 2';

$check = '';
if ($i>"2"){echo 'llllllll'. $check;
	if ($check != "done"){
sleep(1500);
date_default_timezone_set('Asia/Kolkata');
$timestamp =  date('U');
$timeCheck = $timestamp-1000;
echo $timeCheck; 
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$sql ="select count(producturl) as num from [cachedCouponFinderResults][nolock] where timestamp > (?) and resultstatus = 1 ";
$params = array($timeCheck);
$response = sqlsrv_query($conn,$sql,$params);

$nidCheck=sqlsrv_fetch_array($response, SQLSRV_FETCH_ASSOC);

var_dump($nidCheck["num"]);

if ($nidCheck["num"] < 4) {
echo 'inside';
$serverCount = exec("php.exe assignServersForSecondRun.php");
echo $serverCount;
$cmd = "php.exe submitRequestSpotInstance.php ".$serverCount."_other";
echo $cmd;
$serverCount = exec($cmd);
$check = 'done';

		sqlsrv_close( $conn );exit;
}
}
}
}
exit;
}



?>