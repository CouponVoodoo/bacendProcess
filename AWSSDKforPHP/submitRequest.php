// Setup the specifications of the launch. This includes the
// instance type (e.g. t1.micro) and the latest Amazon Linux
// AMI id available. Note, you should always use the latest
// Amazon Linux AMI id or another of your choosing.
<?php
require_once 'sdk.class.php';
$ec2 = new AmazonEC2();
 
$response = $ec2->start_instances('i-1f549375');
 
// Success?
var_dump($response->isOK());
