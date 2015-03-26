<?php

//updateCouponRepo('jabong');
updateCouponRepo('myntra');
//updateCouponRepo('firstcry');
function updateCouponRepo($Retailer){
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

    if($conn) {
             
    }else{
           echo "Connection could not be established.";
           die( print_r( sqlsrv_errors(), true));
    }

$sql ="Delete from predictorCouponDescRepository ";
//$param = array($couponCode,$Retailer,$Retailer.'-'.$couponCode,$couponTitle,'','','','','');
//$response1 = sqlsrv_query($conn,$sql);//,$param);

$sql ="select * from CouponsByBrand where Brand like (?) and VoucherType like '%code%'";
$param = array('%'.$Retailer.'%');
$response = sqlsrv_query($conn,$sql,$param);

while( $datarow = sqlsrv_fetch_array( $response , SQLSRV_FETCH_ASSOC) ) {
echo '------------------------------------------------------------------------ </br>';
//echo $datarow["ProductUrl"];
$couponCode = $datarow["CouponCode"];
$couponTitle = $datarow["Title"];

$sql ="select * from predictorCouponDescRepository where retailer like (?) and couponCode = (?)";
$param = array('%'.$Retailer.'%',$couponCode);
$response1 = sqlsrv_query($conn,$sql,$param);
$nidCheck=sqlsrv_fetch_array($response1, SQLSRV_FETCH_ASSOC);   
echo "NID..nidcheck".var_dump($nidCheck).empty($nidCheck) ;
if (empty($nidCheck)){
echo '$couponCode'.$couponCode;
$sql ="INSERT INTO [ShopSmart].[dbo].[predictorCouponDescRepository] ([couponCode],[Retailer],[CouponIdentifier],[couponCodeDescription],[Total],[CouponStatus],[MinOrder],[DiscountType],[Discount],[LimitType],[LimitAmount],[LimitOn]) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$param = array($couponCode,$Retailer,$Retailer.'-'.$couponCode,$couponTitle,'',1,'','','','none',0,'none');
$response1 = sqlsrv_query($conn,$sql,$param);

if ($response1 === false) {
                die(print_r(sqlsrv_errors(), true));
            }

}
else {

$sql ="update [ShopSmart].[dbo].[predictorCouponDescRepository] set couponstatus=1 where retailer like (?) and couponCode = (?)";
$param = array($Retailer,$couponCode);
$response1 = sqlsrv_query($conn,$sql,$param);



}
}

sqlsrv_close( $conn );
}