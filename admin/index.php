<?php
include '../config/website.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $admin_page_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../config/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

</head>

<body>
    <div class="main-container">
        <div class="content">
            <div class="content-inner">
                <h1 class="w3-center"><?= $admin_page_title ?></h1>
                <div class="card">
                    <form action="login.php" method="post">
                        <!-- <div>
                            <input type="text" name="username" size="12" style="border:2px solid #000;" class="w3-xxlarge" placeholder="Username" />
                        </div> -->
                        <div>
                            <input type="password" name="password" size="12" style="border:2px solid #000;" class="w3-xxlarge" placeholder="Password" />
                        </div>
                        <div>
                            <button type="submit" name="action" value="logadmin" class="button w3-xlarge">Login Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
