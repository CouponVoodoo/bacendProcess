<?php
set_time_limit(0);


echo '2777';
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$fullJSON='';
$sql ="select distinct brand  from scrapedproductsJABONG[nolock] where retailerid in (14782,14792)";

$response = sqlsrv_query($conn,$sql);

while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
 $fullJSON = str_replace("][",",",$fullJSON);

}

$resultsArr = json_decode($fullJSON, true);

 foreach($resultsArr as $datarow)
  {
main($datarow['brand']);
}
//main('myntra');
function main($brand){$sid=$brand;
echo $sid;
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$maxNidInDb='';

    if( $conn ) { 
echo 'done' ;            
    }else{
           echo "Connection could not be established.";
     
      die( print_r( sqlsrv_errors(), true));
    }


      $sqlToCheckNID ="UPDATE dbo.predictorresulttableAmazon  
SET response =  CASE
                        WHEN flipkartType like '%Amazon_Offer_1%' and couponCode like '%Amazon_Offer_1%' THEN listingprice*0.37             
WHEN flipkartType like '%Amazon_Offer_2%'and couponCode like '%Amazon_Offer_2%' THEN listingprice*0.40            
WHEN flipkartType like '%Amazon_Offer_3%' and listingprice>=1995 and couponCode  like '%Amazon_Offer_3%' THEN listingprice*0.35             
WHEN flipkartType like '%Amazon_Offer_3%' and couponCode like '%Amazon_Offer_3%' and listingprice>=995 THEN listingprice*0.25 
          ELSE response
                    END 
WHERE  brand=? and retailer like '%amazon%'";
  //echo $sqlToCheckNID;
  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID ="UPDATE dbo.predictorresulttableAmazon  
SET response =  CASE
                        WHEN response>2000 and flipkartType like '%Amazon_Offer_6%' and couponCode like '%Amazon_Offer_6%' THEN 2000             
WHEN flipkartType like '%bUMMER20%'and couponCode like '%bUMMER20%' THEN listingprice*0.20            
WHEN flipkartType like '%bUMMER15%' and couponCode  like '%bUMMER15%' THEN listingprice*0.15              ELSE response
                    END 
WHERE  brand=? and retailer like '%fabfurnish%'";
  //echo $sqlToCheckNID;
  $param_nid = array($sid);
//$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}



$sql="update predictorresulttableAmazon  set predictedCouponStatus=1 where response<>'' and brand=? ";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( print_r( sqlsrv_errors(), true));
}

$sql="update predictorresulttableAmazon  set LastCheckTime=? where brand=? ";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")),$sid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = ";WITH CTE AS ( SELECT  *, MAX(response) OVER(PARTITION BY fullurl) MaxC2 FROM predictorresulttableAmazon where brand = ? )
UPDATE CTE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus = CASE WHEN MaxC2 = response and response <>0  THEN 1 ELSE 0 END
, bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step6';
if( $maxNidInDb === false ) {echo 'Step6';
     die( print_r( sqlsrv_errors(), true));
}


$sqlToCheckNID = "UPDATE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus = CASE WHEN MaxC2 = response and response <>0  THEN 1 ELSE 0 END
, bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$param_nid=array($sid);
//$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step6';
if( $maxNidInDb === false ) {echo 'Step6';
     die( print_r( sqlsrv_errors(), true));
}





$sqlToCheckNID = "update predictorresulttableAmazon set result = '{laveshBestCouponlavesh:'+CONVERT(varchar(10),BestCouponStatus)+',laveshSavinglavesh:lavesh'+CONVERT(varchar(200),Response)+'lavesh,laveshSuccessfullavesh:'+CONVERT(varchar(10),predictedCouponStatus)+',laveshcouponCodelavesh:lavesh'+couponCode+'lavesh,laveshdescriptionlavesh:lavesh'+couponCodeTitle+'lavesh,laveshdomainlavesh:lavesh'+retailer+'.comlavesh,laveshurllavesh:lavesh'+fullurl+'lavesh}' where brand=? ";
$param=array($sid);
$sql =  str_replace('lavesh','"',$sqlToCheckNID);
//echo $sql;
$maxNidInDb = sqlsrv_query($conn,$sql,$param);
echo 'Step7';
if( $maxNidInDb === false ) {echo 'Step7';
     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );
}