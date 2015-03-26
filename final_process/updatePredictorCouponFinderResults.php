<?php

$fullJSON="";  
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
date_default_timezone_set('Asia/Kolkata');
$timestamp =  date('U');
$sql ="select distinct fullurl  from predictorResultTable[nolock] ";

$response1 = sqlsrv_query($conn,$sql);
//var_dump($response1);
if( $response1 === false ) {
     die( print_r( sqlsrv_errors(), true));
}

//$curl_handle=curl_init();

while( $datarow = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {
      
    $element = json_encode(array($datarow));
    $fullJSON = $fullJSON.$element;
     
}


$urlListJson= str_replace("][",",",$fullJSON);
//echo $urlListJson;
$urlListArr = json_decode($urlListJson,true);
//var_dump($urlListArr);
  foreach($urlListArr as $url)
{//echo $url;
$fullJSON1='';
    //$url='http://www.jabong.com/lovely-chick-Blue-Belly-Shoes-444972.html';
$sql ="select distinct(result) from predictorResultTable[nolock] where fullurl = (?)";
$param = array($url['fullurl']);
$response1 = sqlsrv_query($conn,$sql,$param);
if( $response1 === false ) {
     die( print_r( sqlsrv_errors(), true));
}
while( $datarow1 = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {
      
    $element = json_encode(array($datarow1));
    $fullJSON1 = $fullJSON1.$element;
     
}

$res = str_replace('"}"}','"}',str_replace('][',',',str_replace('\"','"',str_replace('{"result":"','',$fullJSON1))));
//$res = str_replace("][",",",$fullJSON);
echo($res);
$obj = json_decode($res, true);
//var_dump($obj);

usort( $obj, 'cmp');
echo $obj[0]["Successful"];
if ($obj[0]["Successful"] == 1){
$obj[0]["BestCoupon"] = 1;

}
//var_dump($obj);exit;
$sql = "select headerjson from [scrapedproducts] where pageurl = (?)";
$params = array($url['fullurl']);
$maxNidInDb = sqlsrv_query($conn,$sql,$params);

if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$nidCheck=sqlsrv_fetch_array($maxNidInDb, SQLSRV_FETCH_ASSOC);
$header=$nidCheck["headerjson"];
//if (empty($nidCheck)) {
$sql ="INSERT INTO [ShopSmart].[dbo].[cachedCouponFinderResults]([FullUrl],[ProductUrl],[timestamp],[Result],[header],[couponCode],[ResultStatus],[InstanceId])
     VALUES (?,?,?,?,?,'',0,'','','','',1,'')";
  
$param = array($url['fullurl'],$url['fullurl'],$timestamp,$res,$header );
$response1 = sqlsrv_query($conn,$sql,$param);
//}
  /*  else{    
$sql ="update cachedcouponfinderresults set result = (?),set ResultStatus = 1, set nodestatus = 0 ,set timestamp = (?) where fullurl = (?) ";
$param = array($res ,$timestamp,$url);
$response1 = sqlsrv_query($conn,$sql,$param);
    }
*/
//
}

function cmp( $a, $b){ 
  if( !isset( $a['Saving']) && !isset( $b['Saving'])){ 
    return 0; 
  } 
 
  if( !isset( $a['Saving'])){ 
    return -1; 
  } 
 
  if( !isset( $b['Saving'])){ 
    return -1; 
  } 
 
  if( $a['Saving'] == $b['Saving']){ 
    return 0; 
  } 
 
  return (($a['Saving'] < $b['Saving']) ? 1 : -1); 
} 
