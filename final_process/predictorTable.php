<?php

  
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


$sql = "truncate table predictorResultTable";
$response = sqlsrv_query($conn,$sql);

//fullurl like '%http://www.shopclues.com/maxima-mens-black-watch-22572lmgb.html%'
$fullJSON="";  
$sql ="select * from cachedCouponFinderResults[nolock] where resultstatus = 1 and nodestatus 

<>2";
/*$sql = "select * from cachedCouponFinderResults[nolock] where fullurl in (select distinct fullurl  

from [PredictorOriginalComparisonTableDmp] where prediction <> original)  and nodestatus = 1";*/
$response1 = sqlsrv_query($conn,$sql);
  #create one master array of the records */

while( $datarow = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {
echo '------------------------------------------------------------------------ </br>';
echo $datarow["ProductUrl"];
//var_dump($datarow);
$sql ="select top 1 * from scrapedproducts[nolock] where pageurl like (?)";
$param = array('%'.str_replace("ampersand","&",$datarow["FullUrl"]).'%');
$response2 = sqlsrv_query($conn,$sql,$param);

if( $response2 === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$data = sqlsrv_fetch_array( $response2 , SQLSRV_FETCH_ASSOC) ;

$category = $data["Category"];
$retailer = $data["Retailer"];
$StartingPageUrl = $data["StartingPageURL"];

$sql ="select top 1 * from scrapedCategoryUrls[nolock] where  categorytermid =(?) and urlserialnumber=1 and retailer like (?)";
$param = array($category,'%'.$data["Retailer"].'%');
$response3 = sqlsrv_query($conn,$sql,$param);
if( $response3 === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$response3 = sqlsrv_query($conn,$sql,$param);
$data3 = sqlsrv_fetch_array( $response3 , SQLSRV_FETCH_ASSOC) ;
$StartingPageUrl = $data3["CategoryUrl"];

$resultsArr = json_decode( $datarow["Result"], true );
$headerArr = json_decode($datarow["header"], true );
//var_dump($headerArr);
$category=$headerArr['Category'];
$brand=$headerArr['ProductBrand'];
$productImage=$headerArr['ProductImage'];
$productName=$headerArr['ProductName'];
$listingPrice=$headerArr['ListingProductPrice'];
$mrp=$headerArr['MRPProductPrice'];
echo $category;

foreach ($resultsArr as $resultArr){
//var_dump($resultArr);
echo '^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^66';
//if ($resultArr
$UID = $datarow["ProductUrl"].$resultArr["couponCode"];
$lastCheckTime=$datarow["timestamp"];
//$domain = 'flipkart.com';


$sql ="INSERT INTO [ShopSmart].[dbo].[predictorResultTable]([ID],[SID],[Retailer],[brand],[FullUrl],[ProductUrl],[Category],[couponCode],[predictedCouponStatus],[Response],[LastCheckTime],[couponStatusType],[calculationType],[SIDlevelCouponWorkStatus],[MinOrderCoupon],[cpnDiscountType],[cpnDiscount],[ListingPrice],[url_coupon_Id],[LimitType],[LimitOn],[LimitAmount],[Mrp],[couponCodeTitle],[result],[bestcouponstatus],[bestcoupon],[bestcoupondesc],[ProductName],[ProductImage]) VALUES 
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

$param = array('','',$retailer,$brand,$datarow["FullUrl"],$datarow["ProductUrl"],$category,$resultArr["couponCode"],$resultArr["Successful"],$resultArr["Saving"],$lastCheckTime,'','','','','','',$listingPrice,'','','','',$mrp,$resultArr["description"],json_encode($resultArr),'','','',$productName,$productImage);
$response = sqlsrv_query($conn,$sql,$param);

if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

}
}
      
	  
$sqlToCheckNID = ";WITH CTE AS ( SELECT  *, MAX(response) OVER(PARTITION BY fullurl) MaxC2 FROM predictorresulttable)
UPDATE CTE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus = CASE WHEN MaxC2 = response and response <>0  THEN 1 ELSE 0 END
, bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}



$sqlToCheckNID = "update predictorresulttable set result = '{laveshBestCouponlavesh:'+CONVERT(varchar(10),BestCouponStatus)+',laveshSavinglavesh:lavesh'+CONVERT(varchar(200),Response)+'lavesh,laveshSuccessfullavesh:'+CONVERT(varchar(10),predictedCouponStatus)+',laveshcouponCodelavesh:lavesh'+couponCode+'lavesh,laveshdescriptionlavesh:lavesh'+couponCodeTitle+'lavesh,laveshdomainlavesh:lavesh'+retailer+'.comlavesh,laveshurllavesh:lavesh'+fullurl+'lavesh}'";
$sql =  str_replace('lavesh','"',$sqlToCheckNID);
echo $sql;
$maxNidInDb = sqlsrv_query($conn,$sql);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "drop table predictorCompiledResultTable
Select * into predictorCompiledResultTable from (SELECT  '' as id ,fullurl as BaseUrl,max(listingprice) AS listPrice,max(mrp) as MRP,max(response) AS Saving,max(listingprice)-max(Response) as NetPrice, max(bestcoupon) AS BestCouponCode,max(bestcoupondesc) AS BestCouponDesc,'[{'+STUFF((SELECT result +',' FROM (select distinct bestcoupondesc,brand,category,LastCheckTime,ProductName,ProductImage,listingprice,mrp,bestcoupon,result,fullurl,response from predictorResultTable AS a   ) as ab WHERE ab.fullurl = a.fullurl order by ab.response desc FOR XML PATH ('')) , 1, 1, '')  AS result,null as entity_id,brand,ProductName,ProductImage,Category,LastCheckTime,productname as pagetitle,max(bestcouponstatus)as BestCouponStatus,null as BrandId,null as loc,retailer,null as retailerId,'test testtesetestststststees' as bestCouponDisplay FROM predictorResultTable AS a GROUP BY fullurl,brand,ProductName,ProductImage,Category,LastCheckTime,retailer ) as a";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "
UPDATE predictorCompiledResultTable SET result = SUBSTRING(result, 0, LEN(result))+']'
UPDATE predictorcompiledresulttable 
SET pagetitle = CASE WHEN bestcouponstatus = 0 THEN ProductName +' Coupons @ '+UPPER(LEFT(Retailer,1))
 ELSE 'Save INR '+ CONVERT(varchar(200),saving)+' via coupons on '+ ProductName +' @ '+UPPER(LEFT(Retailer,1)) END
";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "UPDATE predictorcompiledresulttable 
SET retailerId = CASE WHEN retailer like '%jabong%' THEN 5
WHEN retailer like '%myntra%' THEN 8
WHEN retailer like '%flipkart%' THEN 13419 ELSE null END
";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "UPDATE predictorcompiledresulttable 
SET bestCoupondisplay = CASE WHEN bestcouponstatus = 1 THEN 'Guaranteed Coupons'
WHEN bestcouponstatus = 0 THEN 'Without Coupons' END
";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);//,$param_nid);
if( $maxNidInDb === false ) {
     die( print_r( sqlsrv_errors(), true));
}
	  
	  


sqlsrv_close( $conn );