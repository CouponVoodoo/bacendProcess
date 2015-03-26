<?php

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql = "delete from cachedCouponFinderResults where ProductUrl like '%myntra%' and ResultStatus = 1 and Result not like '%bestcoupon%'";
$response = sqlsrv_query($conn,$sql);
//echo 'step1';
$sql = 'update scrapedProducts set status = 0 where status <> 0';
$response = sqlsrv_query($conn,$sql);

sqlsrv_close( $conn );
//echo 'step2';
$a = update('myntra',40,1);
//echo 'step3';
$b = update('shopclues',40,$a);
//echo 'step4';
$c = update('indiatimes',90,$b);
//echo 'step5';
$d = update('jabong',40,$c);
//echo 'step6';
//$e = update('snapdeal',90,$d);
//echo 'step7';
$e = update('firstcry',90,$d);
//echo 'step8';
$f = update('flipkart',50,$e);
//echo 'step9';
echo $f;
//echo $a;

function update($retailer,$num,$initialServerCount){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


$sql = 'select count (pageurl)as num from scrapedProducts[nolock] where pageurl not in (select distinct fullurl from 
cachedcouponfinderResults[nolock] where resultstatus=1) and status = 0 and retailer = (?) ';
$param = array($retailer);
$response = sqlsrv_query($conn,$sql,$param);

  if( $response === false ) {

         die( print_r( sqlsrv_errors(), true));
    }
$data = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC);
	$serverCount = $data["num"]/$num;

$serverCount = $initialServerCount+$serverCount;
for ($i=$initialServerCount; $i<=$serverCount;$i++) {


$sql ="update scrapedProducts set status = (?) where Pageurl in (select top ".$num." pageurl from 

scrapedProducts[nolock] where pageurl not in (select distinct fullurl from cachedcouponfinderResults[nolock] 

where resultstatus=1) and status = 0 and retailer = (?) order by id desc)";
  
$param = array($i,$retailer);
$response = sqlsrv_query($conn,$sql,$param);
}
sqlsrv_close( $conn );
return $i;
}