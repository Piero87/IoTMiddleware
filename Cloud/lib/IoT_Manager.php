<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Gateway.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Sensor.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Actuator.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Topic.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Topic_Key.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/User.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/models/Rule.php';

class IoT_Manager
{
	private $db;
	
	/*	Constructor
	
	Create the connection with the Database
	*/
    function __construct(){
    	try
		{
			$this->db = new PDO("mysql:dbname=iot_tesi;host=localhost;charset=utf8", "piero", "pierino87",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch(PDOException $e) {
			echo 'PDO ERROR: '.$e->getMessage();
		}
    }
    
    /*	Destructor
	
	Destroy the connection with the Database
	*/
    function __destruct()
    {
	    $this->db = null;
    }
	
	public function delete_rule($id_rule)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $delete_rule = $this->db->prepare("DELETE FROM rules WHERE id = :id_rule");
	    $delete_rule->bindParam(':id_rule', $id_rule, PDO::PARAM_STR);
	    
	    $delete_rule->execute();
		
		if ($delete_rule->rowCount() != 0) {
				
			$response['success'] = 1;
				
		} else {
				
			$response['error'] = 1;
			$response['error_msg'] = 'Something goes wrong.';
		}
		
		return $response;
	}
	
	public function delete_gateway($id_gateway)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $delete_gateway = $this->db->prepare("DELETE FROM gateways WHERE id = :id_gateway");
	    $delete_gateway->bindParam(':id_gateway', $id_gateway, PDO::PARAM_STR);
	    
	    $delete_gateway->execute();
		
		if ($delete_gateway->rowCount() != 0) {
				
			$response['success'] = 1;
				
		} else {
				
			$response['error'] = 1;
			$response['error_msg'] = 'Something goes wrong.';
		}
		
		return $response;
	}
	
	public function delete_sensor_actuator($id_sensor_actuator)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $delete_sensor_actuator = $this->db->prepare("DELETE FROM sensors_actuators WHERE id = :id_sensor_actuator");
	    $delete_sensor_actuator->bindParam(':id_sensor_actuator', $id_sensor_actuator, PDO::PARAM_STR);
	    
	    $delete_sensor_actuator->execute();
		
		if ($delete_sensor_actuator->rowCount() != 0) {
				
			$response['success'] = 1;
				
		} else {
				
			$response['error'] = 1;
			$response['error_msg'] = 'Something goes wrong.';
		}
		
		return $response;
	}
	
	public function delete_topic($id_topic)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $delete_topic = $this->db->prepare("DELETE FROM topics WHERE id = :id_topic");
	    $delete_topic->bindParam(':id_topic', $id_topic, PDO::PARAM_STR);
	    
	    $delete_topic->execute();
		
		if ($delete_topic->rowCount() != 0) {
				
			$response['success'] = 1;
				
		} else {
				
			$response['error'] = 1;
			$response['error_msg'] = 'Something goes wrong.';
		}
		
		return $response;
	}
	
	public function get_rules() {
		
		$rules = array();
	    
		$get_rules = $this->db->prepare("SELECT R.id as id_rule, T1.id as id_topic, T1.name as topic_name,K1.id as id_key, K1.name as key_name,T2.id as id_topic_result, T2.name as topic_name_result,K2.id as id_key_result, K2.name as key_name_result,R.condition_type, R.condition_value, R.hold_timer, R.key_type_result, R.key_value_result,R.gps_checked,R.gps_value FROM topics as T1, topics as T2, table_keys as K1, table_keys as K2, rules as R WHERE T1.id = R.id_topic AND K1.id = R.id_key AND T2.id = R.id_topic_result AND K2.id = R.id_key_result");
	    $get_rules->execute();
	    
	    if ($get_rules->rowCount() != 0) {
		    
		    $rules_results = $get_rules->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($rules_results as $rule_res)
			{
			    $rule = new Rule();
				$rule->id = $rule_res['id_rule'];
				$rule->id_topic = $rule_res['id_topic'];
				$rule->topic_name = $rule_res['topic_name'];
				$rule->id_key = $rule_res['id_key'];
				$rule->key_name = $rule_res['key_name'];
				$rule->condition_type = $rule_res['condition_type'];
				$rule->condition_value = $rule_res['condition_value'];
				$rule->hold_timer = $rule_res['hold_timer'];
				$rule->id_topic_result = $rule_res['id_topic_result'];
				$rule->topic_name_result = $rule_res['topic_name_result'];
				$rule->id_key_result = $rule_res['id_key_result'];
				$rule->key_name_result = $rule_res['key_name_result'];
				$rule->key_type_result = $rule_res['key_type_result'];
				$rule->key_value_result = $rule_res['key_value_result'];
				$rule->gps_checked = $rule_res['gps_checked'];
				$rule->gps_value = $rule_res['gps_value'];
				
				array_push($rules, $rule);
			}
		}
		
		return $rules;
		
	}
	
	public function add_Rule($rule)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT * FROM rules WHERE
	    									id_topic = :id_topic AND id_key = :id_key AND condition_type = :condition_type AND 
	    									condition_value = :condition_value AND hold_timer = :hold_timer AND id_topic_result = :id_topic_result AND 
	    									id_key_result = :id_key_result AND key_type_result = :key_type_result AND key_value_result = :key_value_result AND gps_checked = :gps_checked AND gps_value = :gps_value");
	    									
	    $check_exist->bindParam(':id_topic', $rule->id_topic, PDO::PARAM_STR);
	    $check_exist->bindParam(':id_key', $rule->id_key, PDO::PARAM_STR);
	    $check_exist->bindParam(':condition_type', $rule->condition_type, PDO::PARAM_STR);
	    $check_exist->bindParam(':condition_value', $rule->condition_value, PDO::PARAM_STR);
		$check_exist->bindParam(':hold_timer', $rule->hold_timer, PDO::PARAM_STR);
		$check_exist->bindParam(':id_topic_result', $rule->id_topic_result, PDO::PARAM_STR);
		$check_exist->bindParam(':id_key_result', $rule->id_key_result, PDO::PARAM_STR);
		$check_exist->bindParam(':key_type_result', $rule->key_type_result, PDO::PARAM_STR);
		$check_exist->bindParam(':key_value_result', $rule->key_value_result, PDO::PARAM_STR);
		$check_exist->bindParam(':gps_checked', $rule->gps_checked, PDO::PARAM_STR);
		$check_exist->bindParam(':gps_value', $rule->gps_value, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_rule = $this->db->prepare("INSERT INTO rules (id_topic,id_key,condition_type,condition_value,hold_timer,id_topic_result,id_key_result,key_type_result,key_value_result,gps_checked,gps_value) 
												VALUES (:id_topic,:id_key,:condition_type,:condition_value,:hold_timer,:id_topic_result,:id_key_result,:key_type_result,:key_value_result,:gps_checked,:gps_value)");
			
			$insert_rule->bindParam(':id_topic', $rule->id_topic, PDO::PARAM_STR);
		    $insert_rule->bindParam(':id_key', $rule->id_key, PDO::PARAM_STR);
		    $insert_rule->bindParam(':condition_type', $rule->condition_type, PDO::PARAM_STR);
		    $insert_rule->bindParam(':condition_value', $rule->condition_value, PDO::PARAM_STR);
			$insert_rule->bindParam(':hold_timer', $rule->hold_timer, PDO::PARAM_STR);
			$insert_rule->bindParam(':id_topic_result', $rule->id_topic_result, PDO::PARAM_STR);
			$insert_rule->bindParam(':id_key_result', $rule->id_key_result, PDO::PARAM_STR);
			$insert_rule->bindParam(':key_type_result', $rule->key_type_result, PDO::PARAM_STR);
			$insert_rule->bindParam(':key_value_result', $rule->key_value_result, PDO::PARAM_STR);
			$insert_rule->bindParam(':gps_checked', $rule->gps_checked, PDO::PARAM_STR);
			$insert_rule->bindParam(':gps_value', $rule->gps_value, PDO::PARAM_STR);

			$insert_rule->execute();
			
			if ($insert_rule->rowCount() != 0) {
				
				$response['success'] = 1;
				
				
			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a rule with this values.';
		}

		return $response;
    }
        
    public function add_gateway($gateway)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT name FROM gateways WHERE name = :name");
	    $check_exist->bindParam(':name', $gateway->name, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_gateway = $this->db->prepare("INSERT INTO gateways (name) VALUES (:name)");
			
			$insert_gateway->bindParam(':name', $gateway->name, PDO::PARAM_STR);
			
			$insert_gateway->execute();
			
			if ($insert_gateway->rowCount() != 0) {
				
				$response['success'] = 1;
				
				
			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a gateway with this name.';
		}

		return $response;
    }
    
    public function add_sensor($sensor)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT name FROM sensors_actuators WHERE name = :name AND id_gateway = :id_gateway AND type = 'sensor'");
	    $check_exist->bindParam(':name', $sensor->name, PDO::PARAM_STR);
	    $check_exist->bindParam(':id_gateway', $sensor->id_gateway, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_sensor = $this->db->prepare("INSERT INTO sensors_actuators (name,id_gateway,type) VALUES (:name,:id_gateway,'sensor')");
			
			$insert_sensor->bindParam(':name', $sensor->name, PDO::PARAM_STR);
			$insert_sensor->bindParam(':id_gateway', $sensor->id_gateway, PDO::PARAM_STR);
			
			$insert_sensor->execute();
			
			if ($insert_sensor->rowCount() != 0) {
				
				$response['success'] = 1;
				
				
			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a sensor with this name for the selected Gateway.';
		}

		return $response;
    }
    
    public function add_actuator($actuator)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT name FROM sensors_actuators WHERE name = :name AND id_gateway = :id_gateway AND type = 'actuator'");
	    $check_exist->bindParam(':name', $actuator->name, PDO::PARAM_STR);
	    $check_exist->bindParam(':id_gateway', $actuator->id_gateway, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_actuator = $this->db->prepare("INSERT INTO sensors_actuators (name,id_gateway,type) VALUES (:name,:id_gateway,'actuator')");
			
			$insert_actuator->bindParam(':name', $actuator->name, PDO::PARAM_STR);
			$insert_actuator->bindParam(':id_gateway', $actuator->id_gateway, PDO::PARAM_STR);
			
			$insert_actuator->execute();
			
			if ($insert_actuator->rowCount() != 0) {
				
				$response['success'] = 1;
				
				
			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a actuator with this name for the selected Gateway.';
		}

		return $response;
    }
    
	/*
		I subscribe possono essere di più sensori/attuatori, per esempio due LED su due HUB diversi (con lo stesso certificato) devono potersi iscrivere al topic accendi spegni
	*/
    public function add_subscribe($topic)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT * FROM topics WHERE name = :name AND id_sensor_actuator = :id_sensor_actuator AND type = 'subscribe'");
	    $check_exist->bindParam(':name', $topic->name, PDO::PARAM_STR);
	    $check_exist->bindParam(':id_sensor_actuator', $topic->id_sensor_actuator, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_topic = $this->db->prepare("INSERT INTO topics (name,id_sensor_actuator,type,widget_view) VALUES (:name,:id_sensor_actuator,'subscribe',:widget_view)");
			
			$insert_topic->bindParam(':name', $topic->name, PDO::PARAM_STR);
			$insert_topic->bindParam(':id_sensor_actuator', $topic->id_sensor_actuator, PDO::PARAM_STR);
			$insert_topic->bindParam(':widget_view', $topic->widget_view, PDO::PARAM_STR);
			
			$insert_topic->execute();
			
			if ($insert_topic->rowCount() != 0) {
				
				$id_topic = $this->db->lastInsertId();
				
				foreach ($topic->keys as $topic_key)
				{
					$inser_key = $this->db->prepare("INSERT INTO table_keys (name,id_topic) VALUES (:name,:id_topic)");
			
					$inser_key->bindParam(':name', $topic_key->name, PDO::PARAM_STR);
					$inser_key->bindParam(':id_topic', $id_topic, PDO::PARAM_STR);
					
					$inser_key->execute();
				}
				
				$response['success'] = 1;

			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a subscribe topic with this name for the selected Actuator/Sensor.';
		}

		return $response;
    }
    
    /*
	    I publish topic possono essere di un solo sensore/attuatore, il nome quindi deve essere univoco, ovviamente ci può essere un topic subscribe con lo stesso nome, perchè posso iscrivermi a una publicazione di temperatura per esempio
	*/
    public function add_publish($topic)
    {   
	    $response = array();
	    $response['success'] = 0;
	    $response['error'] = 0;
	    $response['error_msg'] = '';
	    
	    $check_exist = $this->db->prepare("SELECT * FROM topics WHERE name = :name AND type = 'publish'");
	    $check_exist->bindParam(':name', $topic->name, PDO::PARAM_STR);
		
		$check_exist->execute();
		
		if ($check_exist->rowCount() == 0) {
			
			$insert_topic = $this->db->prepare("INSERT INTO topics (name,id_sensor_actuator,type) VALUES (:name,:id_sensor_actuator,'publish')");
			
			$insert_topic->bindParam(':name', $topic->name, PDO::PARAM_STR);
			$insert_topic->bindParam(':id_sensor_actuator', $topic->id_sensor_actuator, PDO::PARAM_STR);
			
			$insert_topic->execute();
			
			if ($insert_topic->rowCount() != 0) {
				
				$id_topic = $this->db->lastInsertId();
				
				foreach ($topic->keys as $topic_key)
				{
					$inser_key = $this->db->prepare("INSERT INTO table_keys (name,id_topic) VALUES (:name,:id_topic)");
			
					$inser_key->bindParam(':name', $topic_key->name, PDO::PARAM_STR);
					$inser_key->bindParam(':id_topic', $id_topic, PDO::PARAM_STR);
					
					$inser_key->execute();
				}
				
				$response['success'] = 1;

			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = 'Something goes wrong.';
			}
		} else {
			$response['error'] = 1;
			$response['error_msg'] = 'Already exist a publish topic with this name, only one actuator/sensor can publish for this topic, in this way it\' easy monitor the data.';
		}

		return $response;
    }

    
    public function get_JSON_Gateways() {
	    
	    $gateways = array();
	    
	    $get_gateways = $this->db->prepare("SELECT * FROM gateways");
	    
	    $get_gateways->execute();
	    
	    if ($get_gateways->rowCount() != 0) {
		    
		    $gateways_results = $get_gateways->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($gateways_results as $result)
			{
				$gateway = array();
				$gateway['id'] = $result['id'];
				$gateway['name'] = $result['name'];
				
				array_push($gateways, $gateway);
			}
		}
		
		return $gateways;
    }
    
    public function get_JSON_Sensors_Actuators() {
	    
	    $sensors_actuators = array();
	    
	    $get_sensors = $this->db->prepare("SELECT * FROM sensors_actuators WHERE type = 'sensor'");
	    
	    $get_sensors->execute();
	    
	    if ($get_sensors->rowCount() != 0) {
		    
		    $sensors_results = $get_sensors->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($sensors_results as $result)
			{
				$sensor = array();
				$sensor['id'] = $result['id'];
				$sensor['name'] = $result['name'];
				$sensor['type'] = 'Sensor';
				
				array_push($sensors_actuators, $sensor);
			}
		}
		
		$get_actuators = $this->db->prepare("SELECT * FROM sensors_actuators WHERE type = 'actuator'");
	    
	    $get_actuators->execute();
	    
	    if ($get_actuators->rowCount() != 0) {
		    
		    $actuators_results = $get_actuators->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($actuators_results as $result)
			{
				$actuator = array();
				$actuator['id'] = $result['id'];
				$actuator['name'] = $result['name'];
				$actuator['type'] = 'Actuator';
				
				array_push($sensors_actuators, $actuator);
			}
		}
		
		return $sensors_actuators;
    }
    
    public function get_JSON_Topics_With_ID($id_sensor_actuator) {
	    
	    $topics = array();
	    
	    $get_topics = $this->db->prepare("SELECT * FROM topics WHERE id_sensor_actuator = :id_sensor_actuator");
	    $get_topics->bindParam(':id_sensor_actuator', $id_sensor_actuator, PDO::PARAM_STR);
	    $get_topics->execute();
	    
	    if ($get_topics->rowCount() != 0) {
		    
		    $topics_results = $get_topics->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($topics_results as $result)
			{
				$topic = array();
				$topic['id'] = $result['id'];
				$topic['name'] = $result['name'];
				$topic['type'] = $result['type'];
				
				array_push($topics, $topic);
			}
		}
		
		return $topics;
    }
    
    public function get_JSON_Keys($id_topic) {
	    
	    $keys = array();
	    
	    $get_keys = $this->db->prepare("SELECT * FROM table_keys WHERE id_topic = :id_topic");
	    $get_keys->bindParam(':id_topic', $id_topic, PDO::PARAM_STR);
	    $get_keys->execute();
	    
	    if ($get_keys->rowCount() != 0) {
		    
		    $keys_results = $get_keys->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($keys_results as $result)
			{
				$key = array();
				$key['id'] = $result['id'];
				$key['name'] = $result['name'];
				
				array_push($keys, $key);
			}
		}
		
		return $keys;
    }
	
	public function get_JSON_Subscribe_Topics() {
	    
	    $topics = array();
	    
	    $get_topics = $this->db->prepare("SELECT T.name as topic_name, T.id, SA.name FROM topics as T, sensors_actuators as SA WHERE T.id_sensor_actuator = SA.id AND T.type = 'subscribe'");
	    $get_topics->bindParam(':id_sensor_actuator', $id_sensor_actuator, PDO::PARAM_STR);
	    $get_topics->execute();
	    
	    if ($get_topics->rowCount() != 0) {
		    
		    $topics_results = $get_topics->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($topics_results as $result)
			{
				$topic = array();
				$topic['id'] = $result['id'];
				$topic['name'] = $result['topic_name'];
				$topic['sensor_actuator'] = $result['name'];
				
				array_push($topics, $topic);
			}
		}
		
		return $topics;
    }
    
	public function getLastSensorData($id_key) {
    
	    $data = false;
	    
		$get_sensor_data = $this->db->prepare("SELECT * FROM sensors_actuators_data WHERE id_key = :id_key ORDER BY timestamp DESC LIMIT 1");
		$get_sensor_data->bindParam(':id_key', $id_key, PDO::PARAM_STR);
	    $get_sensor_data->execute();
	    
	    if ($get_sensor_data->rowCount() != 0) {
		    
		    $result = $get_sensor_data->fetch(PDO::FETCH_ASSOC);
		    
		    $data = $result['value'];
		}
		
		return $data;
		
	}	
	
	
	public function getSensors() {
	    
	    $sensors = array();
	    
		$get_sensors = $this->db->prepare("SELECT * FROM sensors_actuators WHERE type = 'sensor'");
	    $get_sensors->execute();
	    
	    if ($get_sensors->rowCount() != 0) {
		    
		    $sensors_results = $get_sensors->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($sensors_results as $result_sensor)
			{
			    $sensor = new Sensor();
			    $sensor->id = $result_sensor['id'];
				$sensor->name = $result_sensor['name'];
				$sensor->id_gateway = $result_sensor['id_gateway'];
				
				$sensor->topics = $this->getTopicWithSensorActuatorID($result_sensor['id']);
				
				array_push($sensors, $sensor);
			}
		}
		
		return $sensors;
	    
    }
        
    public function getActuators() {
	    
	    $actuators = array();
	    
		$get_actuators = $this->db->prepare("SELECT * FROM sensors_actuators WHERE type = 'actuator'");
	    $get_actuators->execute();
	    
	    if ($get_actuators->rowCount() != 0) {
		    
		    $actuators_results = $get_actuators->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($actuators_results as $result_actuator)
			{
			    $actuator = new Actuator();
			    $actuator->id = $result_actuator['id'];
				$actuator->name = $result_actuator['name'];
				$actuator->id_gateway = $result_actuator['id_gateway'];
				
				$actuator->topics = $this->getTopicWithSensorActuatorID($result_actuator['id']);
				
				array_push($actuators, $actuator);
			}
		}
		
		return $actuators;
	    
    }
    
    public function getCompleteGateways() {
	    
	    $gateways = array();
	    
	    $get_gateways = $this->db->prepare("SELECT * FROM gateways");
	    
	    $get_gateways->execute();
		
		if ($get_gateways->rowCount() != 0) {
			
			$gateways_results = $get_gateways->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($gateways_results as $result)
			{
				$gateway = new Gateway();
				$gateway->id = $result['id'];
				$gateway->name = $result['name'];
				
				
				$get_actuators = $this->db->prepare("SELECT * FROM sensors_actuators WHERE id_gateway = :id_gateway AND type = 'actuator'");
				$get_actuators->bindParam(':id_gateway', $gateway->id, PDO::PARAM_STR);
			    $get_actuators->execute();
			    
			    if ($get_actuators->rowCount() != 0) {
				    
				    $actuators_results = $get_actuators->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($actuators_results as $result_actuator)
					{
					    $actuator = new Actuator();
					    $actuator->id = $result_actuator['id'];
						$actuator->name = $result_actuator['name'];
						$actuator->id_gateway = $result_actuator['id_gateway'];
						
						$actuator->topics = $this->getTopicWithSensorActuatorID($result_actuator['id']);
						
						array_push($gateway->actuators, $actuator);
					}
				}
				
				$get_sensors = $this->db->prepare("SELECT * FROM sensors_actuators WHERE id_gateway = :id_gateway AND type = 'sensor'");
				$get_sensors->bindParam(':id_gateway', $gateway->id, PDO::PARAM_STR);
			    $get_sensors->execute();
			    
			    if ($get_sensors->rowCount() != 0) {

				    $sensor_results = $get_sensors->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($sensor_results as $result_sensor)
					{
					    $sensor = new Sensor();
					    $sensor->id = $result_sensor['id'];
						$sensor->name = $result_sensor['name'];
						$sensor->id_gateway = $result_sensor['id_gateway'];
						
						$sensor->topics = $this->getTopicWithSensorActuatorID($result_sensor['id']);
						
						array_push($gateway->sensors, $sensor);
					}
				}
				
				array_push($gateways, $gateway);
			}
		}
		
		//error_log( print_R($gateways,TRUE) );
		
		return $gateways;
    }
    
    public function getActuatorsWithSingleTopic() {
	    
	    $topics = array();
	    
		$get_topics = $this->db->prepare("SELECT COUNT(*) as count,T.name,T.id,T.widget_view,A.name as actuator_name FROM topics as T, sensors_actuators as A WHERE T.type='subscribe' AND T.id_sensor_actuator = A.id GROUP BY T.name");
	    $get_topics->execute();
	    
	    if ($get_topics->rowCount() != 0) {

		    $topic_results = $get_topics->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($topic_results as $result)
			{
				if ($result['count'] > 1) continue;
				
			    $topic = new Topic();
			    $topic->id = $result['id'];
				$topic->name = $result['name'];
				$topic->widget_view = $result['widget_view'];
				
				$get_keys = $this->db->prepare("SELECT * FROM table_keys WHERE id_topic = :id_topic");
				$get_keys->bindParam(':id_topic', $result['id'], PDO::PARAM_STR);
			    $get_keys->execute();
			    
			    if ($get_keys->rowCount() != 0) {
		
				    $keys_results = $get_keys->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($keys_results as $key)
					{
						$topic_key = new Topic_Key();
						$topic_key->id = $key['id'];
						$topic_key->name = $key['name'];
						$topic_key->id_topic = $key['id_topic'];
						
						array_push($topic->keys, $topic_key);
					}
				}
				
				$topic_actuator = array();
				$topic_actuator['actuator_name'] = $result['actuator_name'];
				$topic_actuator['topic'] = $topic;
				
				array_push($topics, $topic_actuator);
			}
		}
		
		return $topics;
		 
    }
    
    public function getMultipleSubscribeTopics () {
	    
	    $topics = array();
	    
		$get_topics = $this->db->prepare("SELECT COUNT(*) as count,name,id,widget_view FROM topics WHERE type='subscribe' GROUP BY name");
	    $get_topics->execute();
	    
	    if ($get_topics->rowCount() != 0) {

		    $topic_results = $get_topics->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($topic_results as $result)
			{
				if ($result['count'] < 2) continue;
				
			    $topic = new Topic();
			    $topic->id = $result['id'];
				$topic->name = $result['name'];
				$topic->widget_view = $result['widget_view'];
				
				$get_keys = $this->db->prepare("SELECT * FROM table_keys WHERE id_topic = :id_topic");
				$get_keys->bindParam(':id_topic', $result['id'], PDO::PARAM_STR);
			    $get_keys->execute();
			    
			    if ($get_keys->rowCount() != 0) {
		
				    $keys_results = $get_keys->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($keys_results as $key)
					{
						$topic_key = new Topic_Key();
						$topic_key->id = $key['id'];
						$topic_key->name = $key['name'];
						$topic_key->id_topic = $key['id_topic'];
						
						array_push($topic->keys, $topic_key);
					}
				}
				
				array_push($topics, $topic);
			}
		}
		
		return $topics;
    }
    
    public function getTopicWithSensorActuatorID($id_sensor_actuator) {
	    
	    $topics = array();
	    
		$get_topics = $this->db->prepare("SELECT * FROM topics WHERE id_sensor_actuator = :id_sensor_actuator");
		$get_topics->bindParam(':id_sensor_actuator', $id_sensor_actuator, PDO::PARAM_STR);
	    $get_topics->execute();
	    
	    if ($get_topics->rowCount() != 0) {

		    $topic_results = $get_topics->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($topic_results as $result)
			{
			    $topic = new Topic();
			    $topic->id = $result['id'];
				$topic->name = $result['name'];
				$topic->id_sensor_actuator = $result['id_sensor_actuator'];
				$topic->type = $result['type'];
				$topic->widget_view = $result['widget_view'];
				
				$get_keys = $this->db->prepare("SELECT * FROM table_keys WHERE id_topic = :id_topic");
				$get_keys->bindParam(':id_topic', $result['id'], PDO::PARAM_STR);
			    $get_keys->execute();
			    
			    if ($get_keys->rowCount() != 0) {
		
				    $keys_results = $get_keys->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($keys_results as $key)
					{
						$topic_key = new Topic_Key();
						$topic_key->id = $key['id'];
						$topic_key->name = $key['name'];
						$topic_key->id_topic = $key['id_topic'];
						
						array_push($topic->keys, $topic_key);
					}
				}
				
				array_push($topics, $topic);
			}
		}
		
		return $topics;
    }
    
	/*
	*****************************************
				ADMIN USER FUNCTIONS
	*****************************************
	*/
    
    public function registerUser ($user, $password)
    {	
		$hash = $this->hashSSHA($password);
	    $encrypted_password = $hash["encrypted"]; // encrypted password
	    $salt = $hash["salt"]; // salt
	    $uuid = uniqid('', true);
	    
		$add_user_query = $this->db->prepare("INSERT INTO user (uuid,name,surname,username,encrypted_password,salt) VALUES
															(:uuid,:name,:surname,:username,:encrypted_password,:salt)");
		
		$add_user_query->bindParam(':uuid', $uuid, PDO::PARAM_STR);
		$add_user_query->bindParam(':name', $user->name, PDO::PARAM_STR);
		$add_user_query->bindParam(':surname', $user->surname, PDO::PARAM_STR);
		$add_user_query->bindParam(':username', $user->username, PDO::PARAM_STR);
		$add_user_query->bindParam(':encrypted_password', $encrypted_password, PDO::PARAM_STR);
		$add_user_query->bindParam(':salt', $salt, PDO::PARAM_STR);
		
		$add_user_query->execute();
		
		if ($add_user_query->rowCount() != 0)
		{
			return true;
		}
		
		return false;
    }
    
    public function loginUser ($username,$password)
    {
	    $user_query = $this->db->prepare("SELECT * FROM user WHERE username = :username");
		$user_query->bindParam(':username', $username, PDO::PARAM_STR);
		$user_query->execute();
            
        if ($user_query->rowCount() > 0) {
	        
            $result = $user_query->fetch(PDO::FETCH_ASSOC);
            
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            
            
            if ($encrypted_password == $hash) {

                $user = new User();
                $user->name = $result['name'];
                $user->surname = $result['surname'];
                $user->username = $result['username'];
                
                return $user;
            }
        }
        
        return false;
    }
	/*
		*****************************************
					LOGIN UTILITY FUNCTIONS
		*****************************************
	*/
	
	function hashSSHA($password) {
	    
        $salt = sha1(rand());
        $salt = substr($salt, 0, 20);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
}