<?php

function processFinalResult($table){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);



$sqlToCheckNID = "UPDATE ".$table."
SET bestCoupondisplay = CASE WHEN saving <>0 THEN 'Guaranteed Coupons'
 else 'Without Coupons' END 
";


$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step11';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "
UPDATE ".$table." SET result = SUBSTRING(result, 0, LEN(result))+']'
UPDATE ".$table."
SET pagetitle = CASE WHEN bestcouponstatus = 0 THEN ProductName +' Coupons @ '+UPPER(LEFT(Retailer,1))
 ELSE 'Save INR '+ CONVERT(varchar(200),saving)+' via coupons on '+ ProductName +' @ '+UPPER(LEFT(Retailer,1)) END 
";


$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step9';
if( $maxNidInDb === false ) {echo 'Step8';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "UPDATE ".$table." 
SET retailerId = CASE WHEN retailer like '%jabong%' THEN 5
WHEN retailer like '%myntra%' THEN 8
WHEN retailer like '%flipkart%' THEN 13419
WHEN retailer like '%amazon%' THEN 14782
WHEN retailer like '%fabfurnish%' THEN 14792
WHEN retailer like '%zovi%' THEN 14785
WHEN retailer like '%zivame%' THEN 14786
WHEN retailer like '%snapdeal%' THEN 10
 ELSE null END
";


$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step10';
if( $maxNidInDb === false ) {echo 'Step9';
     die( print_r( sqlsrv_errors(), true));
}



$sqlToCheckNID = "Update ".$table." Set brand = replace(brand, '&amp;', '&') ";


$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step12';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "WITH TempEmp (Name,duplicateRecCount) AS (SELECT baseurl,ROW_NUMBER() OVER (PARTITION by baseurl ORDER BY baseurl) AS duplicateRecCount FROM dbo.".$table." )
delete FROM TempEmp WHERE duplicateRecCount>1 ";

$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step13';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}
echo 'Step14';


sqlsrv_close( $conn );
}