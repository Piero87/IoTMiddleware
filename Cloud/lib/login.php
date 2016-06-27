<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/IoT_Manager.php';

$username = $_POST['username'];
$password = $_POST['password'];
$remember = $_POST['remember'];

if (isset($username) && isset($password) && isset($remember))
{	
	$iot_manager = new IoT_Manager();
	$user = $iot_manager->loginUser($username,$password);
	
	if ($user === false)
	{
		echo false;
		die();
	} 
	
	validateUser($user,$remember);
	
	echo true;
}

function validateUser($user,$remember)
{
	if ($remember == 1) //if the Remember me is checked, it will create a cookie.
	{
		//here we are setting a cookie named username, with the Username on the database that will last 48 hours 
		//and will be set on the understandesign.com domain. This is an optional parameter.
		setcookie("user_name", $user->name, time()+259200, "/", "amazonaws.com");
		setcookie("user_surname", $user->surname, time()+259200, "/", "amazonaws.com");
		setcookie("user_username", $user->username, time()+259200, "/", "amazonaws.com");
	}
	else if ($remember == 0) //if the Remember me isn't checked, it will create a session.
	{
		session_start(); //must call session_start before using any $_SESSION variables
		
		$_SESSION['user_name'] = $user->name;
		$_SESSION['user_surname'] = $user->surname;
		$_SESSION['user_username'] = $user->username;
	}
}
?>