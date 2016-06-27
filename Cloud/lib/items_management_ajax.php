<?php
	
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Gateway.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Sensor.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Actuator.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Topic.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Topic_Key.php';
	
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
    
    if ( strcmp($_POST['request'], 'add_gateway') == 0) {
	    
	    $gateway = new Gateway();
	    $gateway->name = $_POST['name'];
	    
	    $response = $iot_manager->add_gateway($gateway);
	    
	    die(json_encode($response));
	    
    } else if ( strcmp($_POST['request'], 'add_sensor') == 0) {
	    
	    $sensor = new Sensor();
	    $sensor->name = $_POST['name'];
	    $sensor->id_gateway = $_POST['id_gateway'];
	    
	    $response = $iot_manager->add_sensor($sensor);
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'add_actuator') == 0) {
	    
	    $actuator = new Actuator();
	    $actuator->name = $_POST['name'];
	    $actuator->id_gateway = $_POST['id_gateway'];
	    
	    $response = $iot_manager->add_actuator($actuator);
	    
	    die(json_encode($response));
	} else if ( strcmp($_POST['request'], 'update_gateways_select') == 0) {
	    
	    $response = $iot_manager->get_JSON_Gateways();
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'update_sensors_actuators_select') == 0) {
	    
	    $response = $iot_manager->get_JSON_Sensors_Actuators();
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'add_subscribe_topic') == 0) {
	    
	    $topic = new Topic();
	    $topic->name = $_POST['name'];
	    $topic->id_sensor_actuator = $_POST['id_sensor_actuator'];
	    $topic->widget_view = $_POST['widget_view'];
		$myArray = explode(',', $_POST['keys']);
	    
	    foreach ($myArray as $key) {
		    $topic_key = new Topic_Key();
		    $topic_key->name = $key;
		    
		    array_push($topic->keys, $topic_key);
	    }

	    $response = $iot_manager->add_subscribe($topic);
	    
	    die(json_encode($response));
	} else if ( strcmp($_POST['request'], 'add_publish_topic') == 0) {
	    
	    $topic = new Topic();
	    $topic->name = $_POST['name'];
	    $topic->id_sensor_actuator = $_POST['id_sensor_actuator'];
	    
	    $myArray = explode(',', $_POST['keys']);
	    
	    foreach ($myArray as $key) {
		    $topic_key = new Topic_Key();
		    $topic_key->name = $key;
		    
		    array_push($topic->keys, $topic_key);
	    }

	    $response = $iot_manager->add_publish($topic);
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'delete_topic') == 0) {
	    
	    $response = $iot_manager->delete_topic($_POST['id_topic']);
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'delete_sensor_actuator') == 0) {
	    
	    $response = $iot_manager->delete_sensor_actuator($_POST['id_sensor_actuator']);
	    
	    die(json_encode($response));
	    
	} else if ( strcmp($_POST['request'], 'delete_gateway') == 0) {
	    
	    $response = $iot_manager->delete_gateway($_POST['id_gateway']);
	    
	    die(json_encode($response));
	    
	}