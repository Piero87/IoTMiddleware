<?php 

class Rule {

	public $id;
    public $id_topic;
    public $topic_name;
	public $id_key;
	public $key_name;
	public $condition_type;
	public $condition_value;
	public $hold_timer;
	public $id_topic_result;
	public $topic_name_result;
	public $id_key_result;
	public $key_name_result;
	public $key_type_result;
	public $key_value_result;
	
	
    function __construct()
    {  
		$this->id = 0;
		$this->id_topic = 0;
		$this->topic_name = '';
		$this->id_key = 0;
		$this->key_name = '';
		$this->condition_type = 'none';
		$this->condition_value = 0;
		$this->hold_timer = 0;
		$this->id_topic_result = 0;
		$this->topic_name_result = '';
		$this->id_key_result = 0;
		$this->key_name_result = '';
		$this->key_type_result = 'none';
		$this->key_value_result = '';
    }        
}
     
?>