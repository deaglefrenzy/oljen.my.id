<?php
require_once "auth/auth.php";
require_once "config/utils.php";

$page = $_GET['page'] ?? 'members';
$now = date('Y-m-d H:i:s');
$inserted = false;

$admin_id = $_SESSION['admin_id'];
$query = mysqli_query($conn, "SELECT username FROM user WHERE id = $admin_id");
$user = mysqli_fetch_assoc($query);
$login_name = $user['username'];

include "usecases.php";
include "data.php";

if (!isset($date)) {
    $date = $_POST['log_date']
        ?? $_GET['date']
        ?? date('Y-m-d');
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $admin_page_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="views/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="views/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="views/favicon/favicon-16x16.png">
    <link rel="manifest" href="views/favicon/site.webmanifest">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reddit+Sans+Condensed&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/w3v4.css">
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <link rel="stylesheet" href="assets/components.css?v=<?= filemtime('assets/components.css') ?>">
    <link rel="stylesheet" href="assets/layout.css?v=<?= filemtime('assets/layout.css') ?>">
    <link rel="stylesheet" href="assets/stock.css?v=<?= filemtime('assets/stock.css') ?>">
    <script src="assets/autoComplete.js"></script>

</head>

<body>
    <div class="main-container">
        <?php include("views/nav_top.php"); ?>
        <main class="content">
            <div class="content-inner" style="padding-top:40px;">
                <?php
                switch ($page) {
                    case 'members':
                        include("members.php");
                        break;
                    case 'orders':
                        include("orders.php");
                        break;
                    case 'user':
                        include("views/user.php");
                        break;
                    default:
                        include("members.php");
                        break;
                }
                ?>
            </div>
        </main>
    </div>
    <script src="assets/scripts.js"></script>
    <?php include('views/go_to_top.php') ?>
    <?php include("views/modals.php"); ?>
    <?php include('views/nav_bottom.php') ?>
</body>


</html>
