<?php
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql ="delete from scrapedproducts ";

 //$response = sqlsrv_query($conn,$sql);

$sql ="DBCC CHECKIDENT('scrapedproducts', RESEED, 0)";
//$response = sqlsrv_query($conn,$sql);
   
  
    if( $conn ) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }
        
  
$fullJSON="";
system('cmd /c C:\CronJobs\createScrapedProductsTable.bat'); 

/*
while (1<10){  
sleep(7);
$sql ="select * from cpnvoodooPreCachedScrapedUrls[nolock] where status = 0 ";

$response = sqlsrv_query($conn,$sql);
  #create one master array of the records 
$nidCheck=sqlsrv_fetch_array($response, SQLSRV_FETCH_ASSOC);   
echo "NID..nidcheck".var_dump($nidCheck) ;
if (empty($nidCheck)){
break;
}
else 
{
system('cmd /c C:\CronJobs\createScrapedProductsTable.bat'); 
}

}
*/