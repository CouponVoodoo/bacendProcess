<?php
//sleep(10600);
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql = "drop table shopsmart.dbo.baseUrlDrupalCopy ";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {echo 'hbbh';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}
$sql ="SELECT * INTO shopsmart.dbo.baseUrlDrupalCopy FROM openquery(MYSQL, 'SELECT * FROM coupon_finder.field_data_field_base_url')";

$response = sqlsrv_query($conn,$sql);
if( $response === false ) {echo 'hbbh';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {echo 'step 2';
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}
$sql ="CREATE INDEX findex ON baseUrlDrupalCopy (field_base_url_value)";
$response = sqlsrv_query($conn,$sql);

if( $response === false ) {echo 'step 3';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );


//exit;


#OpenConnections
//sleep(50);

$i = 0;
while ($i<200) {
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql = "update scrapedproductsJabong set flipkartType=b.flipkartType 
     from scrapedproductsJabong a inner join (select * from scrapedproductsJabong 
     where flipkartType is not null and retailerId in (14782,14792)) b  on a.pageurl=b.pageurl where a.retailerId in (14782,14792)
      and a.flipkartType is null";

$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step6';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}


$sql="delete from scrapedproductsJabong where Category=0 and retailerid in (14782,14792)";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step7';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="delete from scrapedproductsJabong where Category is null and retailerid in (14782,14792)";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step8';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}




$sql="UPDATE scrapedproductsJabong SET Brand = b.brandTitle FROM scrapedproductsJabong a JOIN flipkartScrapedBrands b ON a.brand = b.scrapedBrand where a.retailerid in (13419,14782,10)";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="UPDATE scrapedproductsJabong SET Brand = b.brandTitle FROM scrapedproductsJabong a JOIN fabfurnishScrapedBrands b ON a.brand = b.scrapedBrand where a.retailerid in (14792)";
$response = sqlsrv_query($conn,$sql);
if( $response === false ) {
     die( print_r( sqlsrv_errors(), true));
}

$sql ="UPDATE dbo.scrapedproductsjabong
SET brand =  CASE
                        WHEN product like '%Vanca%' and retailerid in (14782,13419,10) THEN 'The Vanca'  
                         WHEN product like '%The Privilege%' and retailerid in (14782,13419,10) THEN 'The Privilege'  
         WHEN product like '%The Privilege%' and retailerid in (14782,13419,10) THEN 'The Privilege'  
         WHEN product like '%The Indian Garage%' and retailerid in (14782,13419,10) THEN 'The Indian Garage Co.'  
         WHEN product like '%The Elephant Company%' and retailerid in (14782,13419,10) THEN 'The Elephant Company'  
         WHEN product like '%United Colors Of Benetton%' and retailerid in (14782,13419,10) THEN 'United Colors Of Benetton'  
         WHEN product like '%John Players%' and retailerid in (14782,13419,10) THEN 'John Players'
         WHEN product like '%John Miller%' and retailerid in (14782,13419,10) THEN 'John Miller'
         WHEN product like '%Campus Sutra%' and retailerid in (14782,13419,10) THEN 'Campus Sutra'
WHEN product like '%Urban Nomad%' and retailerid in (14782,13419,10) THEN 'Urban Nomad'
WHEN product like '%Urban Vastra%' and retailerid in (14782,13419,10) THEN 'Urban Vastra'
WHEN product like '%Urban Yoga%' and retailerid in (14782,13419,10) THEN 'Urban Yoga'
WHEN product like '%Black Coffee%' and retailerid in (14782,13419,10) THEN 'Black Coffee'
WHEN product like '%Black Panther%' and retailerid in (14782,13419,10) THEN 'Black Panther'
WHEN product like '%American Swan%' and retailerid in (14782,13419,10) THEN 'American Swan'
WHEN product like '%American Tourister%' and retailerid in (14782,13419,10) THEN 'American Tourister'
WHEN product like '%Numero Uno%' and retailerid in (14782,13419,10) THEN 'Numero Uno'
WHEN product like '%Sports 52 Wear%' and retailerid in (14782,13419,10) THEN 'Sports 52 Wear'
WHEN product like '%Wear Your Mind%' and retailerid in (14782,13419,10) THEN 'Wear Your Mind'
WHEN product like '%Rain & Rainbow%' and retailerid in (14782,13419,10) THEN 'Rain & Rainbow'
WHEN product like '%Style Quotient By Noi%' and retailerid in (14782,13419,10) THEN 'Style Quotient By Noi'
WHEN product like '%Tokyo Talkies%' and retailerid in (14782,13419,10) THEN 'Tokyo Talkies'
WHEN product like '%Heart 2 Heart%' and retailerid in (14782,13419,10) THEN 'Heart 2 Heart'
WHEN product like '%Jealous 21%' and retailerid in (14782,13419,10) THEN 'Jealous 21'
WHEN product like '%Vero Moda%' and retailerid in (14782,13419,10) THEN 'Vero Moda'
WHEN product like '%Diva Fashion%' and retailerid in (14782,13419,10) THEN 'Diva Fashion'
WHEN product like '%Allen Solley%' and retailerid in (14782,13419,10) THEN 'Allen Solley'
WHEN product like '%Angry Birds%' and retailerid in (14782,13419,10) THEN 'Angry Birds'
WHEN product like '%No Code%' and retailerid in (14782,13419,10) THEN 'No Code'
WHEN product like '%Global Desi%' and retailerid in (14782,13419,10) THEN 'Global Desi'
WHEN product like '%Steve Madden%' and retailerid in (14782,13419,10) THEN 'Steve Madden'
WHEN product like '%Global Step%' and retailerid in (14782,13419,10) THEN 'Global Step'
WHEN product like '%Do Bhai%' and retailerid in (14782,13419,10) THEN 'Do Bhai'
WHEN product like '%Sole Struck%' and retailerid in (14782,13419,10) THEN 'Sole Struck'
WHEN product like '%Carlton London%' and retailerid in (14782,13419,10) THEN 'Carlton London'
WHEN product like '%F Sports%' and retailerid in (14782,13419,10) THEN 'F Sports'
WHEN product like '%Hush Puppies%' and retailerid in (14782,13419,10) THEN 'Hush Puppies'
WHEN product like '%Force 10%' and retailerid in (14782,13419,10) THEN 'Force 10'
WHEN product like '%Salt N Pepper%' and retailerid in (14782,13419,10) THEN 'Salt N Pepper'
WHEN product like '%Van Heusen%' and retailerid in (14782,13419,10) THEN 'Van Heusen'
WHEN product like '%Lee Cooper%' and retailerid in (14782,13419,10) THEN 'Lee Cooper'
WHEN product like '%Carpe Diem%' and retailerid in (14782,13419,10) THEN 'Carpe Diem'
WHEN product like '%Paris Hilton%' and retailerid in (14782,13419,10) THEN 'Paris Hilton'
WHEN product like '%Danish Design%' and retailerid in (14782,13419,10) THEN 'Danish Design'


 ELSE brand
                    END 
WHERE  retailerid in (14782,13419,10)
";
$response = sqlsrv_query($conn,$sql); 
if( $response === false ) {
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

echo $i;
$i=$i+1;
$sql="delete from scrapedproductsJabong where listingprice=''";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step9';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsjabong set ListingPrice = REPLACE(ListingPrice,',','')";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step10';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}
$sql="update scrapedproductsjabong set MRPPrice = REPLACE(MRPPrice,',','')";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step11';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="WITH TempEmp (Name,type,duplicateRecCount)
AS
(
SELECT pageurl,flipkarttype,ROW_NUMBER() OVER(PARTITION by pageurl ORDER BY pageurl) 
AS duplicateRecCount
FROM dbo.scrapedproductsJabong 
)
delete FROM scrapedproductsJabong where pageurl in (select name from TempEmp where duplicateRecCount>1 ) and flipkarttype ='1'";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step12';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}


$sql="WITH TempEmp (Name,type,duplicateRecCount)
AS
(
SELECT pageurl,flipkarttype,ROW_NUMBER() OVER(PARTITION by pageurl ORDER BY pageurl) 
AS duplicateRecCount
FROM dbo.scrapedproductsJabong 
)
delete FROM TempEmp where duplicateRecCount>1";



$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step13';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsjabong set pageurl = REPLACE(pageurl,'''','')";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step14';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsJabong set PageUrl=left(PageUrl, charindex('#', PageUrl)-1) where retailerId=10 and pageurl like '%#%'";
$maxNidInDb = sqlsrv_query($conn,$sql);
if( $maxNidInDb === false ) {echo 'Step15';
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsjabong  set product = RTRIM(LTRIM(product))";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

$sql="update scrapedproductsjabong set brand= left(product, charindex(' ', product)) where retailerid in (14782,14792,14786,10) ";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

     die( print_r( sqlsrv_errors(), true));
}

sqlsrv_close( $conn );
$api = 'www.couponvoodoo.com/add-product/u?url='.uniqid().'&predictor=1';




$html = file_get_contents_curl("$api");
echo $html;
if (empty($html) ) {echo 'done';
$serverName = "localhost";
$connection = array( "Database"=>"ShopSmart");
$conn = sqlsrv_connect( $serverName, $connection);

$sql="truncate table baseurldrupalcopy";
$stmt = sqlsrv_query( $conn, $sql);   
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}
sqlsrv_close( $conn );


exit;}


}




function file_get_contents_curl($url)
{
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 
    $data = curl_exec($ch);
    curl_close($ch);
 
    return $data;
}

