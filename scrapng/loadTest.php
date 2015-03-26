<?php
header("Access-Control-Allow-Origin: *");

function checkCache($prodUrl)
{
# Configure
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

#OpenConnections
if($conn) {
             
    }else{
          
           die( print_r( sqlsrv_errors(), true));
    }

$sqlToCheckNID ="Select Result from [cachedCouponFinderResults] where ProductUrl = (?)";
$param_nid = array($prodUrl);   
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
$nidCheck=sqlsrv_fetch_array($maxNidInDb, SQLSRV_FETCH_ASSOC); 

// Close the connection.
sqlsrv_close( $conn );
if (empty($nidCheck)){return null;}
else return $nidCheck;  

}

/*
function makeCache($url,$prodUrl,$Result)
{

# Configure
 date_default_timezone_set('Asia/Kolkata');

$timestamp =  date('U');   

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);


#OpenConnections
if( $conn ) {

    }else{

           die( print_r( sqlsrv_errors(), true));
    }

$sql = "INSERT INTO [cachedCouponFinderResults] 
(FullUrl,ProductUrl,Result,timestamp) VALUES (?,?,?,?)";
  $params = array($url,$prodUrl,$Result,$timestamp);

  $stmt = sqlsrv_query( $conn, $sql, $params);

// Close the connection.
sqlsrv_close( $conn );

}
*/


function makeCache($url,$prodUrl,$Result,$instanceId)
{

$postdata = http_build_query(
    array(
        'url' => urlencode($url),
        'result' => urlencode($Result),
        'instanceId' => $instanceId
    )
);
//echo $postdata;
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
//echo $context;
$result = file_get_contents('http://54.243.150.171/cpnVodo/updateScrapedProductsWithResult.php', false, $context);
//echo '--------->';
//echo $result;
//echo 'make Cacheeeeee';
//echo "http://54.243.150.171/cpnVodo/updateScrapedProductsWithResult.php?url=".urlencode($url)."&result=".urlencode($Result);
//$f = file_get_contents("http://54.243.150.171/cpnVodo/updateScrapedProductsWithResult.php?url=".urlencode($url)."&result=".urlencode($Result));
 //echo $f; 

# Configure

}


function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

function couponFinder($url,$prodUrl,$Brand, $i,$instanceId){

$filename = $Brand;
if ($Brand=='goodlife'){
$filename = 'firstcry';
}
if ($Brand=='watchkart' || $Brand=='bagskart' || $Brand=='jewelskart'){
$filename = 'lenskart';
}

//$res = checkCache($prodUrl);
$res = null;
if ($res == null){
if ($Brand=='myntra'){
$url = str_replace("&","ampersand",$url);
$a = exec('C:\casperjs\batchbin\casperjs .\\'.$filename.'.js '.$url.' '.$Brand.' '.$i) ;
}else {
if ($Brand=='flipkart'){$url = explode( '?', $url )[0];}
echo 'C:\casperjs\batchbin\casperjs .\\'.$filename.'.js '.$url.' '.$Brand;
$a = exec('C:\casperjs\batchbin\casperjs .\\'.$filename.'.js '.$url.' '.$Brand) ;
}



makeCache($url,$prodUrl,$a,$instanceId) ;
echo $a;
} else
{

// echo $res["Result"];
}
 
}




$fullJSON="";  
$data = file_get_contents("http://169.254.169.254/latest/user-data");
//$i=1;
$instanceId = file_get_contents('http://169.254.169.254/latest/meta-data/instance-id');
$fullJSON = file_get_contents("http://54.243.150.171/cpnVodo/getPreCachingScrapedUrls.php?q=".$data."&instanceId=".$instanceId);
$i = explode("_", $data)[0];
 echo $fullJSON; 
  # Make sure file is good
  if( $fullJSON === FALSE )
  {
    die('Could not open file.');
  }

$points = json_decode( $fullJSON , true );
foreach($points as $p) {
echo ($p["PageUrl"]); 
$url = $p["PageUrl"];
$brand = explode(".",get_domain($url))[0];

if(strpos($url,'?') > 1) {
$prodUrl = explode("?",$url)[0];}
else $prodUrl = $url;

//echo $brand;
couponFinder($url,$prodUrl,$brand,$i,$instanceId);


}
terminateInstance();
function terminateInstance() { 

$instanceId = file_get_contents('http://169.254.169.254/latest/meta-data/instance-id');

$result = file_get_contents('http://54.243.150.171/AWSSDKforPHP/TerminateAWSInstance.php?q='.$instanceId);


}


function execInBackground($cmd) { 
  try
  { echo '----------------------- '.$cmd;
  if (substr(php_uname(), 0, 7) == "Windows"){ 
  //exec($cmd ); 
$handle = popen("start /B ". $cmd, "r");
echo $handle;  
if ($handle === FALSE) {
echo 'Problemm';
   die("Unable to execute $cmd");
}
pclose($handle);        

    } 
    else { 
        exec($cmd . " > /dev/null &");   
    }
   }catch(Exception $e)
  {
  echo 'Message: ' .$e->getMessage();
  } 
} 



//echo 
?>