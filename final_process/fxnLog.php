<?php



function errorLog($filename,$message){

$timestamp= date('Y-m-d H:i:s');
$data= "\n".$timestamp. ' => '.$message
$filename="errorLog_".date("Y-m-d").".php";
$path="C:\xampp\htdocs\cpnVodo\SimulationWithoutAutomatn\logs\".$filename;

$isFileExist=file_exists($path);




if ($isFileExist){

$handle = fopen($path, 'a')
}
else {
$handle = fopen($path, 'w')
}

fwrite($handle, $data);

fclose($handle);

}

