<?php
require_once 'config/website.php';
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/main.css">
</head>

<body>
    <div class="main-container">
        <div class="content w3-container" style="max-width:500px; margin:auto;">
            <div class="w3-center">
                <img src="views/oslogo.png" alt="Logo" class="w3-image w3-margin-top"
                    style="width: 150px; height: auto;">
            </div>
            <h3 class="w3-center w3-xlarge w3-margin-top">
                <b><?= $admin_page_title ?></b>
            </h3>
            <div class="w3-padding-16 w3-round-xlarge">
                <form action="auth/login.php" method="post" autocomplete="off">
                    <p>
                        <input type="text" name="username" class="w3-input w3-border w3-round-large w3-large"
                            placeholder="Username" required onfocus="this.select()">
                    </p>
                    <br>
                    <p>
                        <input type="password" name="password" class="w3-input w3-border w3-round-large w3-large"
                            placeholder="Password" required onfocus="this.select()">
                    </p>
                    <p class="w3-margin-top">
                        <button type="submit" name="action" value="logadmin" class="button w3-large">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
