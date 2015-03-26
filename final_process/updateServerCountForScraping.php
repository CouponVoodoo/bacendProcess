<?php

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql = 'update jabongScrapedCategoryUrls set [Full url]=URLPart1+urlpart2
update jabongScrapedCategoryUrls set servercount=0 where retailertermid in (13419,10)';

$response = sqlsrv_query($conn,$sql); 



sqlsrv_close( $conn );

$a = update('flipkart.com',697,1);
$e = update('snapdeal.com',48,1);
//$b = update('jabong.com',20,1);
//$c = update('myntra.com',19,1);
/*
$d = update('jabong',48,$c);
$e = update('snapdeal',90,$d);
$f = update('firstcry',90,$e);
*/
echo $c .' jab'; 

function update($retailer,$num,$initialServerCount){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


$sql = 'select count ([full url]) as num from jabongScrapedCategoryUrls[nolock] where retailer=?';
$param = array($retailer);
$response = sqlsrv_query($conn,$sql,$param);
$data = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC);
$serverCount = round($data["num"]/$num);

$serverCount = $initialServerCount+$serverCount-1;
echo 'serverCount = '.$serverCount ;
for ($i=$initialServerCount; $i<=$serverCount;$i++) {
echo $i;

$sql ="update jabongScrapedCategoryUrls set serverCount = (?) where [full url] in (select top ".$num." [full url] from jabongScrapedCategoryUrls[nolock] where serverCount = 0 and retailer = (?))";
//  echo $sql;
$param = array($i,$retailer);
$response = sqlsrv_query($conn,$sql,$param);

if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}


}

$sql = 'update jabongScrapedCategoryUrls set servercount=1 where servercount=0 and retailer=(?)';
$param = array($retailer);
$response = sqlsrv_query($conn,$sql,$param);

sqlsrv_close( $conn );
return $i;
}