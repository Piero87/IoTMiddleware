<?php
	
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	$iot_manager = new IoT_Manager();
	
	$sensors = $iot_manager->getSensors();
	
	$response = array();
	
	if (count($sensors) != 0) {
		
		
		
		foreach ($sensors as $sensor) {
			
			foreach ($sensor->topics as $topic) {
				
				if (strcmp($topic->type, "publish") == 0) {
					
			        foreach ($topic->keys as $key) {
				        
				        $data = $iot_manager->getLastSensorData($key->id);
				        
				        if (is_numeric($data)) {
					        $data = number_format((float)$data, 2, '.', '');
				        }
				        
				        if ($data !== false) {
					        
					        $update = array();
					        $update['id'] = $key->id;
					        $update['value'] = $data;
					        
					        array_push($response, $update);
					    }
				    }
				}
			}
		}
	}
	
	$output = json_encode($response);
	
	die($output);
	
	
	/*
	$response = array();
	$response['type'] = 'Success';
	$response['type'] = 'Error';
	
	
	*/
	
?>