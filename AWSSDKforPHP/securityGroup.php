<?php
require_once 'sdk.class.php';
// Create the AmazonEC2 object so we can call various APIs.
$ec2 = new AmazonEC2();

// Create a new security group.
$response = $ec2->create_security_group ( 'GettingStartedGroup', 'Getting Started Security Group');
if (!$response->isOK())
{
	if (((string) $response->body->Errors->Error->Code) === 'InvalidGroup.Duplicate')
	{
		// This means that the group is already created, so ignore.
		echo 'create_security_group returned an acceptable error: ' . $response->body->Errors->Error->Message . PHP_EOL;
	} else {
		print_r($response);
		exit();
	}
}

// TODO - Change the code below to use your external ip address. 
$ip_source = '54.243.150.171/32';

// Open up port 22 for TCP traffic to the associated IP
// from above (e.g. ssh traffic).
$ingress_opt = array(
	'GroupName' => 'GettingStartedGroup',
	'IpPermissions' => array(
		array(
			'IpProtocol' => 'tcp',
			'FromPort' => '22',
			'ToPort' => '22',
			'IpRanges' => array(
				array('CidrIp' => $ip_source),
			)
    )
	)
);

// Authorize the ports to be used.
$response = $ec2->authorize_security_group_ingress($ingress_opt);
if (!$response->isOK()) 
{
	if (((string) $response->body->Errors->Error->Code) === 'InvalidPermission.Duplicate') 
	{
		echo 'authorize_security_group_ingress returned an acceptable error: ' . $response->body->Errors->Error->Message . PHP_EOL;
	} else {
		print_r($response);
		exit();
	}
}