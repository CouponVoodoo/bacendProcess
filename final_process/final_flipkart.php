php.exe f<?php
require_once('C:\xampp\htdocs\cpnVodo\MailUtility\mailchimp\mailchimp-mandrill-api-php-54bc21271868\src\Mandrill.php');
require_once('C:\xampp\htdocs\cpnVodo\SimulationWithoutAutomatn\createPredictorCompiledResultTable.php');
//sleep(7200);
//sleep(4200);
while (1 < 10) {


echo 10;
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
delete FROM TempEmp where duplicateRecCount>1 and type ='1'";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}

echo 'next';
#OpenConnections
if( $conn ) {

    }else{

         //  die( print_r( sqlsrv_errors(), true));
    }
$sql = "Select sum(status) as num from scrapingstatus where retailer in ('jabong','myntra')";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
    // die( print_r( sqlsrv_errors(), true));
}

$datarow = sqlsrv_fetch_array( $maxNidInDb , SQLSRV_FETCH_ASSOC);

sqlsrv_close( $conn );
$i=$datarow["num"];
var_dump($i);
$i=2;
if ($i>=2){ 

//exit;
echo 'Start: '.time();
//exec("php.exe final_flipkart.php");
echo '--------------';

echo time();
exec("php.exe createPredictorTargetTableFlipkart.php");
//echo 'createPredictorTargetTable:'.time();
//exec("php.exe savingPredictionAlgo.php");
//echo 'savingPredictionAlgo: '.time();
exec("php.exe savingAlsoFlipkart.php");
echo 'createPredictorCompiledResulttable: '.time();

exec("php.exe newCreatePredictorCompiledResultTableFlipkart.php");

echo 'newCreatePredictorCompiledResultTableFlipkart: '.time();

processFinalResult('predictorCompiledResultTableFlipkart');

echo 'done final processing';

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
echo 'nn'; 

$sqlToCheckNID = "update predictorCompiledResultTableFlipkart set bestcouponstatus= 1 where Saving<>0 and bestcouponstatus is null";
//$param=array('DataTransfer');
//$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
//echo 'step10';

$sql="update predictorCompiledResultTableFlipkart set LastCheckTime=? ";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")));

$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}
echo 'updated last check time';
$sql="update predictorCompiledResultTableFlipkart set bestcouponstatus=0 where bestcouponstatus is null";
$param=array(time());
//$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "exec('update coupon_finder.1Variables set Status = 1 where Serial=5') at MYSQL";
//$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}

echo 'variable set';
$sqlToCheckNID = "update scrapingstatus set status = 0 where retailer=?";
$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}
//sleep(9000);
//exec("php.exe final_snapdeal.php");
sqlsrv_close( $conn );

exit;

}
//sleep(600);
}


function senMail($finalMessage,$subject){
try {
    $mandrill = new Mandrill('8ukHqK8oNOPoMHmsdxLd8A');
    $message = array(
        'html' => $finalMessage,
        'text' => 'Test',
        'subject' => $subject,
        'from_email' => 'team@theshoppingpro.com',
        'from_name' => 'TheShoppingProTeam',
        'to' => array(
            array(
                'email' => 'lavesh@theshoppingpro.com',
                'name' => 'Lavesh',
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'team@theshoppingpro.com'),
        'important' => false,
        'track_opens' => null,
        'track_clicks' => null,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => 'ashish@theshoppingpro.com',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'global_merge_vars' => null,
        'merge_vars' => null
        
    );
    $async = false;
    $ip_pool = 'Main Pool';
  //$send_at = '2013-11-12 12:00:00';
    $result = $mandrill->messages->send($message, $async, $ip_pool);
    print_r($result);
    /*
    Array
    (
        [0] => Array
            (
                [email] => recipient.email@example.com
                [status] => sent
                [reject_reason] => hard-bounce
                [_id] => abc123abc123abc123abc123abc123
            )
    
    )
    */
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}
}

