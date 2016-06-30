<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/login_functions.php';
 
if (!isLogged())
{
header ("Location: login.php");
exit();
}
?>