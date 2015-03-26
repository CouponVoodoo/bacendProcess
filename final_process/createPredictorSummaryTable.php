<?php

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

echo '2';

$sql = "truncate table predictorsummaryTable";// where sid like '%myntra%'";
$stmt = sqlsrv_query( $conn, $sql);   


echo '1';
main('jabong',$conn);
main('myntra',$conn);
sqlsrv_close( $conn );
function main($retailer,$conn){


$sql = "select distinct minOrder as minOrder from predictorCouponDescRepository where retailer like  (?) and couponstatus=-1";
echo $sql;
$param = array('%'.$retailer.'%');
$maxNidInDb = sqlsrv_query($conn,$sql,$param);
$fullJSON='';
$purl = "'h'";
while( $datarow = sqlsrv_fetch_array( $maxNidInDb , SQLSRV_FETCH_ASSOC) ) {
//($datarow["ProductUrl"]);
	//$purl=$purl." , '".$datarow["ProductUrl"]."'";
    $element = json_encode(array($datarow));
    $fullJSON = $fullJSON.$element;
     
}
$fullJSON = str_replace("][",",",$fullJSON);
	echo $fullJSON;
	$dataArr = json_decode($fullJSON,true);
	//var_dump($dataArr);
	//$sortedDataArr=	usort($dataArr, 'my_sort');
usort( $dataArr, 'cmp');
	//var_dump($dataArr);
$dataJson = json_encode($dataArr);

$sql ="select distinct uid ,couponcode from predictortargettable where retailer like (?)";
$param = array('%'.$retailer.'%');
$response = sqlsrv_query($conn,$sql,$param );
	if ($response === false) {
                die(print_r(sqlsrv_errors(), true));
            }
		
//var_dump($response);


while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
$fullJSON = str_replace("][",",",$fullJSON);
//echo $fullJSON;
}

$resultsArr = json_decode($fullJSON, true);
//var_dump($resultsArr);
//exit;
//$fullJSONarr = '';
$uidInternal='';
 foreach($resultsArr as $datarow)
  {


$uid = $datarow["uid"];
echo $uid.'internal<----------------------------->'.$uidInternal;
if ($uid != $uidInternal){
$uidInternal=$uid;
$sql = "select COUNT(distinct fullurl) as prodCount from predictortargettable where uid = (?)";
echo $sql;
$param = array($uid);
$response = sqlsrv_query($conn,$sql,$param);
$datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ;

$ProdCount = $datarow["prodCount"];

echo $ProdCount;


}
$couponCode = $datarow["couponcode"];
	echo $uid;

$retailer = explode( '-', $uid )[0];

echo $dataJson;
	createSummaryTable($uid,$couponCode,$dataJson,$ProdCount);

}
}

function createSummaryTable($uid,$couponCode,$dataJson,$ProdCount) {
	
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }


	//exit;

$sql = "INSERT INTO [ShopSmart].[dbo].[predictorSummaryTable]([SID],[CouponCode],[CountProductURL],

[MinOrderArray],[SampleStatus],[CountSampled],[CountSuccessful],[CountUnsuccessful],[CountError]) 
values (?,?,?,?,'','','','','')";

echo $sql;

$param = array($uid,$couponCode,$ProdCount,$dataJson);
$response = sqlsrv_query($conn,$sql,$param);

sqlsrv_close( $conn );


}
function cmp( $a, $b){ 
  if( !isset( $a['minOrder']) && !isset( $b['minOrder'])){ 
    return 0; 
  } 
 
  if( !isset( $a['minOrder'])){ 
    return -1; 
  } 
 
  if( !isset( $b['minOrder'])){ 
    return 1; 
  } 
 
  if( $a['minOrder'] == $b['minOrder']){ 
    return 0; 
  } 
 
  return (($a['minOrder'] > $b['minOrder']) ? 1 : -1); 
} 


?>

