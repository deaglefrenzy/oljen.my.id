<?php
require_once "config/connection.php";
require_once "config/utils.php";
include_once "data.php";

$category = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 1;
?>
<html>

<head>
    <title><?= $website_name ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="<?= $website_name ?>" />
    <meta property="og:description" content="<?= $description ?>" />
    <meta property="og:url" content="https://<?= $urlwebsite ?>" />
    <meta property="og:image" itemprop="image" content="https://<?= $urlwebsite ?>/images/thumbnail.png" />
    <meta property="og:type" content="website" />

    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">

    <link rel="stylesheet" href="config/w3v4.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reddit+Sans+Condensed&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;900&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="config/main.css?v=<?= filemtime('config/main.css') ?>">
    <link rel="stylesheet" href="config/select.css?v=<?= filemtime('config/select.css') ?>">
    <style>
        :root {
            --c1: <?= $color1 ?>;
            --c2: <?= $color2 ?>;
            --c3: <?= $color3 ?>;
            --c4: <?= $color4 ?>;
            --c5: <?= $color5 ?>;
            --c6: <?= $color6 ?>;
        }
    </style>
</head>

<body class="bg1">
    <label id="top"></label>
    <?php include('nav.php') ?>
    <div style="height: 50px;"></div>
    <?php
    $page = $_GET['page'] ?? 'home';

    $currentDate = date('Y-m-d');
    $startDate = '2026-04-12';
    $endDate   = '2026-04-26';

    $is_available = ($currentDate >= $startDate && $currentDate <= $endDate);

    switch ($page) {
        case 'klasemen':
            include 'klasemen.php';
            break;

        case 'setor':
            include 'setor.php';
            break;

        default:
            include 'home.php';
    }
    ?>

    <!-- End Page Container -->
    <footer style="margin-top: 50px; margin-bottom: 10px;">
        <div class="w3-center w3-text-light-grey w3-small">
            2026
            &nbsp;
            <a href="https://instagram.com/suryo" target="_blank" style="text-decoration:none;">
                @suryo
            </a>
        </div>
    </footer>

    <script src="config/scripts.js"></script>
    <script src="config/select.js"></script>

    <script>
        // Store scroll position before form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                localStorage.setItem('scrollPos', window.scrollY);
            });

            // Restore scroll position after page reload
            const scrollPos = localStorage.getItem('scrollPos');
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                localStorage.removeItem('scrollPos');
            }
        });
    </script>
</body>


</html>
