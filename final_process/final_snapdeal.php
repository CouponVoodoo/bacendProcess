<?php



require_once('C:\xampp\htdocs\cpnVodo\SimulationWithoutAutomatn\createPredictorCompiledResultTable.php');

//sleep(4000);

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

 $sql="update scrapedproductsJabong set ListingPrice = MRPprice where ListingPrice ='' and retailerId=10";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsjabong set brand= left(product, charindex(' ', product)) where retailerid in (14782,14792,14786,10) ";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}




$sql="UPDATE scrapedproductsJabong SET Brand = b.brandTitle FROM scrapedproductsJabong a JOIN flipkartScrapedBrands b ON a.brand = b.scrapedBrand where a.retailerid in (13419,14782,10)";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql="UPDATE scrapedproductsJabong SET Brand = b.brandTitle FROM scrapedproductsJabong a JOIN fabfurnishScrapedBrands b ON a.brand = b.scrapedBrand where a.retailerid in (14792)";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql ="UPDATE dbo.scrapedproductsjabong
SET brand =  CASE
                        WHEN product like '%Vanca%' and retailerid in (14782,13419,10) THEN 'The Vanca'  
                         WHEN product like '%The Privilege%' and retailerid in (14782,13419,10) THEN 'The Privilege'  
         WHEN product like '%The Privilege%' and retailerid in (14782,13419,10) THEN 'The Privilege'  
         WHEN product like '%The Indian Garage%' and retailerid in (14782,13419,10) THEN 'The Indian Garage Co.'  
         WHEN product like '%The Elephant Company%' and retailerid in (14782,13419,10) THEN 'The Elephant Company'  
         WHEN product like '%United Colors Of Benetton%' and retailerid in (14782,13419,10) THEN 'United Colors Of Benetton'  
         WHEN product like '%John Players%' and retailerid in (14782,13419,10) THEN 'John Players'
         WHEN product like '%John Miller%' and retailerid in (14782,13419,10) THEN 'John Miller'
         WHEN product like '%Campus Sutra%' and retailerid in (14782,13419,10) THEN 'Campus Sutra'
WHEN product like '%Urban Nomad%' and retailerid in (14782,13419,10) THEN 'Urban Nomad'
WHEN product like '%Urban Vastra%' and retailerid in (14782,13419,10) THEN 'Urban Vastra'
WHEN product like '%Urban Yoga%' and retailerid in (14782,13419,10) THEN 'Urban Yoga'
WHEN product like '%Black Coffee%' and retailerid in (14782,13419,10) THEN 'Black Coffee'
WHEN product like '%Black Panther%' and retailerid in (14782,13419,10) THEN 'Black Panther'
WHEN product like '%American Swan%' and retailerid in (14782,13419,10) THEN 'American Swan'
WHEN product like '%American Tourister%' and retailerid in (14782,13419,10) THEN 'American Tourister'
WHEN product like '%Numero Uno%' and retailerid in (14782,13419,10) THEN 'Numero Uno'
WHEN product like '%Sports 52 Wear%' and retailerid in (14782,13419,10) THEN 'Sports 52 Wear'
WHEN product like '%Wear Your Mind%' and retailerid in (14782,13419,10) THEN 'Wear Your Mind'
WHEN product like '%Rain & Rainbow%' and retailerid in (14782,13419,10) THEN 'Rain & Rainbow'
WHEN product like '%Style Quotient By Noi%' and retailerid in (14782,13419,10) THEN 'Style Quotient By Noi'
WHEN product like '%Tokyo Talkies%' and retailerid in (14782,13419,10) THEN 'Tokyo Talkies'
WHEN product like '%Heart 2 Heart%' and retailerid in (14782,13419,10) THEN 'Heart 2 Heart'
WHEN product like '%Jealous 21%' and retailerid in (14782,13419,10) THEN 'Jealous 21'
WHEN product like '%Vero Moda%' and retailerid in (14782,13419,10) THEN 'Vero Moda'
WHEN product like '%Diva Fashion%' and retailerid in (14782,13419,10) THEN 'Diva Fashion'
WHEN product like '%Allen Solley%' and retailerid in (14782,13419,10) THEN 'Allen Solley'
WHEN product like '%Angry Birds%' and retailerid in (14782,13419,10) THEN 'Angry Birds'
WHEN product like '%No Code%' and retailerid in (14782,13419,10) THEN 'No Code'
WHEN product like '%Global Desi%' and retailerid in (14782,13419,10) THEN 'Global Desi'
WHEN product like '%Steve Madden%' and retailerid in (14782,13419,10) THEN 'Steve Madden'
WHEN product like '%Global Step%' and retailerid in (14782,13419,10) THEN 'Global Step'
WHEN product like '%Do Bhai%' and retailerid in (14782,13419,10) THEN 'Do Bhai'
WHEN product like '%Sole Struck%' and retailerid in (14782,13419,10) THEN 'Sole Struck'
WHEN product like '%Carlton London%' and retailerid in (14782,13419,10) THEN 'Carlton London'
WHEN product like '%F Sports%' and retailerid in (14782,13419,10) THEN 'F Sports'
WHEN product like '%Hush Puppies%' and retailerid in (14782,13419,10) THEN 'Hush Puppies'
WHEN product like '%Force 10%' and retailerid in (14782,13419,10) THEN 'Force 10'
WHEN product like '%Salt N Pepper%' and retailerid in (14782,13419,10) THEN 'Salt N Pepper'
WHEN product like '%Van Heusen%' and retailerid in (14782,13419,10) THEN 'Van Heusen'
WHEN product like '%Lee Cooper%' and retailerid in (14782,13419,10) THEN 'Lee Cooper'
WHEN product like '%Carpe Diem%' and retailerid in (14782,13419,10) THEN 'Carpe Diem'
WHEN product like '%Paris Hilton%' and retailerid in (14782,13419,10) THEN 'Paris Hilton'
WHEN product like '%Danish Design%' and retailerid in (14782,13419,10) THEN 'Danish Design'


 ELSE brand
                    END 
WHERE  retailerid in (14782,13419,10)
";
$response = sqlsrv_query($conn,$sql); 
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}



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

exec("php.exe createPredictorResultTableSnapdeal.php");
//exit;
echo 'createPredictorTargetTable:'.time();
//exec("php.exe savingPredictionAlgoSnapdeal.php");
echo 'savingPredictionAlgo: '.time();
exec("php.exe savingAlgoSnapdeal.php");
exec("php.exe newCreatePredictorCompiledResultTableSnapdeal.php");
echo 'createPredictorCompiledResulttable: '.time();


processFinalResult('predictorCompiledResultTableSnapdeal');

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
echo 'nn'; 

$sqlToCheckNID = "update predictorCompiledResultTable set bestcouponstatus= 1 where Saving<>0 and bestcouponstatus is null";
//$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}

$sql="update predictorCompiledResultTable set LastCheckTime=? ";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")));

$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}



$sqlToCheckNID = "exec('update coupon_finder.1Variables set Status = 1 where Serial=6') at MYSQL";
//$param=array('DataTransfer');	
$param=array('DataTransfer');
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param);
//echo 'step10';
if( $maxNidInDb === false ) {echo 'Step11 error';
     die( print_r( sqlsrv_errors(), true));

}


sqlsrv_close( $conn );




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


