<?php
# Configure

$serverName = "localhost";
$connection = array( "Database"=>"Scraping");
$conn = sqlsrv_connect( $serverName, $connection);

#OpenConnections
if( $conn ) {

    }else{

//           die( print_r( sqlsrv_errors(), true));
    }

$sqlToCheckNID ="Delete from [predictorCouponDescRepository] where retailer like '%flipkart%'";
$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {
     die( print_r( sqlsrv_errors(), true));
}
$sqlToCheckNID ="INSERT INTO [ShopSmart].[dbo].[predictorCouponDescRepository]([couponCode],[Retailer],[CouponIdentifier],[couponCodeDescription],[Total],[CouponStatus],[MinOrder],[DiscountType],[Discount],[LimitType],[LimitAmount],[LimitOn]) 
select 'Flipkart Offer '+Convert(varchar(100),type),'flipkart','',OfferDescription,0,TYPE,0,'','','','','' from flipkartscrapedoffers where isvalidoffer = 1";
$response1 = sqlsrv_query($conn,$sqlToCheckNID);
if( $response1 === false ) {echo 'sss';
     die( print_r( sqlsrv_errors(), true));
}

