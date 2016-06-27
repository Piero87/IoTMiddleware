<?php
session_start(); //must call session_start before using any $_SESSION variables

//login chech function
function isLogged()
{
	$isLogged = FALSE;
	
	if (isset($_SESSION['user_username']) || isset($_COOKIE['user_username']))
	{
		$isLogged = TRUE;
	}
	
	return $isLogged;
}