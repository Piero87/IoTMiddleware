<?php 

class Topic {

	public $id;
    public $name;
	public $id_sensor_actuator;
	public $type;
	public $keys;
	public $widget_view;
    function __construct()
    {  
	    $this->id = 0;
	    $this->name = "";
	    $this->id_sensor_actuator = 0;
	    $this->type = '';
	    $this->keys = array();
	    $this->widget_view = 0;
    }        
}
     
?>