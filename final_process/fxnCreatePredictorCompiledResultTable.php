<?php

function createFlipkart($conn,$tableName){



//exit;

$fullJSON='';
if ($tableName=='predictorresulttableSnapdeal'){
$retailer="('Snapdeal')";
$sql ="select distinct brand  from scrapedproductsjabong[nolock] where retailerid = 10";
$destTable='predictorCompiledResultTableSnapdeal';
}

else if 

($tableName=='predictorresulttableFlipkart'){
$retailer="('Flipkart')";
$sql ="select distinct brand  from scrapedproductsjabong[nolock] where retailerid = 13419";
$destTable='predictorCompiledResultTableFlipkart';
}
else if 

($tableName=='predictorresulttableAmazon'){
$retailer="('Amazon','Fabfurnish')";
$sql ="select distinct brand  from scrapedproductsjabong[nolock] where retailerid in (14782,14792)";
$destTable='predictorCompiledResultTableAmazon';
}
else {
$retailer="('Myntra','jabong','zovi','zivame')";
$sql ="select distinct brand  from scrapedproductsjabong[nolock] where retailerid not in
(14782,13419,14792,10)";
$destTable='predictorCompiledResultTable';
}
//$param = array('%'.$Retailer.'%');
$response = 

sqlsrv_query($conn,$sql);
if( $response=== false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), 

true));
}

$sql="delete from CategoryCoupons where retailer in ".$retailer;
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step13';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

$sql="delete from BrandCoupons where retailer in ".$retailer;
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step13';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}


$sql="insert into CategoryCoupons select distinct category,couponCode,couponCodetitle,Retailer,1 from ".$tableName."[nolock] where predictedcouponstatus <>0";
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step13';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

$sql="insert into BrandCoupons select distinct Brand,couponCode,couponCodetitle,Retailer,1 from ".$tableName."[nolock] where predictedcouponstatus <>0";
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step13';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}
$sql="update ".$tableName." set BestCouponstatus=3 where BestCouponstatus=0 ";
echo $sql;
$maxNidInDb =sqlsrv_query($conn,$sql);
echo 'bs update';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

$sql = "truncate table ".$destTable;//
$maxNidInDb =sqlsrv_query($conn,$sql);
echo 'bs update';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

//var_dump($response);
//while( $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {
echo 'in 1'; 
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
echo 'start';
	

 
	$brand = $datarow['brand'];
echo $brand;

$sqlToCheckNID = "
insert into ".$destTable." select * from (SELECT  '' as id ,fullurl as BaseUrl,max(listingprice) AS listPrice,max(mrp) as MRP,max(response) AS Saving,max(listingprice)-max(Response) as NetPrice, max(bestcoupon) AS BestCouponCode,max(bestcoupondesc) AS BestCouponDesc,'[{'+STUFF((SELECT result +',' FROM (select distinct bestcoupondesc,brand,category,LastCheckTime,ProductName,ProductImage,listingprice,mrp,bestcoupon,result,fullurl,response from ".$tableName." AS a   ) as ab WHERE ab.fullurl = a.fullurl  order by ab.response desc FOR XML PATH ('')) , 1, 1, '')  AS result,null as entity_id,brand,ProductName as  ProductName,ProductImage,Category,LastCheckTime,brand+' '+productname as pagetitle,min(bestcouponstatus)as BestCouponStatus,null as BrandId,null as loc,retailer,null as retailerId,'gvgvgvgvghvghvghvghvgvgvgv' as bestCouponDisplay FROM ".$tableName." AS a where brand = ? GROUP BY fullurl,brand,ProductName,ProductImage,Category,LastCheckTime,retailer ) as a";
$param_nid=array($brand);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'insert done';
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
 

$sql= "Delete from ".$tableName." where brand =?";
$param_nid=array($brand);
//$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'delete done';
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
echo 'proc end';
$sql="update ".$destTable." set BaseUrl=REPLACE(BaseUrl,'''','') where brand =?";
echo $sql;
$maxNidInDb =sqlsrv_query($conn,$sql,$param_nid);
echo 'bs update';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

$sql="update ".$destTable." set BestCouponstatus=0 where bestCouponstatus=3 and brand =?";
echo $sql;

$maxNidInDb =sqlsrv_query($conn,$sql,$param_nid);
echo 'reert back';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

}
echo 'loop done';

$sql="truncate table ".$tableName."";
echo $sql;

$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'reert back';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}


}

