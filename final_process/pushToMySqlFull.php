
<?php

//echo $inputUrl.$prodUrlList.$timestamp;
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$maxNidInDb='';

$sqlToCheckNID = "exec ('Truncate table coupon_finder.predictorCompiledResultTableDmp') at mysql";
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step8';
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "exec ('insert into coupon_finder.predictorCompiledResultTableDmp select * from coupon_finder.predictorCompiledResultTable') at mysql";
echo 'Step9';
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "exec ('Truncate table coupon_finder.predictorCompiledResultTable') at mysql";
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'step10';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "insert into openquery(MYSQL, 'SELECT * from coupon_finder.predictorCompiledResultTable') SELECT * from predictorCompiledResultTable where pagetitle is not null and netprice is not null and listprice is not null and mrp is not null and listprice <> 0 and mrp <> 0 and productname is not null and productimage is not null ";
//$param_nid=array($brand);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step11';
if( $maxNidInDb === false ) {echo 'Step11';
     die( print_r( sqlsrv_errors(), true));
}
sqlsrv_close( $conn );