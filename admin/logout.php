<?php
require_once "../config/utils.php";

session_start();
session_destroy();
?>

<body>
	<center><br /><br /><br /><br /><br /><br /><br />
		<font color="#000000" size="+3">Logging out...</font>
	</center>
</body>
<?php
pergi("index.php");
exit;
?>
