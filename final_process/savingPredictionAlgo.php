<?php
set_time_limit(0);


echo '2777';
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$fullJSON='';
$sql= "update [predictorresulttable] set SIDlevelCouponWorkStatus = 1 where flipkartType not like '%1%' or flipkartType is null";
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}

$sql="update [predictorresulttable] set predictedcouponstatus=2 where SIDlevelCouponWorkStatus = 1";
$maxNidInDb = sqlsrv_query($conn,$sql);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}
//exit;
$sql ="select distinct brand  from predictorResultTable[nolock] where retailer <> 'flipkart' ";

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
//main('span');
//exit;
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
$sqlToCheckNID ="update predictorresulttable set coupongrouptype=2 where brand like '%Jockey%' and couponCode <> 'zivcbr12' and retailer like '%zivame%'";

  //echo $sqlToCheckNID;
 $maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);


$sqlToCheckNID ="update [predictorresulttable] set response = (Listingprice*cpnDiscount/100) where cpnDiscountType = 'percent' and coupongrouptype=1 and brand =? and retailer <> 'flipkart' and SIDlevelCouponWorkStatus = 1";
  //echo $sqlToCheckNID;
$param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}



 $sqlToCheckNID ="update [predictorresulttable] set response = cpnDiscount where cpnDiscountType = 'flat' and coupongrouptype=1 and brand =? and retailer <> 'flipkart'  and SIDlevelCouponWorkStatus = 1";

  //echo $sqlToCheckNID;
  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);;
echo 'Step2';
if( $maxNidInDb === false ) {echo 'Step2';
     die( print_r( sqlsrv_errors(), true));
}

 $sqlToCheckNID ="update [predictorresulttable] set response = (cpnDiscount/minordercoupon)*listingprice where cpnDiscountType = 'flat' and listingprice < minordercoupon and coupongrouptype=1 and brand =? and retailer <> 'flipkart'  and SIDlevelCouponWorkStatus = 1";

  //echo $sqlToCheckNID;
  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);;
echo 'Step2';
if( $maxNidInDb === false ) {echo 'Step2';
     die( print_r( sqlsrv_errors(), true));
}

      $sqlToCheckNID ="UPDATE dbo.predictorresulttable  
SET     response =  CASE
                        WHEN flipkartType='1' THEN response


                        WHEN limittype = 'discount' and mrp-listingprice>0 THEN 0  
                        WHEN limitOn = 'saving' and response>LimitAmount THEN LimitAmount
                        WHEN limitOn = 'listprice' and limitType='percent' and 

response*100 > LimitAmount*listingprice THEN LimitAmount*listingprice/100
                        WHEN limitOn = 'mrp' and limitType='percent' and (mrp-listingprice

+response)*100 > LimitAmount*mrp THEN (mrp*LimitAmount/100)-(mrp-listingprice)
                        ELSE response
                    END 
WHERE   listingprice >= minordercoupon and coupongrouptype=1 and limitOn in ('saving', 'listprice', 'mrp') and brand=?  and SIDlevelCouponWorkStatus = 1";

  //echo $sqlToCheckNID;
  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID ,$param_nid);
echo 'Step3';
if( $maxNidInDb === false ) {echo 'Step3';
echo $datarow['brand'];
     die( print_r( sqlsrv_errors(), true));
}



$sql="update predictorresulttable  set predictedCouponStatus=1 where response<>'' and brand=? and retailer <> 'flipkart' and listingprice >= minordercoupon";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( print_r( sqlsrv_errors(), true));
}


// Added for minimum threshhold criteria

  
$sql="update predictorresulttable  set LastCheckTime=? where brand=? and retailer <> 'flipkart'";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")),$sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = ";WITH CTE AS ( SELECT  *, MAX(response) OVER(PARTITION BY fullurl) MaxC2 FROM predictorresulttable where brand = ? and retailer <> 'flipkart')
UPDATE CTE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus=predictedCouponStatus
 ,bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step6';
if( $maxNidInDb === false ) {echo 'Step6';
     die( print_r( sqlsrv_errors(), true));
}







$sqlToCheckNID = "update predictorresulttable set result = '{laveshBestCouponlavesh:'+CONVERT(varchar(10),BestCouponStatus)+',laveshSavinglavesh:lavesh'+CONVERT(varchar(200),Response)+'lavesh,laveshSuccessfullavesh:'+CONVERT(varchar(10),predictedCouponStatus)+',laveshcouponCodelavesh:lavesh'+couponCode+'lavesh,laveshdescriptionlavesh:lavesh'+couponCodeTitle+'lavesh,laveshdomainlavesh:lavesh'+retailer+'.comlavesh,laveshurllavesh:lavesh'+fullurl+'lavesh}' where brand=? and retailer <> 'flipkart'";
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