<?php
	
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	
	if (!$_POST || strcmp($_POST['request'], 'request') == 0)
	{
		$output = json_encode(array( //create JSON data
			'success' => 0,
            'error' => 1,
            'error_msg' => 'Request msg not arrived'
        ));
        die($output); //exit script outputting json data
	}
	
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		$output = json_encode(array( //create JSON data
			'success' => 0,
            'error' => 1,
            'error_msg' => 'Something goes wrong with ajax request.'
        ));
        die($output);
    }
    
	$iot_manager = new IoT_Manager();
	
	if ( strcmp($_POST['request'], 'get_sensor_actuators') == 0) {
		
		$response = $iot_manager->get_JSON_Sensors_Actuators();
		
		die(json_encode($response));
		
	} else if ( strcmp($_POST['request'], 'get_topics_with_id') == 0) {
		
		$response = $iot_manager->get_JSON_Topics_With_ID($_POST['id_sensor_actuator']);
		
		die(json_encode($response));
		
	} else if ( strcmp($_POST['request'], 'get_key_with_topic_id') == 0) {
		
		$response = $iot_manager->get_JSON_Keys($_POST['id_topic']);
		
		die(json_encode($response));
		
	} else if ( strcmp($_POST['request'], 'get_subscribe_topics') == 0) {
		
		$response = $iot_manager->get_JSON_Subscribe_Topics();
		
		die(json_encode($response));
		
	} else if ( strcmp($_POST['request'], 'add_rule') == 0) {
		
		$rule = new Rule();

		$rule->id_topic = $_POST['id_topic'];
		$rule->id_key = $_POST['id_key'];
		$rule->condition_type = $_POST['condition_type'];
		$rule->condition_value = $_POST['condition_value'];
		$rule->hold_timer = $_POST['hold_timer'];
		$rule->id_topic_result = $_POST['id_topic_result'];
		$rule->id_key_result = $_POST['id_key_result'];
		$rule->key_type_result = $_POST['key_type_result'];
		$rule->key_value_result = $_POST['key_value_result'];
	    
		$response = $iot_manager->add_Rule($rule);
		
		die(json_encode($response));
		
	} else if ( strcmp($_POST['request'], 'delete_rule') == 0) {
		
		$response = $iot_manager->delete_rule($_POST['id_rule']);
		
		die(json_encode($response));
		
	} 
	