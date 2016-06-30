<?php 

class Gateway {

	public $id;
    public $name;
	public $sensors;
	public $actuators;
	
    function __construct()
    {  
	    $this->id = 0;
	    $this->name = "";
	    $this->sensors = array();
	    $this->actuators = array();
    }        
}
     
?>