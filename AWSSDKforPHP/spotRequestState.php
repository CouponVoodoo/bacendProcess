<?php
$spot_instance_request_ids = array();
for ($i=0; $i < $response->body->spotInstanceRequestSet->item->count(); $i++) 
{
	$spot_instance_request_id = (string)$response->body->spotInstanceRequestSet->item[$i]-//>spotInstanceRequestId;
	$spot_instance_request_ids[] = $spot_instance_request_id;
}
//$spot_instance_request_ids[] = '9e40aff2-9a37-4d8f-aab8-80559d7d15c4';
// Initialize a variable that will track whether there are any
// requests still in the open state.
$any_open = false;

// Initialize an array to hold any instances we activate so we can terminate them later.
$instance_ids = array();

do {
	// Call describe_spot_instance_requests with all of the request ids to
	// monitor (e.g. that we started).
	$describe_opt = array(
		'SpotInstanceRequestId' => '9e40aff2-9a37-4d8f-aab8-80559d7d15c4'
	);
	$response = $ec2->describe_spot_instance_requests($describe_opt);		
	if (!$response->isOK()) 
	{
		print_r($response);
		exit();
	}

	// Reset the any_open variable to false - which assumes there
	// are no requests open unless we find one that is still open.
	$any_open = false;

	// Look through each request and determine if they are all in
	// the active state.
	foreach ($response->body->spotInstanceRequestSet->item as $item) 
	{
		echo "spotInstanceRequestId = $item->spotInstanceRequestId, state = $item->state" . PHP_EOL;
		
		// If the state is open, it hasn't changed since we attempted
		// to request it. There is the potential for it to transition
		// almost immediately to closed or cancelled so we compare
		// against open instead of active.
		if (((string)$item->state) === 'open') 
		{
			$any_open = true;
			break;
		}
		
		if (((string)$item->state) === 'active') 
		{
			// Get the instanceId once the spot instance request is active
			$instance_id = (string)$item->instanceId;
			echo 'Instance $instanceId is active.' . PHP_EOL;
			
			// Store the instanceId for any instances we've started so we can terminate them later.
			if (!in_array($instanceId, $instanceIds)) 
			{
				$instance_ids[] = (string)$item->instanceId;
			}
		}
	}
	
	if ($any_open) 
	{
		echo 'Requests still in open state, will retry in 60 seconds.' . PHP_EOL;
		sleep(60);
	}
} 
while($any_open);
 