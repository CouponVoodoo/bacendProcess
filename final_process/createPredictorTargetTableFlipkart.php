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

$sql = "TRUNCATE TABLE predictorResultTableFlipkart";
$stmt = sqlsrv_query( $conn, $sql);   

$sql = "delete from scrapedproductsjabong where listingprice like 'n/a'";
$stmt = sqlsrv_query( $conn, $sql);   

echo $sql;
//$param = array($retailer);
$response = sqlsrv_query($conn,$sql);

$fullJSON='';
$sql ="select distinct brand  from scrapedproductsjabong[nolock] where retailerid=13419";
$response = sqlsrv_query($conn,$sql);

while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
 $fullJSON = str_replace("][",",",$fullJSON);

}

$resultsArr = json_decode($fullJSON, true);
$response='';
$sql ="IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[predictorResultTable]') AND name = N'brand')
DROP INDEX [brand] ON [dbo].[predictorResultTable] WITH ( ONLINE = OFF )

";
//$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql ="IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[predictorResultTable]') AND name = N'fullurl')
DROP INDEX [fullurl] ON [dbo].[predictorResultTable] WITH ( ONLINE = OFF )
";
//$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

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
$sql ="CREATE NONCLUSTERED INDEX [fullurl] ON [dbo].[predictorResultTable] 
(
	[fullurl] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
 ";
//$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql ="CREATE NONCLUSTERED INDEX [brand] ON [dbo].[predictorResultTable] 
(
	[brand] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
 ";
//$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );
function createPredictorTargetTable($retailer,$conn) {
	echo $retailer;

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }
$sql = "INSERT INTO [ShopSmart].[dbo].[PredictorTargetTable]([UID],[Retailer],[brand],[FullUrl],[ProductUrl],[Category],[ProductUpdateDate],[couponCode],[couponCodeTitle],[couponCodeDescription],[couponCodeExpiryDate],[couponCodeSource],[couponCodeExtractedTimestamp],predictorInclusion,[couponWorks],[Savings],[LastCheckTime],[Result],[MinOrderCoupon],[cpnDiscountType],[cpnDiscount],[ListingPrice],[MrpPrice],[LimitType],[LimitAmount],[LimitOn],[ProductName],[ProductImage],[couponGroupType],[flipkartType])select '' as uid,cb.Retailer,sp.brand,sp.PageURL,sp.PageURL as prodUrl,sp.Category,sp.timestamp,cb.CouponCode,cb.couponCodeDescription,cb.couponCodeDescription,'','',' ' as time,0 ,' ' as couponWorks,0 as savings,getdate() as LastCheckTime,' ' as result,cb.MinOrder,cb.DiscountType,cb.Discount,sp.ListingPrice,sp.MRPprice,cb.LimitType,cb.LimitAmount,cb.LimitOn,sp.Product,sp.ProductImage,cb.couponstatus,sp.flipkartType from predictorCouponDescRepository as cb join ScrapedProductsJAbong as sp on cb.Retailer = sp.Retailer and sp.brand = ? and cb.couponstatus >= 1 and sp.retailerId=13419";
  $response='';
//echo $sql;
$param = array($retailer);
//$response = sqlsrv_query($conn,$sql,$param);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sql = "INSERT INTO [ShopSmart].[dbo].[predictorResultTableFlipkart] ([ID],[SID],[Retailer],[brand],[FullUrl],[ProductUrl],[Category],[couponCode],[predictedCouponStatus],[Response],[LastCheckTime],[couponStatusType],[calculationType],[SIDlevelCouponWorkStatus],[MinOrderCoupon],[cpnDiscountType],[cpnDiscount],[ListingPrice],[LimitType],[LimitAmount],[LimitOn],[mrp],[couponCodeTitle],[ProductName],[ProductImage],[couponGroupType],[flipkartType])select '' ,'',cb.Retailer,sp.brand,sp.PageURL,sp.PageURL as prodUrl,sp.Category,cb.CouponCode,0,'','','','',0,cb.MinOrder,cb.DiscountType,cb.Discount,Replace(sp.ListingPrice,',',''),cb.LimitType,cb.LimitAmount,cb.LimitOn,Replace(sp.MRPprice,',',''),cb.couponCodeDescription,sp.Product,sp.ProductImage,cb.couponstatus,sp.flipkartType from predictorCouponDescRepository as cb join ScrapedProductsJAbong as sp on cb.Retailer = sp.Retailer and sp.brand = ? and cb.couponstatus >= 1 and sp.Retailer='flipkart'";
  


//echo $sql;
$param = array($retailer);
$response = sqlsrv_query($conn,$sql,$param);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

//sqlsrv_close( $conn );
}



