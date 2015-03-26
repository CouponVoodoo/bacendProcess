<?php

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$table = $_GET["q"];
$maxNidInDb='';

$i=0;

$sqlToCheckNID = "select status from scrapingstatus where retailer=?";
$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param);
if( $maxNidInDb === false ) {echo 'Step77';
     die( print_r( sqlsrv_errors(), true));
}

$datarow = sqlsrv_fetch_array( $maxNidInDb , SQLSRV_FETCH_ASSOC);


$i=$datarow["status"];
//var_dump($i);
$i=1;
if ($i==0){ 
//echo 'na';
//exit;

$fullJSON='';

$sql ="truncate table predictorcompiledresulttableDataDmp";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);
//echo 'insertion started';

/*$sql ="IF  EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].

[predictorcompiledresulttableDataDmp]') AND name = N'base')
DROP INDEX [base] ON [dbo].[predictorcompiledresulttableDataDmp] WITH ( ONLINE = OFF )
";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);

if( $response  === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
sqlsrv_close( $conn );
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


$sql ="exec insertIntoPredictorcompiledresulttableDataDmp 10000";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);

if( $response  === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql ="CREATE UNIQUE CLUSTERED INDEX [base] ON [dbo].[predictorcompiledresulttableDataDmp] 
(
	[BaseUrl] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, 

DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]";
//$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql);

if( $response  === false ) {echo 'Step7';
//     die( print_r( sqlsrv_errors(), true));
}
*/
$sqlToCheckNID = "update ".$table." set id = 1 where listprice = 0 or listprice is null or brand is null or productImage is null or productName is null ";
$response = sqlsrv_query($conn,$sqlToCheckNID);

$sqlToCheckNID = "update scrapingstatus set status = 1 where retailer=?";
$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step10';
     die( print_r( sqlsrv_errors(), true));

}


}



$sqlToCheckNID = "SELECT top 1000 * from ".$table."[nolock] where id <> 1 ";

$response = sqlsrv_query($conn,$sqlToCheckNID);

if( $response === false ) {echo 'Step78';
     die( print_r( sqlsrv_errors(), true));
}

  $fullJSON='';
  #create one master array of the records */
$purl = "'h'";
while( $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {
       $purl = $purl. ",'".$datarow["BaseUrl"]."'";      
    $element = json_encode(array($datarow)); 
    $fullJSON = $fullJSON.$element;
     
}
//echo $purl;


sqlsrv_close( $conn );
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sqlToCheckNID ="update ".$table." set id = 1 where BaseUrl in (".$purl.")";
$sqlToCheckNID ="delete from ".$table." where BaseUrl in (".$purl.")";
 // echo $sqlToCheckNID;
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
if( $maxNidInDb === false ) {echo 'Step78';
     die( print_r( sqlsrv_errors(), true));
}

$result= str_replace("][",",",$fullJSON);
echo $result;

if ($result=='' || empty($result)){echo 'null';




sqlsrv_close( $conn ); exit;
}

sqlsrv_close( $conn );

