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





$sql="delete from flipkartscrapedoffers where offerDescription =''";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}



$sql="insert into flipkartscrapedoffers values('','',5000,1,1,'flipkart.com')";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}



$sql = "update flipkartscrapedoffers set type = 0 where numOfProd<900";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sql = "update flipkartscrapedoffers set type = 0 where OfferDescription like '%book%'";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}



echo 'ste2p';
$sql = "delete from [predictorCouponDescRepository] where couponCode like '%flipkart%'";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}
echo 'ste3p';

$sql = "INSERT INTO [ShopSmart].[dbo].[predictorCouponDescRepository]([couponCode],[Retailer],[CouponIdentifier],[couponCodeDescription],[Total],[CouponStatus],[MinOrder],[DiscountType],[Discount],[LimitType],[LimitAmount],[LimitOn]) 
select 'Flipkart_Offer_'+Convert(varchar(100),type),'flipkart','',OfferDescription,0,TYPE,0,'','','','','' from flipkartscrapedoffers where isvalidoffer = 1 and TYPE>0";

$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

echo 'ste4p';

$sql = "delete from couponsByBrand where couponCode like '%flipkart%'";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

echo 'ste5p';
$sql="INSERT INTO [ShopSmart].[dbo].[CouponsByBrand] select 1,'',couponcodedescription,'code','flipkart',couponcode,'','','',couponcodedescription,'','nation',-1 from predictorCouponDescRepository where Retailer like '%flipkart%' ";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {echo 'error ste5p';
     die( print_r( sqlsrv_errors(), true));
}


$sql = "Delete from jabongScrapedCategoryUrls where retailerTermId=13419";
$stmt = sqlsrv_query( $conn, $sql);   

$sql = "INSERT INTO [ShopSmart].[dbo].[jabongScrapedCategoryUrls] ([CategoryTermId],[Category],[CategoryParent],[RetailerTermId],[Retailer],[URLSerialNumber],[Full url],[URLPart1],[URLPart2],[ProductCount],[Brand],[FlipkartType]) select a.CategoryTermId,a.Category,a.CategoryParent,a.RetailerTermId,a.Retailer,a.URLSerialNumber,a.[Full url],a.URLPart1, b.offerPart2Link,3000,'None',b.Type from flipkartscrapedCategoryUrls as a join flipkartscrapedoffers as b on a.retailer=b.retailer where b.Type>0 and b.isValidOffer =1 and b.Retailer like '%flipkart%'";

//$sql = "INSERT INTO [ShopSmart].[dbo].[jabongScrapedCategoryUrls] ([CategoryTermId],[Category],[CategoryParent],[RetailerTermId],[Retailer],[URLSerialNumber],[Full url],[URLPart1],[URLPart2],[ProductCount],[Brand],[FlipkartType]) select a.CategoryTermId,a.Category,a.CategoryParent,a.RetailerTermId,a.Retailer,a.URLSerialNumber,'',a.categoryUrl, b.offerPart2Link,3000,'None',b.Type from scrapedCategoryUrls as a join flipkartscrapedoffers as b on a.retailer=b.retailer where b.Type>1 and b.isValidOffer =1";
  
//echo $sql;
//$param = array($retailer);
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sql="delete from snapdealscrapedoffers where offerdescription=''";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql="insert into snapdealscrapedoffers values('','',1,3000,1,'snapdeal.com')";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql = "delete from [predictorCouponDescRepository] where retailer like '%snapdeal%'";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}


$sql = "insert into predictorCouponDescRepository select type,'snapdeal','',OfferDescription,0,1,0,'',0,'',0,'' from snapdealScrapedOffers";

$response = sqlsrv_query($conn,$sql);
if( $response === false ) {echo 'sdsdxd';
     die( print_r( sqlsrv_errors(), true));
}

$sql = "Delete from jabongScrapedCategoryUrls where retailerTermId=10";
$stmt = sqlsrv_query( $conn, $sql);   

$sql = "INSERT INTO [ShopSmart].[dbo].[jabongScrapedCategoryUrls] ([CategoryTermId],[Category],[CategoryParent],[RetailerTermId],[Retailer],[URLSerialNumber],[Full url],[URLPart1],[URLPart2],[ProductCount],[Brand],[FlipkartType]) select a.CategoryTermId,a.Category,a.CategoryParent,a.RetailerTermId,a.Retailer,a.URLSerialNumber,a.[Full url],a.URLPart1, b.offerPart2Link,3000,'None',b.type from snapdealscrapedCategoryUrls as a join snapdealscrapedoffers as b on a.retailer=b.retailer where b.numOfProd>0 and b.isValidOffer =1 and b.Retailer like '%snapdeal%'";

$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
echo 'ssvds';
     die( print_r( sqlsrv_errors(), true));
}
