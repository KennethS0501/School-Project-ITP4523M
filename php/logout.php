<?php

session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();

header("Location: http://127.0.0.1/ITP4523M_Project/index.php");

?>