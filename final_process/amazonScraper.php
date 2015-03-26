<?php

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if( $conn ) { 
//echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }


$sql= "update  amazonScrapedCategoryUrls[nolock] set servercount = 1"
$response = sqlsrv_query($conn,$sql);
sqlsrv_close( $conn );
while (1 < 10) {

echo 1;
sleep(4);
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if( $conn ) { 
//echo 'done' ;            
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

$sql= "Select count(*) as num  from amazonScrapedCategoryUrls[nolock] where servercount = 1"
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

 $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC);

if ($datarow["num"]==0){echo 'no urls to process';sqlsrv_close( $conn ); 
$sql= "update scrapedproductsJabong set flipkartType=b.flipkartType 
     from scrapedproductsJabong a inner join (select * from scrapedproductsJabong 
     where flipkartType is not null and retailerId=14782) b on a.pageurl=b.pageurl where a.retailerId=14782 and flipkartType is null";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql= "delete from scrapedproductsJabong where Category=0";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

exit;
} 
sqlsrv_close( $conn );


echo 10;
system('cmd /c C:\xampp\htdocs\cpnVodo\amazonApi\amazonScraper.bat'); 
}
?>