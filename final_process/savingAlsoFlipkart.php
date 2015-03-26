<?php
set_time_limit(0);


echo '2777';
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);
$fullJSON='';

$sql ="select distinct brand  from predictorResultTableFlipkart[nolock]";

$response = sqlsrv_query($conn,$sql);

while( $datarows = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {

 $element = json_encode(array($datarows));
 $fullJSON = $fullJSON.$element;
$fullJSON = str_replace("][",",",$fullJSON);

}

$resultsArr = json_decode($fullJSON, true);

$offers='(1689,533,528,529,530)';


//  $param_nid = array($sid);
//$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}

 $maxNidInDb='';
$coupons='(345,485,350,354,355,357,362,465,480,430,1612,661,495,494,493,490,532,531,527,547,548,549,554,624,687,726,736,737,738,1228,1229,1251,1252,1224,1225,1227,1219,1220,1222,1085,1739,1725,1708,1604)';
$sqlToCheckNID="UPDATE dbo.predictorresulttableFlipkart  
set predictedCouponStatus=4 where flipkartType =couponGroupType and flipkartType not in ".$coupons." and couponGroupType <> 1";
//  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);

if( $maxNidInDb === false ) {echo 'Step1';
$sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart set predictedCouponStatus=4 where flipkartType like '%'+cast(couponGroupType as varchar(250))+'%' and  couponGroupType not in ".$coupons." and couponGroupType <> 1";
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo $sqlToCheckNID;
if( $maxNidInDb === false ) {echo 'Step1';

     die( print_r( sqlsrv_errors(), true));
}}

$sqlToCheckNID="UPDATE dbo.predictorresulttableFlipkart  
set response=mrp-listingprice  where flipkartType =couponGroupType and flipkartType not in ".$coupons. " and listingprice <> mrp and couponGroupType <> 1";

  //echo $sqlToCheckNID;
 // $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step1';

if( $maxNidInDb === false ) {echo 'Step1';
$sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart  
set response=mrp-listingprice where flipkartType like '%'+cast(couponGroupType as varchar(250))+'%' and  couponGroupType not in ".$coupons." and listingprice <> mrp and couponGroupType <> 1";

  //echo $sqlToCheckNID;
  //$param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}
echo $sqlToCheckNID;
}
$sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart  
set listingprice=mrp where flipkartType like '%'+cast(couponGroupType as varchar(250))+'%' and  couponGroupType not in ".$coupons."and listingprice <> mrp and couponGroupType <> 1";

  //echo $sqlToCheckNID;
  //$param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}


/*
$sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart  set predictedCouponStatus=2 where 

couponGroupType=flipkartType and flipkartType in ".$coupons;

//  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
$sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart  
set predictedCouponStatus=2 where flipkartType like '%'+cast(couponGroupType as varchar(250))+'%' and  couponGroupType in ".$coupons;
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID);
echo $sqlToCheckNID;
if( $maxNidInDb === false ) {echo 'Step1';

    // die( print_r( sqlsrv_errors(), true));
}
//     die( print_r( sqlsrv_errors(), true));
}
*/

 foreach($resultsArr as $datarow)
  {
  
main($datarow['brand'],$coupons);
}
//main('myntra');
function main($brand,$coupons){
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
     
      die( print_r( sqlsrv_errors(), true));
    }



      $sqlToCheckNID ="UPDATE dbo.predictorresulttableFlipkart  

	  SET response =  CASE
	  WHEN  coupongrouptype = 1604 and flipkartType like '%1604%' THEN listingprice*0.3
	  	  
	  WHEN  coupongrouptype = 1708 and flipkartType like '%1708%' THEN listingprice*0.35
WHEN  coupongrouptype = 1725 and flipkartType like '%1725%' THEN listingprice*0.3	  
WHEN  coupongrouptype = 1739 and flipkartType like '%1739%' THEN listingprice*0.25
WHEN  coupongrouptype = 1219 and flipkartType like '%1219%' THEN listingprice*0.30
WHEN  coupongrouptype = 1085 and flipkartType like '%1085%' THEN listingprice*0.20
WHEN  coupongrouptype = 1220 and flipkartType like '%1220%' THEN listingprice*0.30
WHEN  coupongrouptype = 1222 and flipkartType like '%1222%' THEN listingprice*0.30
WHEN  coupongrouptype = 1225 and flipkartType like '%1225%' THEN listingprice*0.30
WHEN  coupongrouptype = 1224 and flipkartType like '%1224%' THEN listingprice*0.30
WHEN  coupongrouptype = 1227 and flipkartType like '%1227%' THEN listingprice*0.30
WHEN  coupongrouptype = 1229 and flipkartType like '%1229%' THEN listingprice*0.30
WHEN  coupongrouptype = 1251 and flipkartType like '%1251%' THEN listingprice*0.30
WHEN  coupongrouptype = 1252 and flipkartType like '%1252%' THEN listingprice*0.30
WHEN  coupongrouptype = 736 and flipkartType like '%736%' THEN listingprice*0.30
WHEN  coupongrouptype = 737 and flipkartType like '%737%' THEN listingprice*0.30	  
WHEN  coupongrouptype = 738 and flipkartType like '%738%' THEN listingprice*0.30	  
WHEN  coupongrouptype = 687 and flipkartType like '%687%' THEN listingprice*0.32	  
WHEN  coupongrouptype = 661 and flipkartType like '%661%' THEN listingprice*0.32
WHEN  coupongrouptype = 624 and flipkartType like '%624%' THEN listingprice*0.30	  
WHEN  coupongrouptype = 554 and flipkartType like '%554%' THEN listingprice*0.30	  
WHEN  coupongrouptype = 549 and flipkartType like '%549%' THEN listingprice*0.32
WHEN  coupongrouptype = 548 and flipkartType like '%548%' THEN listingprice*0.32
WHEN  coupongrouptype = 547 and flipkartType like '%547%' THEN listingprice*0.32
WHEN  coupongrouptype = 527 and flipkartType like '%527%' THEN listingprice*0.2
WHEN  coupongrouptype = 531 and flipkartType like '%531%' THEN listingprice*0.2
WHEN  coupongrouptype = 532 and flipkartType like '%532%' THEN listingprice*0.25
WHEN  coupongrouptype = 490 and flipkartType like '%490%' THEN listingprice*0.3
WHEN  coupongrouptype = 494 and flipkartType like '%494%' THEN listingprice*0.15
WHEN  coupongrouptype = 493 and flipkartType like '%493%' THEN listingprice*0.32
WHEN  coupongrouptype = 495 and flipkartType like '%495%' THEN listingprice*0.15
WHEN  coupongrouptype = 1612 and flipkartType like '%1612%' THEN listingprice*0.15
WHEN  coupongrouptype = 430 and flipkartType like '%430%' THEN listingprice*0.15
WHEN  coupongrouptype = 480 and flipkartType like '%480%' THEN listingprice*0.2
WHEN  coupongrouptype = 465 and flipkartType like '%465%' THEN listingprice*0.15
WHEN  coupongrouptype = 345 and flipkartType like '%345%' THEN listingprice*0.2
WHEN  coupongrouptype = 485 and flipkartType like '%485%' THEN listingprice*0.15
WHEN  coupongrouptype = 350 and flipkartType like '%350%' THEN listingprice*0.30
WHEN  coupongrouptype = 354 and flipkartType like '%354%' THEN listingprice*0.25
WHEN  coupongrouptype = 355 and flipkartType like '%355%' THEN listingprice*0.20
WHEN coupongrouptype = 357 and flipkartType like '%357%' THEN listingprice*0.20
ELSE response

                    END 
WHERE  brand=? ";

  //echo $sqlToCheckNID;
  $param_nid = array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step1';
if( $maxNidInDb === false ) {echo 'Step1';
     die( print_r( sqlsrv_errors(), true));
}

$sql= "update dbo.predictorresulttableflipkart 
set response= CASE
WHEN  listingprice >= 1999 and coupongrouptype = 1604 and flipkartType like '%1604%' THEN listingprice*0.30
WHEN  listingprice >= 1299 and coupongrouptype = 1604 and flipkartType like '%1604%' THEN listingprice*0.20

WHEN  listingprice >= 1499 and coupongrouptype = 1725 and flipkartType like '%1725%' THEN listingprice*0.30
WHEN  listingprice >= 799 and coupongrouptype = 1725 and flipkartType like '%1725%' THEN listingprice*0.20
WHEN  listingprice >= 2499 and coupongrouptype = 1739 and flipkartType like '%1739%' THEN listingprice*0.25
WHEN  listingprice >= 1499 and coupongrouptype = 1739 and flipkartType like '%1739%' THEN listingprice*0.15
WHEN  listingprice >= 1999 and coupongrouptype = 1227 and flipkartType like '%1227%' THEN .3
WHEN  listingprice >= 1099 and coupongrouptype = 1227 and flipkartType like '%1227%' THEN .2
WHEN  listingprice >= 1999 and coupongrouptype = 1222 and flipkartType like '%1222%' THEN .3
WHEN  listingprice >= 1299 and coupongrouptype = 1222 and flipkartType like '%1222%' THEN .2
WHEN  listingprice >= 1499 and coupongrouptype = 1219 and flipkartType like '%1219%' THEN .3
WHEN  listingprice >= 1299 and coupongrouptype = 736 and flipkartType like '%736%' THEN .3
WHEN  listingprice >= 1499 and coupongrouptype = 737 and flipkartType like '%737%' THEN listingprice*0.30
WHEN  listingprice >= 999 and coupongrouptype = 737 and flipkartType like '%737%' THEN listingprice*0.15
WHEN  listingprice >= 1499 and coupongrouptype = 738 and flipkartType like '%738%' THEN listingprice*0.30
WHEN  listingprice >= 799 and coupongrouptype = 738 and flipkartType like '%738%' THEN listingprice*0.20
WHEN  listingprice >= 1999 and coupongrouptype = 687 and flipkartType like '%687%' THEN listingprice*0.30
WHEN  listingprice >= 1499 and coupongrouptype = 687 and flipkartType like '%687%' THEN listingprice*0.20
WHEN  listingprice >= 1299 and coupongrouptype = 661 and flipkartType like '%661%' THEN listingprice*0.32
WHEN  listingprice >= 1999 and coupongrouptype = 624 and flipkartType like '%624%' THEN listingprice*0.30
WHEN  listingprice >= 1299 and coupongrouptype = 624 and flipkartType like '%624%' THEN listingprice*0.15
WHEN  listingprice >= 1599 and coupongrouptype = 549 and flipkartType like '%549%' THEN listingprice*0.30
WHEN  listingprice >= 999 and coupongrouptype = 549 and flipkartType like '%549%' THEN listingprice*0.20
WHEN  listingprice >= 1999 and coupongrouptype = 554 and flipkartType like '%554%' THEN listingprice*0.32
WHEN  listingprice >= 1299 and coupongrouptype = 554 and flipkartType like '%554%' THEN listingprice*0.20
WHEN  listingprice >= 1999 and coupongrouptype = 548 and flipkartType like '%548%' THEN listingprice*0.30
WHEN  listingprice >= 1499 and coupongrouptype = 548 and flipkartType like '%548%' THEN listingprice*0.20
WHEN  listingprice >= 1299 and coupongrouptype = 547 and flipkartType like '%547%' THEN listingprice*0.32
WHEN  listingprice >= 2199 and coupongrouptype = 531 and flipkartType like '%531%' THEN listingprice*0.25
WHEN  listingprice >= 1299 and coupongrouptype = 531 and flipkartType like '%531%' THEN listingprice*0.15
WHEN  listingprice >= 2499 and coupongrouptype = 527 and flipkartType like '%527%' THEN listingprice*0.25
WHEN  listingprice >= 1499 and coupongrouptype = 527 and flipkartType like '%527%' THEN listingprice*0.15
WHEN  listingprice >= 1999 and coupongrouptype = 532 and flipkartType like '%532%' THEN listingprice*0.2
WHEN  listingprice >= 1499 and coupongrouptype = 532 and flipkartType like '%532%' THEN listingprice*0.15
WHEN  listingprice >= 1799 and coupongrouptype = 490 and flipkartType like '%490%' THEN listingprice*0.32
WHEN  listingprice >= 999 and coupongrouptype = 490 and flipkartType like '%490%' THEN listingprice*0.15
WHEN  listingprice >= 1599 and coupongrouptype = 495 and flipkartType like '%495%' THEN listingprice*0.3
WHEN  listingprice >= 1099 and coupongrouptype = 495 and flipkartType like '%495%' THEN listingprice*0.15
WHEN  listingprice >= 599 and coupongrouptype = 495 and flipkartType like '%495%' THEN listingprice*0.15
WHEN  listingprice >= 899 and coupongrouptype = 495 and flipkartType like '%495%' THEN listingprice*0.2
WHEN  listingprice >= 1999 and coupongrouptype = 1612 and flipkartType like '%1612%' THEN listingprice*0.15
WHEN  listingprice >= 1299 and coupongrouptype = 1612 and flipkartType like '%1612%' THEN listingprice*0.2
WHEN listingprice >= 2499 and coupongrouptype = 430 and flipkartType like '%430%' THEN listingprice*0.25
WHEN listingprice >= 1499 and coupongrouptype = 430 and flipkartType like '%430%' THEN listingprice*0.15
WHEN listingprice >= 1499 and coupongrouptype = 480 and flipkartType like '%480%' THEN listingprice*0.25
WHEN listingprice >= 999 and coupongrouptype = 480 and flipkartType like '%480%' THEN listingprice*0.20
WHEN listingprice >= 1599 and coupongrouptype = 465 and flipkartType like '%465%' THEN listingprice*0.25
WHEN listingprice >= 1099 and coupongrouptype = 465 and flipkartType like '%465%' THEN listingprice*0.15
WHEN listingprice >= 1599 and coupongrouptype = 345 and flipkartType like '%345%' THEN listingprice*0.25
WHEN listingprice >= 1799 and coupongrouptype = 485 and flipkartType like '%485%' THEN listingprice*0.25
WHEN listingprice >= 999 and coupongrouptype = 485 and flipkartType like '%485%' THEN listingprice*0.15
WHEN listingprice >= 2599 and coupongrouptype = 350 and flipkartType like '%350%' THEN listingprice*0.3
WHEN listingprice >= 1999 and coupongrouptype = 354 and flipkartType like '%354%' THEN listingprice*0.25
WHEN listingprice >= 1799 and coupongrouptype = 355 and flipkartType like '%355%' THEN listingprice*0.3
WHEN listingprice >= 999 and coupongrouptype = 355 and flipkartType like '%355%' THEN listingprice*0.2
WHEN listingprice >= 2499 and coupongrouptype = 357 and flipkartType like '%357%' THEN listingprice*0.2
else response
END where brand = ?";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);

$sql="update predictorresulttableFlipkart  set predictedCouponStatus=2 where response<>'' and brand=? ";
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
echo 'Step4';
if( $maxNidInDb === false ) {echo 'Step4';
    die( print_r( sqlsrv_errors(), true));
}

$sql= "update dbo.predictorresulttableflipkart 
set predictedCouponStatus= CASE
WHEN  listingprice >= 1999 and coupongrouptype = 1604 and flipkartType like '%1604%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 1604 and flipkartType like '%1604%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 1725 and flipkartType like '%1725%' THEN 1
WHEN  listingprice >= 799 and coupongrouptype = 1725 and flipkartType like '%1725%' THEN 1
WHEN  listingprice >= 2499 and coupongrouptype = 1739 and flipkartType like '%1739%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 1739 and flipkartType like '%1739%' THEN 1

WHEN  listingprice >= 1299 and coupongrouptype = 736 and flipkartType like '%736%' THEN 1
WHEN  listingprice >= 799 and coupongrouptype = 738 and flipkartType like '%738%' THEN 1
WHEN  listingprice >= 999 and coupongrouptype = 737 and flipkartType like '%737%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 687 and flipkartType like '%687%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 661 and flipkartType like '%661%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 624 and flipkartType like '%624%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 554 and flipkartType like '%554%' THEN 1
WHEN  listingprice >= 999 and coupongrouptype = 549 and flipkartType like '%549%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 548 and flipkartType like '%548%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 547 and flipkartType like '%547%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 527 and flipkartType like '%527%' THEN 1
WHEN  listingprice >= 1499 and coupongrouptype = 532 and flipkartType like '%532%' THEN 1
WHEN  listingprice >= 999 and coupongrouptype = 490 and flipkartType like '%490%' THEN 1
WHEN  coupongrouptype = 491 and flipkartType like '%491%' THEN 1
WHEN  listingprice >= 1099 and coupongrouptype = 494 and flipkartType like '%494%' THEN 1
WHEN  listingprice >= 599 and coupongrouptype = 495 and flipkartType like '%495%' THEN 1
WHEN  listingprice >= 1299 and coupongrouptype = 1612 and flipkartType like '%1612%' THEN 1
WHEN listingprice >= 1499 and coupongrouptype = 430 and flipkartType like '%430%' THEN 1
WHEN listingprice >= 999 and coupongrouptype = 480 and flipkartType like '%480%' THEN 1
WHEN listingprice >= 1099 and coupongrouptype = 465 and flipkartType like '%465%' THEN 1
WHEN listingprice >= 1599 and coupongrouptype = 345 and flipkartType like '%345%' THEN 1
WHEN listingprice >= 999 and coupongrouptype = 485 and flipkartType like '%485%' THEN 1
WHEN listingprice >= 2599 and coupongrouptype = 350 and flipkartType like '%350%' THEN 1
WHEN listingprice >= 1999 and coupongrouptype = 354 and flipkartType like '%354%' THEN 1
WHEN listingprice >= 999 and coupongrouptype = 355 and flipkartType like '%355%' THEN 1
WHEN listingprice >= 2499 and coupongrouptype = 357 and flipkartType like '%357%' THEN 1
else predictedcouponstatus
END
 where brand = ?";
$param_nid=array($sid);

$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);

$sql="UPDATE dbo.predictorresulttableFlipkart set predictedCouponStatus=1  where response>0 and brand=? and couponGroupType <> 1 and coupongrouptype not in ".$coupons;
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param_nid);
if( $maxNidInDb === false ) {echo 'errorStep1';
echo $sql;
     die( print_r( sqlsrv_errors(), true));
}



date_default_timezone_set("Asia/Calcutta");
$sql="update predictorresulttableFlipkart  set LastCheckTime=? where brand=? ";
$param=array(strtotime(date("Y-m-d")),$sid);
$maxNidInDb = sqlsrv_query($conn,$sql,$param);//,$param_nid);
echo 'Step5';
if( $maxNidInDb === false ) {echo 'Step5';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = ";WITH CTE AS ( SELECT  *, MAX(response) OVER(PARTITION BY fullurl) MaxC2 FROM 

predictorresulttableFlipkart where brand = ? )
UPDATE CTE 
SET bestcoupon = CASE WHEN MaxC2 = response and response <>0 THEN couponcode ELSE '' END
, bestcouponstatus = case When predictedcouponstatus=4 then 0 else predictedcouponstatus END
, bestcoupondesc = CASE WHEN MaxC2 = response and response <>0 THEN couponcodetitle ELSE '' END
";
//$sql =  str_replace('lavesh','"',$sqlToCheckNID);
$param_nid=array($sid);
$maxNidInDb = sqlsrv_query($conn,$sqlToCheckNID,$param_nid);
echo 'Step6';
if( $maxNidInDb === false ) {echo 'Step6';
     die( print_r( sqlsrv_errors(), true));
}

$sqlToCheckNID = "update predictorresulttableFlipkart set result = '{laveshBestCouponlavesh:'+CONVERT(varchar(10),BestCouponStatus)+',laveshSavinglavesh:lavesh'+CONVERT(varchar(200),Response)+'lavesh,laveshSuccessfullavesh:'+CONVERT(varchar(10),predictedCouponStatus)+',laveshcouponCodelavesh:lavesh'+couponCode+'lavesh,laveshdescriptionlavesh:lavesh'+couponCodeTitle+'lavesh,laveshdomainlavesh:lavesh'+retailer+'.comlavesh,laveshurllavesh:lavesh'+fullurl+'lavesh}' where brand=? and predictedcouponstatus in (1,2)";
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