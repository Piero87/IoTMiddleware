<?php
session_start(); //start session

//destroy session
session_destroy();

//unset cookies
setcookie("user_name", null, -1, "/", "amazonaws.com");
setcookie("user_surname", null, -1, "/", "amazonaws.com"); 
setcookie("user_username", null, -1, "/", "amazonaws.com");

header ("Location: ../login.php");
exit();
?>