<?php
require_once "../../cdn/func.php";
$pass = @$_POST['pass'];
$action = @$_POST['action'];

if ($action == "logadmin") {
	if ($pass == "suryooo") {
		setcookie("admin", "ok");
	}
	pergi("adminn.php");
} else pergi("adminn.php");
