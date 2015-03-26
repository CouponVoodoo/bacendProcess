<?php
set_time_limit(0);
echo '2777';
$serverName = "localhost";
$connection = array( 
"Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$fullJSON='';
$sql 
="select distinct brand  from predictorresulttableSnapdeal[nolock] where retailer <> 'flipkart' ";
$response = sqlsrv_query($conn,$sql);
while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
$fullJSON = str_replace("][",",",$fullJSON);

}

$resultsArr = json_decode($fullJSON, true);
 foreach
($resultsArr as $datarow)
  {
main($datarow['brand']);
}
//main('myntra');
function main($brand){
$sid=$brand;
echo $sid;
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$maxNidInDb='';

    if( $conn ) { 
echo 'done' ;            
 

   }else{
           echo "Connection could not be established.";
     
      die( print_r( 

sqlsrv_errors(), true));
    }
$sqlToCheckNID ="update predictorresulttableSnapdeal SET 
coupongrouptype =  CASE
   When flipkartType like '%EOSS40%' and couponCode like '%FLAT500%'and category not in (42,62) THEN 1
   When flipkartType like '%EOSS40%' and couponCode like '%FLAT1000%' and category not in (42,62) THEN 1
When flipkartType like '%EOSS40%' and couponCode like '%FLAT1500%' and category not in (42,62) THEN 1
   When flipkartType like '%FIT15%' and couponCode like '%BRAND50%' and category not in (42,62) THEN 0
   When flipkartType like '%WATCH10%' and couponCode like '%WATCH10%' and category in (42,62) THEN 0
   When flipkartType like '%JEW40%' and couponCode like '%JEW40%' and category not in (42,62) THEN 1
   When flipkartType like '%JEW40%' and couponCode like '%JEW30%' THEN 1
   When flipkartType like '%EOSS21%' and couponCode like '%FASHION25%' THEN 1   
else 0
end
where brand =? ";
$param_nid = array($sid);
  //echo $sqlToCheckNID;
/* $maxNidInDb = 

sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
if( $maxNidInDb === false ) {echo 'Step1';
     die( 

print_r( sqlsrv_errors(), true));
}
*/

      $sqlToCheckNID ="update [predictorresulttableSnapdeal] set response = (Listingprice*cpnDiscount/100) 
where cpnDiscountType = 'percent' and coupongrouptype=1 and listingprice >=  minordercoupon  and brand =?";
  //echo $sqlToCheckNID;
  $param_nid = array($sid);
/*$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step1';
if( $maxNidInDb 

=== false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}
*/


      $sqlToCheckNID ="update [predictorresulttableSnapdeal] set response = cpnDiscount where cpnDiscountType = 'flat' and coupongrouptype=1 and listingprice>= minordercoupon  and brand =? ";

  //echo $sqlToCheckNID;
  

$param_nid = array($sid);
//$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);;
echo 'Step2';
if( $maxNidInDb === false ) {echo 'Step2';
     die( print_r( sqlsrv_errors(), true));
}

      

$sqlToCheckNID ="UPDATE dbo.predictorresulttableSnapdeal  
SET     response =  CASE
                   

     WHEN flipkartType='1' THEN response
                        WHEN limittype = 'discount' and mrp-listingprice>0 THEN 0  
                        WHEN limitOn = 'saving' and response>LimitAmount THEN LimitAmount
                        WHEN limitOn = 'listprice' and limitType='percent' and response*100 > LimitAmount*listingprice THEN LimitAmount*listingprice/100
                        
WHEN limitOn = 'mrp' and limitType='percent' and (mrp-listingprice+response)*100 > LimitAmount*mrp THEN (mrp*LimitAmount/100)-(mrp-listingprice)
                        ELSE response
                   
 END 
WHERE   listingprice >= minordercoupon and coupongrouptype=1 and limitOn in ('saving', 

'listprice', 

'mrp') and brand=?  ";

  //echo $sqlToCheckNID;
  $param_nid = array($sid);
/*$maxNidInDb 

= sqlsrv_query($conn,$sqlToCheckNID ,$param_nid);
echo 'Step3';
if( $maxNidInDb === false ) {echo 

'Step3';
     die( print_r( sqlsrv_errors(), true));
}*/


 $sqlToCheckNID ="UPDATE 

dbo.predictorresulttableSnapdeal  
SET     response =  CASE
                       
                    

    WHEN limittype = 'discount' and mrp-listingprice>0 THEN 0  
                        WHEN limitOn 

= 'saving' and response>LimitAmount THEN LimitAmount
                        WHEN limitOn = 

'listprice' and limitType='percent' and 

response*100 > LimitAmount*listingprice THEN 

LimitAmount*listingprice/100
                        WHEN limitOn = 'mrp' and limitType='percent' and 

(mrp-listingprice

+response)*100 > LimitAmount*mrp THEN (mrp*LimitAmount/100)-(mrp-listingprice)
      

                  ELSE response
                    END 
WHERE   listingprice >= minordercoupon and 

coupongrouptype=1 and limitOn in ('saving', 'listprice', 

'mrp') and brand=?  ";

  //echo 

$sqlToCheckNID;
/*  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID ,

$param_nid);
echo 'Step3';
if( $maxNidInDb === false ) {echo 'Step3';
     die( print_r( sqlsrv_errors

(), true));
}
*/


$sqlToCheckNID ="update predictorresulttableSnapdeal SET 
listingPrice =  CASE
   When flipkartType like '%MCLOTH40%' and couponCode like '%MCLOTH40%' THEN Mrp ELSE listingPrice
      END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);

      $sql ="UPDATE dbo.predictorresulttableSnapdeal
SET predictedcouponstatus =  CASE 
WHEN couponcode = 'BOGO' and flipkartType like '%BOGO%' THEN 2
WHEN couponcode = 'Deal' and flipkartType like '%Deal%' THEN 2
WHEN couponcode = 'Deal2' and flipkartType like '%Deal2%' THEN 2
WHEN couponcode = 'MCLOTH40' and flipkartType like '%MCLOTH40%' THEN 2
WHEN couponcode = 'MCEXTRA42' and flipkartType like '%MCEXTRA42%' THEN 2
WHEN couponcode = 'WC14MFOOT25' and flipkartType like '%WC14MFOOT25%' THEN 2
WHEN couponcode = 'BEST40' and flipkartType like '%snapdeal_offer_4%' THEN 2
WHEN couponcode = 'WC14ETHN35' and flipkartType like '%WC14ETHN35%' THEN 2
WHEN couponcode = 'WC14WWC35' and flipkartType like '%WC14WWC35%' THEN 2
WHEN couponcode = 'WC14EYE20' and flipkartType like '%WC14EYE20%' THEN 2
WHEN couponcode = 'WC14JEW50' and flipkartType like '%WC14JEW50%' THEN 2
WHEN couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN 2
WHEN couponcode = 'WCFootwear' and flipkartType like '%WCFootwear%' THEN 2
WHEN couponcode = 'WCMensClothing' and flipkartType like '%WCMensClothing%' THEN 2
WHEN couponcode = 'WCAcc' and flipkartType like '%WCAcc%' THEN 2
ELSE response           
      END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( print_r( sqlsrv_errors

(), true));
}

//WHEN category in (14,17) and coupongrouptype = 1 and couponcode = 'LAP1500' THEN .03*listingprice
$sql ="UPDATE dbo.predictorresulttableSnapdeal
SET response =  CASE
WHEN couponcode = 'Deal' and flipkartType like '%Deal%' THEN Mrp-listingprice
WHEN couponcode = 'MCEXTRA42' and flipkartType like '%MCEXTRA42%' THEN listingprice*0.42
WHEN couponcode = 'MCEXTRA42' and flipkartType like '%MCEXTRA42%' THEN listingprice*0.42
WHEN couponcode = 'ETHNIC40' and flipkartType like '%ETHNIC40%' THEN listingprice*0.40
WHEN couponcode = 'MCLOTH40' and flipkartType like '%MCLOTH40%' THEN listingPrice*0.50
WHEN  couponcode = 'BOGO' and flipkartType like '%BOGO%' THEN listingprice*0.5
WHEN  couponcode = 'WC14ETHN35' and flipkartType like '%WC14ETHN35%' THEN listingprice*0.35
WHEN  couponcode = 'WC14WWC35' and flipkartType like '%WC14WWC35%' THEN listingprice*0.35
WHEN  couponcode = 'WC14EYE20' and flipkartType like '%WC14EYE20%' THEN listingprice*0.2
WHEN  couponcode = 'WC14JEW50' and flipkartType like '%WC14JEW50%' THEN listingprice*0.5
WHEN  couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN listingprice*0.4
WHEN couponcode = 'WCFootwear' and flipkartType like '%WCFootwear%' THEN listingprice*0.4
WHEN couponcode = 'WCMensClothing' and flipkartType like '%WCMensClothing%' THEN listingprice*0.4
WHEN couponcode = 'WCAcc' and flipkartType like '%WCAcc%' THEN listingprice*0.4
ELSE response                 
   END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID ="update predictorresulttableSnapdeal SET 
listingPrice =  CASE
   
When flipkartType like '%Deal%' and couponCode like '%Deal%' THEN Mrp ELSE listingPrice

      END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);

  /*WHEN category in (14,17) and listingprice >= 10000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN .03*listingprice
WHEN category = 15 and listingprice >= 50000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN 3000
WHEN category = 15 and listingprice >= 20000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN 1500*/

    $sql ="UPDATE dbo.predictorresulttableSnapdeal
SET response =  CASE
WHEN listingprice >= 1999 and couponcode = 'ETHNIC40' and flipkartType like '%ETHNIC40%' THEN listingprice*0.40
WHEN listingprice >= 1 and couponcode = 'MCLOTH40' and flipkartType like '%MCLOTH40%' THEN listingPrice*0.50
WHEN listingprice >= 1 and couponcode = 'MCEXTRA42' and flipkartType like '%MCEXTRA42%' THEN listingprice*0.42
WHEN listingprice >= 1 and couponcode = 'BOGO' and flipkartType like '%BOGO%' THEN listingprice*0.5
WHEN listingprice >= 999 and couponcode = 'WCAcc' and flipkartType like '%WCAcc%' THEN listingprice*0.4

WHEN listingprice >= 999 and couponcode = 'WC14MC35' and flipkartType like '%WC14MC35%' THEN listingprice*0.35
WHEN listingprice >= 2499 and couponcode = 'WC14MFOOT25' and flipkartType like '%WC14MFOOT25%' THEN listingprice*0.4
WHEN listingprice >= 1499 and couponcode = 'WC14MFOOT25' and flipkartType like '%WC14MFOOT25%' THEN listingprice*0.25
WHEN listingprice >= 1999 and couponcode = 'BEST40' and flipkartType like '%snapdeal_offer_4%' THEN listingprice*0.4
WHEN listingprice >= 999 and couponcode = 'WC14ETHN35' and flipkartType like '%WC14ETHN35%' THEN listingprice*0.35
WHEN listingprice >= 999 and couponcode = 'WC14WWC35' and flipkartType like '%WC14WWC35%' THEN listingprice*0.35
WHEN listingprice >= 999 and couponcode = 'WC14EYE20' and flipkartType like '%WC14EYE20%' THEN listingprice*0.2
WHEN listingprice >= 999 and couponcode = 'WC14JEW50' and flipkartType like '%WC14JEW50%' THEN listingprice*0.5
WHEN listingprice >= 1299 and couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN listingprice*0.4
WHEN listingprice >= 999 and couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN listingprice*0.3
ELSE response
    
                END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,

$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( print_r( sqlsrv_errors

(), true));
}

/*
WHEN category in (14,17) and listingprice >= 10000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN 1
WHEN category = 15 and listingprice >= 50000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN 1
WHEN category = 15 and listingprice >= 20000 and coupongrouptype = 1 and couponcode = 'LAP1500' THEN 1*/


      $sql ="UPDATE dbo.predictorresulttableSnapdeal
SET predictedcouponstatus =  CASE
WHEN listingprice >= 1999 and couponcode = 'ETHNIC40' and flipkartType like '%ETHNIC40%' THEN 1
WHEN listingprice >= 1 and couponcode = 'MCLOTH40' and flipkartType like '%MCLOTH40%' THEN 1
WHEN listingprice >= 1 and couponcode = 'MCEXTRA42' and flipkartType like '%MCEXTRA42%' THEN 1
WHEN listingprice >= 1 and couponcode = 'BOGO' and flipkartType like '%BOGO%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WCAcc' and flipkartType like '%WCAcc%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14MC35' and flipkartType like '%WC14MC35%' THEN 1
WHEN listingprice >= 2499 and couponcode = 'WC14MFOOT25' and flipkartType like '%WC14MFOOT25%' THEN 1
WHEN listingprice >= 1499 and couponcode = 'WC14MFOOT25' and flipkartType like '%WC14MFOOT25%' THEN 1
WHEN listingprice >= 1999 and couponcode = 'BEST40' and flipkartType like '%snapdeal_offer_4%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14ETHN35' and flipkartType like '%WC14ETHN35%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14WWC35' and flipkartType like '%WC14WWC35%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14EYE20' and flipkartType like '%WC14EYE20%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14JEW50' and flipkartType like '%WC14JEW50%' THEN 1
WHEN listingprice >= 1299 and couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN 1
WHEN listingprice >= 999 and couponcode = 'WC14FACC30' and flipkartType like '%WC14FACC30%' THEN 1
ELSE response
                    END  where brand =?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 

'Step4';
     die( print_r( sqlsrv_errors(), true));
}


$sql="update predictorresulttableSnapdeal  set predictedCouponStatus=1 where response<>'' and brand=?" ;
$param_nid=array($sid);
//$maxNidInDb = 

//sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
     die( 

print_r( sqlsrv_errors(), true));
}

$sql="update predictorresulttableSnapdeal  set LastCheckTime=? where brand=? ";
date_default_timezone_set("Asia/Calcutta");
$param=array(strtotime(date("Y-m-d")),$sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = ";WITH CTE AS ( SELECT  *, MAX(response) OVER(PARTITION BY fullurl) MaxC2 FROM predictorresulttableSnapdeal where brand = ? )
UPDATE CTE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus = predictedcouponstatus
, bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//

$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step6';
if( $maxNidInDb === false ) {echo 'Step6';
     die( 
print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "update predictorresulttableSnapdeal set result = '{laveshBestCouponlavesh:'+CONVERT(varchar(10),BestCouponStatus)+',laveshSavinglavesh:lavesh'+CONVERT(varchar(200),Response)+'lavesh,laveshSuccessfullavesh:'+CONVERT(varchar(10),predictedCouponStatus)+',laveshcouponCodelavesh:lavesh'+couponCode+'lavesh,laveshdescriptionlavesh:lavesh'+couponCodeTitle+'lavesh,laveshdomainlavesh:lavesh'+retailer+'.comlavesh,laveshurllavesh:lavesh'+fullurl+'lavesh}' 
where brand=?";
$param=array($sid);
$sql =  str_replace('lavesh','"',$sqlToCheckNID);
//echo $sql;
$maxNidInDb = sqlsrv_query($conn,$sql,$param);
echo 'Step7';
if( $maxNidInDb === false ) {echo 

'Step7';
     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );
}