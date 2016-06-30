<?php 
class User {

	public $uuid;
    public $name;
	public $surname;
	public $username;
	
    function __construct()
    {  
	    $this->uuid = "";
	    $this->name = "";
		$this->surname = "";
		$this->username = "";
    }        
}
     
?>