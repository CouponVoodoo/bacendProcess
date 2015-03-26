 <?php
 $serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");

$conn = sqlsrv_connect( $serverName, $connection);
    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

$sid = $_GET["sid"] ;
$mrp = $_GET["mrp"];
$listPrice = $_GET["listPrice"];
$type = $_GET["type"];
//$baseurl = urldecode($_GET["baseUrl"]);
//echo 'dec'.$sid;
 $sid=str_replace('&amp;','&',urldecode($sid));
if ($mrp==0 || empty($mrp) || $listPrice==0 || empty($listPrice))
{
$mrp=$listPrice;
}

$sql = "select count(*) as num from predictorsummarytable where sid = (?)";
$param = array($sid)  ;
$response = sqlsrv_query($conn,$sql,$param);
$datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC);
//echo 'num : '.$datarow['num'];
if ($datarow['num'] ==0){
echo '{"Error":"'.$sid.' does not exist"}';
exit;
}

$sql = "select * from predictorcoupondescrepository where couponcode in (select distinct couponcode 

from predictorsampletable where uid = (?) and successful= 1)  ";
$param = array($sid)  ;
$response = sqlsrv_query($conn,$sql,$param);

  #create one master array of the records */
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}
$fullJSON='';
while( $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {      

    $element = json_encode(array($datarow));
    $fullJSON = $fullJSON.$element;     
}
$response='[';
if ($fullJSON !=''){
$fullJSON = str_replace("][",",",$fullJSON);
 $resultsArr = json_decode($fullJSON, true);
//var_dump($resultsArr);
//$fullJSONarr = '';



 foreach($resultsArr as $datarow)
  {
$couponCode=  $datarow['couponCode'];
$couponDesc=  $datarow['couponCodeDescription'];
$retailer =$datarow['Retailer'];
$saving= savingCalculation($listPrice,$mrp,$datarow);
//var_dump(empty($saving)) ;exit;
$succ=1;
if (empty($saving)){
$saving = 0;
$succ=0;
}
if ($response == '['){
$response = $response.'{"BestCoupon":0,"Saving":'.$saving.',"Successful":'.$succ.',"couponCode":"'.

$couponCode.'","description":"'.$couponDesc.'"}';
}
else {
$response = $response.',{"BestCoupon":0,"Saving":'.$saving.',"Successful":'.

$succ.',"couponCode":"'.$couponCode.'","description":"'.$couponDesc.'"}';
}
}
 $response=$response;
}
$retailer=explode('-',$sid)[0];
 $sql = "select * from predictorcoupondescrepository where couponcode not in (select distinct 

couponcode from predictorsampletable where uid = (?) and successful= 1) and retailer like ? and 

couponstatus <> 0";
$param = array($sid,'%'.$retailer.'%')  ;
$response1 = sqlsrv_query($conn,$sql,$param);

  #create one master array of the records */
if( $response1 === false ) {
     die( print_r( sqlsrv_errors(), true));
}
$fullJSON='';
while( $datarow = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {      
    $element = json_encode(array($datarow));
    $fullJSON = $fullJSON.$element;     
}
$fullJSON = str_replace("][",",",$fullJSON);
  $resultsArr = json_decode($fullJSON, true);
foreach($resultsArr as $datarow)
  {
$couponCode=  $datarow['couponCode'];
$couponDesc=  $datarow['couponCodeDescription'];
$retailer =$datarow['Retailer'];
//$saving= savingCalculation($listPrice,$mrp,$datarow);
if ($response == '['){
$response = $response.'{"BestCoupon":0,"Saving":0,"Successful":0,"couponCode":"'.

$couponCode.'","description":"'.$couponDesc.'"}';
}
else{
$response = $response.',{"BestCoupon":0,"Saving":0,"Successful":0,"couponCode":"'.

$couponCode.'","description":"'.$couponDesc.'"}';
}
}
 $response=$response.']';
//echo $response;
 
 $dataArr = json_decode($response,true);
	//var_dump($dataArr);
	//$sortedDataArr=	usort($dataArr, 'my_sort');
usort( $dataArr, 'cmp');
	//var_dump($dataArr);
	if($dataArr[0]["Successful"]==1){
	$dataArr[0]["BestCoupon"]=1;
	}
$response = json_encode($dataArr);
 
 //echo $type;exit;
 if ($type=='full'){
echo $response;
 }else {//echo 'else';exit;
 if($dataArr[0]["Successful"]==1){
 echo json_encode($dataArr[0]);
 }
 else echo null;
 }
 
 function cmp( $a, $b){ 
  if( !isset( $a['Saving']) && !isset( $b['Saving'])){ 
    return 0; 
  } 
 
  if( !isset( $a['Saving'])){ 
    return -1; 
  } 
 
  if( !isset( $b['Saving'])){ 
    return 1; 
  } 
 
  if( $a['Saving'] == $b['Saving']){ 
    return 0; 
  } 
 
  return (($a['Saving'] < $b['Saving']) ? 1 : -1); 
} 


 
  function savingCalculation($listPrice,$mrp,$couponArr){
	//
	$minOrderPrice = $couponArr["MinOrder"];
	$discountType = $couponArr["DiscountType"];
	$discountAmount = $couponArr["Discount"];
	$limitType = $couponArr["LimitType"];
	$limitOn = $couponArr["LimitOn"];
	$limitAmount=$couponArr["LimitAmount"];
	$saving = 0;
	if ($listPrice>=$minOrderPrice){
	
		if ($discountType == 'percent') {
	    
			$saving = $discountAmount*$listPrice/100;
		}
		else if ($discountType == 'flat') {
			$saving = $discountAmount;
		}
		
	if ($limitType=='none'){
		$saving = $saving;
	}	
	else if ($limitType=='absolute'){	
		if($saving>$limitAmount){
			$saving=$limitAmount;
		}
		}
        else if ($limitType=='discount'){		
if ($mrp>$listPrice){
$saving=0;
}
}
	else if ($limitType=='percent'){		
		switch ($limitOn)
			{
				case "listPrice":
				//If (Calculated Saving / List Price) *100 > Limit then final saving = List Price * Limit/100
				if ($saving/$listPrice*100 > $limitAmount)	{
					$saving = $listPrice*$limitAmount/100;
									}
				break;					
				case "mrp":
				//If {(MRP-ListPrice)+Calculated Saving} / MRP) *100 > Limit then final saving = (MRP*LIMIT)/100-(MRP-List Price)
				$num1 = $mrp-$listPrice+$saving;
				if (($num1/$mrp)*100>$limitAmount) {
					$saving=($mrp*$listPrice)/100 - ($mrp-$listPrice);
				}
				break;
				default:
				  $saving=$saving;
	        }
	   }
	   return $saving;
	}
  }