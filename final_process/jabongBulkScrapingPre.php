<?php
# Configure

$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

#OpenConnections
if( $conn ) {

    }else{

//           die( print_r( sqlsrv_errors(), true));
    }

$sqlToCheckNID ="truncate table scrapedproducts ";
//$param_nid = array($prodUrl);
$response1 = sqlsrv_query($conn,$sqlToCheckNID);

$sqlToCheckNID ="select ProductUrlList, InputURL, ProductCount, categoryID, brand from 

jabongCpnVoodooPreCachedScrapedUrls[nolock] where status =0 ";
//$param_nid = array($prodUrl);
$response1 = sqlsrv_query($conn,$sqlToCheckNID);
$fullJSON='';
$i=0;
while( $datarow = sqlsrv_fetch_array( $response1 , SQLSRV_FETCH_ASSOC) ) {
$i=$i+1;
$url=$datarow ;    
$allProductsList=$url['ProductUrlList'];
$inputUrl=$url['InputURL'];
$categoryId=$url['categoryID'];
$brand=$url['brand'];
$allProductDetailsArray=explode("||",$allProductsList);

 foreach($allProductDetailsArray as $productDetailsJson)
 {
 $productDetailsJson==str_replace('&amp;','',str_replace('0"','0',str_replace('7"','7',str_replace('5"','5',$productDetailsJson))));
 $productDetailArr=json_decode($productDetailsJson,true);
 $productUrl=$productDetailArr['PU'];
 $productName=str_replace('\\','/',$productDetailArr['PN']);
 $productImage=$productDetailArr['PI'];
 $productBrand=str_replace('\\','/',$productDetailArr['B']);
 $listPrice=str_replace('Rs.','',$productDetailArr['LP']);
 $mrp=str_replace('Rs.','',$productDetailArr['Mrp']);
 if (strpos($productUrl,'jabong') !== false) {
    
}
else $productUrl='http://www.jabong.com/'.$productUrl;
echo $mrp.' '.$productImage.' '.$productBrand;
 
 $sql="INSERT INTO ScrapedProducts([Retailer],[Category],[Brand],[Product],[Breadcrumb],[ListingPrice],[PageURL],[PageTitle],[StartingPageURL],[timestamp],[Status],[Result],[ScrapedOrder],[HeaderJson],[MRPprice],[ProductImage],[retailerId])values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
 $param=array('jabong',$categoryId, $productBrand,$productName,'',$listPrice,$productUrl,'',$inputUrl,'',0,'',$i,$productDetailsJson,$mrp,$productImage,5);
 $response2 = sqlsrv_query($conn,$sql,$param);
 
 }

}
// Close the connection.
sqlsrv_close( $conn );
if (empty($nidCheck)){return null;}
else return $nidCheck;
