<?php


$serverName = "localhost";
$connection = array(
    "Database" => "ShopSmart"
);
$conn       = sqlsrv_connect($serverName, $connection);

$sql = "Delete from cachingresulttable";
$fullJSON  = "";
$sql       = "select Result,FullUrl from cachedCouponFinderResults[nolock] where resultstatus = 1  and fullurl in (select distinct fullurl from predictorsampletable where runcount = 1)";
/*$sql= "select * from cachedCouponFinderResults[nolock] where fullurl in (select distinct fullurl from predictorsampletable where runcount = 1 and successful='' and fullurl like '%myntra%') 
and nodestatus = 1 and resultstatus = 1";*/
$response1 = sqlsrv_query($conn, $sql);
#create one master array of the records 

  $fullJSON='';
$purl = "'h'";
$i=0;
echo 'step 1'.$response1;
 while( $datarow = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {
echo $i;
if (empty($datarow)){echo 'done';sqlsrv_close( $conn ); exit;}
//echo $datarow["ProductUrl"];
   //$purl = $purl. ", '".$datarow["ProductUrl"]. "'";
   $element = json_encode(array($datarow));
//echo $element;
    $fullJSON = $fullJSON.$element;
    $i=$i+1;
}


echo 'step 2';
 $fullJSON = str_replace("][",",",$fullJSON);
    $results = json_decode($fullJSON, true);
//var_dump($resultsArr);
$fullJSONresult = '';
 foreach($results as $res)
  {

    $resultsArr = json_decode($res["Result"], true);
    echo '------------------------------------------------------------------------ </br>';
   // var_dump($resultsArr);
	
	$sql3      = "select top 1 uid as sid from predictorsampletable where fullurl = (?)";
        $param3    = array(
                $res["FullUrl"]
                
            );
    //    $response3 = sqlsrv_query($conn, $sql3, $param3);
      //  $datarow3 = sqlsrv_fetch_array( $response3 , SQLSRV_FETCH_ASSOC) ;
		//$sid = $datarow3["sid"];
    if (strpos($res["Result"], 'BestCoupon') === false) {echo 

'emptyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy';

	    $sql      = "update [predictorSampleTable] set successful = 2 where fullurl = (?)  ";
        $param    = array(
                $res["FullUrl"]
                
            );
        $response = sqlsrv_query($conn, $sql, $param);
        /*$sql      = "update [predictorSummaryTable] set counterror = counterror+1 where sid = (?)  

";
                $param    = array(
                
                $sid
                
                );    		
				if ($response === false) {
                die(print_r(sqlsrv_errors(), true));
            }*/
		    }
	else {
	    

        foreach ($resultsArr as $resultArr) {
            $UID = $res["FullUrl"] . $resultArr["couponCode"];
            
            echo $UID;
            $sql      = "update [predictorSampleTable] set response = (?),successful = 

(?),bestcoupon = (?) where url_coupon_Id = (?) ";
            $param    = array(
                $resultArr["Saving"],
                $resultArr["Successful"],
                $resultArr["BestCoupon"],
                $UID
            );
            $response = sqlsrv_query($conn, $sql, $param);
			
			
            if ($response === false) {
                die(print_r(sqlsrv_errors(), true));
            }
			
            
        }
    }
}

updateCountsInSummaryTable($conn);
createDmpTable($conn);
function createDmpTable($conn){
$sql ="Drop table predictorsummarytableDmp select * into predictorsummarytableDmp from predictorsummarytable";
$response1 = sqlsrv_query($conn,$sql);

$sql ="Drop table predictorsampletableDmp select * into predictorsampletableDmp from predictorsampletable";
$response1 = sqlsrv_query($conn,$sql);

}
function updateCountsInSummaryTable($conn) {
$sql ="UPDATE predictorsummarytable SET predictorsummarytable.countSuccessful= b.succ FROM (select uid,couponcode,count (successful) as succ from predictorsampletable where successful = 1 and runcount = 1 group by uid,couponcode  ) as b JOIN predictorsummarytable     ON predictorsummarytable.sID+predictorsummarytable.couponCode = b.uid+b.couponcode";
$response1 = sqlsrv_query($conn,$sql);

$sql ="UPDATE predictorsummarytable SET predictorsummarytable.countunSuccessful= b.succ FROM (select uid,couponcode,count (successful) as succ from predictorsampletable where successful = 0 and runcount = 1 group by uid,couponcode  ) as b JOIN predictorsummarytable     ON predictorsummarytable.sID+predictorsummarytable.couponCode = b.uid+b.couponcode";
$response1 = sqlsrv_query($conn,$sql);

$sql ="UPDATE predictorsummarytable SET predictorsummarytable.counterror= b.succ FROM (select uid,couponcode,count (successful) as succ from predictorsampletable where successful = 2 and runcount = 1 group by uid,couponcode  ) as b JOIN predictorsummarytable     ON predictorsummarytable.sID+predictorsummarytable.couponCode = b.uid+b.couponcode";
$response1 = sqlsrv_query($conn,$sql);





//echo $sid.','.$couponCode;
/*
$sql ="update predictorsummarytable set countunsuccessful = (select count(successful) from 

predictorsampletable where uid = (?) and couponcode = (?) and successful = 0) where sid = (?) and 

couponcode = (?)";
$param1 = array($sid,$couponCode,$sid,$couponCode);
$response1 = sqlsrv_query($conn,$sql,$param1);
*/


}


sqlsrv_close($conn);