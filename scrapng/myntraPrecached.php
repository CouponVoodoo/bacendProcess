<?php
header("Access-Control-Allow-Origin: *");
$i = $argv[1];
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


function makeCache($url,$prodUrl,$Result)
{

$postdata = http_build_query(
    array(
        'url' => urlencode($url),
        'result' => urlencode($Result)
    )
);
echo $postdata;
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
echo $context;
$result = file_get_contents('http://54.243.150.171/cpnVodo/updateScrapedProductsWithResult.php', false, $context);
echo '--------->';
echo $result;
echo 'make Cacheeeeee';
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

function couponFinder($url,$prodUrl,$Brand){

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
$a = exec('C:\casperjs\batchbin\casperjs .\\'.$filename.'.js '.$url.' '.$Brand) ;


makeCache($url,$prodUrl,$a) ;
//echo $a;
} else
{

// echo $res["Result"];
}
 
}

$serverName = "AMAZONA-F421F23";
$connectionInfo = array( "Database"=>"ShopSmart", "UID"=>"lavesh", "PWD"=>"1234rewq" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }



$fullJSON="";  


$fullJSON = file_get_contents("http://54.243.150.171/cpnVodo/getMyntraPreCachingScrapedUrls.php?q=".$i);
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
couponFinder($url,$prodUrl,$brand);

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