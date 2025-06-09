<?php
require_once "../../cdn/func.php";

setcookie("admin", "notok");
//echo $_COOKIE['admin'];
pergi("adminn.php");
?>

<body>
	<center><br /><br /><br /><br /><br /><br /><br />
		<font color="#000000" size="+3">Logging out...</font>
	</center>
</body>
