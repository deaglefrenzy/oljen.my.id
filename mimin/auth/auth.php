<?php
session_start();
if (empty($_SESSION['is_admin'])) {
    header("Location: index.php");
    exit;
}
require_once "connection.php";
