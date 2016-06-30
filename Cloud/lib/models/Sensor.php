<?php 

class Sensor {

	public $id;
    public $name;
	public $id_gateway;
	public $topics;
	
    function __construct()
    {  
	    $this->id = 0;
	    $this->name = "";
	    $this->id_gateway = 0;    
	    $this->topics = array();
	}        
}
     
?>