<?php
//sleep(26000);
require_once('C:\xampp\htdocs\cpnVodo\SimulationWithoutAutomatn\createPredictorCompiledResultTable.php');
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql="WITH TempEmp (Name,type,duplicateRecCount)
AS
(
SELECT pageurl,flipkarttype,ROW_NUMBER() OVER(PARTITION by pageurl ORDER BY pageurl) 
AS duplicateRecCount
FROM dbo.scrapedproductsJabong 
)
delete FROM TempEmp where duplicateRecCount>1 and type is null
";



$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}


sqlsrv_close( $conn );

exec("php.exe createPredictorResultTableAmazon.php");
//exit;
echo 'createPredictorTargetTable:'.time();
//exec("php.exe savingPredictionAlgo.php");
echo 'savingPredictionAlgo: '.time();
exec("php.exe savingAlgoAmazon.php");

exec("php.exe newCreatePredictorCompiledResultTableAmazon.php");
echo 'createPredictorCompiledResulttable: '.time();

processFinalResult('predictorCompiledResultTableAmazon');



$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
echo 'nn'; 


$sqlToCheckNID = "update predictorCompiledResultTableAmazon set bestcouponstatus= 1 where Saving<>0 and bestcouponstatus is null";
//$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}

$sql="update predictorCompiledResultTableAmazon set LastCheckTime=? ";
$param=array(time());
$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sql="update predictorCompiledResultTableAmazon set bestcouponstatus=0 where bestcouponstatus is null";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")));
$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "exec('update coupon_finder.1Variables set Status = 1 where Serial=7') at MYSQL";
//$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}


$sqlToCheckNID = "update scrapingstatus set status = 0 where retailer=?";
$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}

$sql="Truncate table cachedcouponfinderresults";
$maxNidInDb = sqlsrv_query($conn,$sql);
echo time();
$sql = "insert into cachedCouponFinderResults select baseUrl,baseUrl,LastCheckTime,result,'{laveshCategorylavesh:'+CONVERT(varchar(50),Category)+',laveshRetailerNamelavesh:lavesh'+Retailer+'lavesh,laveshUselavesh:1,laveshProductDescriptionlavesh:laveshlavesh,laveshListingProductPricelavesh:lavesh'+CONVERT(varchar(50), listPrice)+'lavesh,laveshRetailerlavesh:'+CONVERT(varchar(50), RetailerId)+',laveshBaseUrllavesh:lavesh'+BaseUrl+'lavesh,laveshProductNamelavesh:lavesh'+ProductName+'lavesh,laveshProductImagelavesh:lavesh'+ProductImage+'lavesh,laveshProductBrandlavesh:lavesh'+brand+'lavesh,laveshMRPProductPricelavesh:lavesh'+CONVERT(varchar(50), MRP)+'lavesh,laveshPageTitlelavesh:laveshlavesh}',BestCouponCode,listPrice,Saving,BestCouponDesc,NetPrice from predictorcompiledresulttable";
$sql =  str_replace('lavesh','"',$sql);
$maxNidInDb = sqlsrv_query($conn,$sql);
echo time();
//sleep(11000);
//exec("php.exe final_snapdeal.php");
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}

