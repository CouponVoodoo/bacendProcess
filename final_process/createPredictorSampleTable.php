<?php

updateServerCount();
exit;


$check_counter=6;
$ignore_count=0;

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }
$fullJSON='';


$sql ="update cachedCouponFinderResults set fullurl = replace(fullurl,'ampersand','&') where resultstatus=1";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);


$sql ="truncate table [predictorSampleTable]";// where uid like '%jabong%'";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);

$sql = "DBCC CHECKIDENT('predictorSampleTable', RESEED, 0)";
$response = sqlsrv_query( $conn, $sql);


$sql ="select distinct sid,countproducturl,minorderarray  from predictorSummaryTable[nolock] where samplestatus = 0";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);
var_dump($response);
//while( $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
$fullJSON = str_replace("][",",",$fullJSON);
//echo $fullJSON;
}

$resultsArr = json_decode($fullJSON, true);
//var_dump($resultsArr);
//$fullJSONarr = '';
 foreach($resultsArr as $datarow)
  {

	
	$uid = $datarow['sid'];
echo $uid;
  $countproducturl = $datarow['countproducturl'];
   $minorderarray = json_decode($datarow['minorderarray']);
  if ($countproducturl <$ignore_count) {
    echo '-------->ignore';
     $sql ="update predictorSummaryTable set samplestatus = 3 where sid = (?)";
$param = array($uid);
	 $response = sqlsrv_query($conn,$sql,$param);
     

  }
  else if ($countproducturl<$check_counter){
    echo '########full';
  insertIntoPredictorSummaryTable($uid,$countproducturl,0,$conn);
  }
  else {
    
    echo '********normal';
    
   $min_order_amount = count($minorderarray)-1;
    $resultCount = 0;
    while ($resultCount < $check_counter){
       echo '&&&&&&&&&&&&&&&&&&&while'.$resultCount.'--';
      var_dump(count($minorderarray));
     $resultCount1 = createPredictorSampleTable($uid,$minorderarray[$min_order_amount]->minOrder,$check_counter);
     $resultCount = $resultCount+$resultCount1 ;
     $min_order_amount= $min_order_amount-1;
    }
  }
  	echo $uid;
	updateRunCount($uid);
}
echo 'updateServerCount';
updateSummaryTable();
updateServerCount();

function updateSummaryTable(){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

# OpenConnections
if( $conn ) {

    }else{

           die( print_r( sqlsrv_errors(), true));
    }

$sqlToCheckNID ="UPDATE predictorsummarytable SET predictorsummarytable.countSampled= b.samp from (select uid,COUNT(distinct fullurl) as samp from predictorsampletable group by uid) as b JOIN predictorsummarytable ON predictorsummarytable.sID = b.uid";
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
sqlsrv_close( $conn );
	
}
function updateServerCount(){
echo 'Inside updateServerCount Insile';  
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

# OpenConnections
if( $conn ) {

    }else{

           die( print_r( sqlsrv_errors(), true));
    }
  $serverCount=1;
  while (1>0){
$sqlToCheckNID ="Select top 40 * from (select distinct fullurl from [predictorSampletable][nolock]  

where runcount = 1 and runstatus = 0) as a ";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
    //var_dump($maxNidInDb);
$fullJSON='';
$purl = "'h'";


 while( $datarow = sqlsrv_fetch_array( $maxNidInDb , SQLSRV_FETCH_ASSOC) ) {
if (empty($datarow)){echo 'done';sqlsrv_close( $conn ); return 'done';}
//echo $datarow["ProductUrl"];
   $purl = $purl. ", '".$datarow["fullurl"]. "'";
   $element = json_encode(array($datarow));
    $fullJSON = $fullJSON.$element;
    
}
    //echo $purl;

$sqlToCheckNID ="update [predictorSampletable] set runstatus = (?) where fullurl in (".$purl.")";
  echo $sqlToCheckNID;
  $param_nid = array($serverCount);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
exit;
  $serverCount = $serverCount+1;
  //sqlsrv_close( $conn );
  }
sqlsrv_close( $conn );

}

function updateRunCount($uid){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

  $sql ="update [predictorSampleTable] set runcount = 1 ,runstatus = 0 where fullurl in (select Top 

3 * from (select distinct fullurl from [predictorSampleTable] where uid = (?)) as a) ";
	
$param = array($uid);
$response2 = sqlsrv_query($conn,$sql,$param);
sqlsrv_close( $conn );
}
function createPredictorSampleTable($uid,$minorderarray,$check_counter){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

if ($minorderarray =='' || empty($minorderarray)){$minorderarray=1;}
    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }
	
  $sql ="select count(*) as num from (select top ".$check_counter." * from [predictorTargetTable] where uid = (?) and listingprice>(?)) as a";
	
$param = array($uid,$minorderarray);
$response2 = sqlsrv_query($conn,$sql,$param);
  $result = sqlsrv_fetch_array( $response2 , SQLSRV_FETCH_ASSOC);
  $resultCount = $result['num'];
  
  
  insertIntoPredictorSummaryTable($uid,$check_counter,$minorderarray,$conn);
  echo '[[[[[[[[[[[[[[[[[[[[[['.$resultCount.'minorderarray '.$minorderarray;
sqlsrv_close( $conn );
  return $resultCount;

}
function insertIntoPredictorSummaryTable($uid,$count,$ListingPrice,$conn){
  /*
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }
*/
$sql ="INSERT INTO [ShopSmart].[dbo].[predictorSampleTable] ([UID],[Retailer],[brand],[FullUrl],

[ProductUrl],[Category],[couponCode],[successful],[Response],[timestamp],[ListingPrice],

[minOrderAmt],[runcount],[runstatus],[url_coupon_id])  
select [UID],[Retailer],[brand],[FullUrl],[ProductUrl],[Category],[couponCode],'','','',

[ListingPrice],(?),0,0,[FullUrl]+[couponCode] FROM [ShopSmart].[dbo].[predictorTargetTable] where fullurl in (select 

distinct top ".$count." fullurl from [predictorTargetTable] where ListingPrice > (?) and uid = 

(?))";
	
$param = array($ListingPrice,$ListingPrice,$uid);
$response2 = sqlsrv_query($conn,$sql,$param);
  
     $sql ="update predictorSummaryTable set samplestatus = 1,countSampled=(?) where sid = (?)";
$param = array($count,$uid);
	 $response = sqlsrv_query($conn,$sql,$param);
     
  
//sqlsrv_close( $conn );
}
sqlsrv_close( $conn );
?>
