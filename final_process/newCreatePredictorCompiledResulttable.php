<?php
echo ' ya';
require_once('C:\xampp\htdocs\cpnVodo\SimulationWithoutAutomatn - Copy\fxnCreatePredictorCompiledResultTable.php');
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


createFlipkart($conn,'predictorresulttable');

sqlsrv_close( $conn );