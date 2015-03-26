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

$sql = "TRUNCATE TABLE predictorResultTablesnapdeal";
$stmt = sqlsrv_query( $conn, $sql);   

$sql = "delete from scrapedproductsjabong where listingprice like 'n/a'";
$stmt = sqlsrv_query( $conn, $sql);   

$sql = "delete from scrapedproductsJabong where Product = ''";
$stmt = sqlsrv_query( $conn, $sql);   
  
echo $sql;


//$param = array($retailer);
//$response = sqlsrv_query($conn,$sql);

$fullJSON='';
$sql ="select  distinct  brand  from scrapedproductsjabong where retailerid in (10) ";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
 $fullJSON = str_replace("][",",",$fullJSON);

}
echo fullJSON;
$resultsArr = json_decode($fullJSON, true);
$response='';

sqlsrv_close( $conn );
 foreach($resultsArr as $datarow)
  {
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


createPredictorTargetTable($datarow['brand'],$conn);
}

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

$response='';

sqlsrv_close( $conn );
function createPredictorTargetTable($retailer,$conn) {
	echo $retailer;

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

$sql = "INSERT INTO [ShopSmart].[dbo].[predictorResultTableSnapdeal] ([ID],[SID],[Retailer],[brand],[FullUrl],[ProductUrl],[Category],[couponCode],[predictedCouponStatus],[Response],[LastCheckTime],[couponStatusType],[calculationType],[SIDlevelCouponWorkStatus],[MinOrderCoupon],[cpnDiscountType],[cpnDiscount],[ListingPrice],[LimitType],[LimitAmount],[LimitOn],[mrp],[couponCodeTitle],[ProductName],[ProductImage],[couponGroupType],[flipkartType])select '' ,'',cb.Retailer,sp.brand,sp.PageURL,sp.PageURL as prodUrl,sp.Category,cb.CouponCode,0,'','','','',0,cb.MinOrder,cb.DiscountType,cb.Discount,sp.ListingPrice,cb.LimitType,cb.LimitAmount,cb.LimitOn,sp.MRPprice,cb.couponCodeDescription,sp.Product,sp.ProductImage,cb.couponstatus,sp.flipkartType from predictorCouponDescRepository as cb join ScrapedProductsJAbong as sp on cb.Retailer = sp.Retailer and sp.brand = ? and cb.couponstatus >= 1 and sp.retailerid in (10) ";
  


//echo $sql;
$param = array($retailer);
$response = sqlsrv_query($conn,$sql,$param);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

//sqlsrv_close( $conn );
}



