<?php
require_once "../config/connection.php";
require_once "../config/utils.php";
$action = @$_POST['action'];

session_start();

if ($action == "logadmin") {

	// $username = $_POST['username'];
	$username = "admin";
	$pass     = $_POST['password'];

	$stmt = mysqli_prepare($conn, "
        SELECT id, password
        FROM user
        WHERE username = ?
        LIMIT 1
    ");

	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($result)) {
		// Verify hashed password
		if (password_verify($pass, $row['password'])) {

			$_SESSION['admin_id'] = $row['id'];
			$_SESSION['is_admin'] = true;

			// Optional: regenerate session ID
			session_regenerate_id(true);
			pergi("master.php");
		} else {
			pergi('index.php');
		}
	} else {
		pergi('index.php');
	}
}
