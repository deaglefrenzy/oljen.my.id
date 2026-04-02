<?php
require_once "../config/utils.php";
require_once "../config/connection.php";
include_once "usecases.php";
include_once "../data.php";
session_start();

if (empty($_SESSION['is_admin'])) {
    header("Location: index.php");
    exit;
}

$success = false;
$error = @$_GET['error'];
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $admin_page_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../config/w3v4.css">
    <link rel="stylesheet" href="../config/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="logo"><?= $admin_page_title ?></div>

            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="hamburger">&#9776;</label>

            <ul class="nav-links">
                <a href="?page=rides">🚲RIDES</a>
                <a href="?page=orang">👤ORANG</a>
                <a href="logout.php">🗝️LOGOUT</a>
            </ul>
        </nav>

        <main class="content">
            <div class="content-inner">
                <?php
                switch (@$_GET['page']) {
                    case 'orang':
                        include("orang.php");
                        break;
                    default:
                        include("rides.php");
                        break;
                }
                ?>
            </div>
        </main>
    </div>
    <script src="../config/scripts.js"></script>
</body>

</html>
