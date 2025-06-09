<?php
require_once "../../cdn/func.php";
require_once "../connection.php";
$pass = @$_POST['pass'];
$action = @$_POST['action'];

if ($action == "logadmin") {
	$query = "SELECT * FROM user WHERE username='admin' AND password = '$pass'";
	//echo $query;
	$q = mysqli_query($conn, $query) or die(mysqli_error($conn));
	if (mysqli_num_rows($q) > 0) {
		setcookie("admin", "ok");
		pergi("https://oljen.my.id/padel/");
	} else {
		pergi("adminn.php");
	}
} else pergi("adminn.php");
