<?php
require_once "../connection.php";
require_once "../../cdn/func.php";
$judulwebsite = "OLJEN PADEL";
$urlwebsite = "oljen.my.id/padel";
$page = @$_GET['page'];
$admin = @$_COOKIE['admin'];

if (!isset($page) || $page == "") {
    $page = "men";
}
if ($page == "men") {
    $lapangan = "merah";
} else $lapangan = "biru";

$action = @$_POST['action'];
include("usecase.php");

$dis = "";

$q = mysqli_query($conn, "SELECT * FROM padelist ORDER BY id ASC");
while ($gg = mysqli_fetch_array($q)) {
    $nama[$gg['id']] = $gg['name'];
    $team[$gg['id']] = $gg['team'];
    $jk[$gg['id']] = $gg['jk'];
}

$query = "SELECT * FROM pmatch WHERE lapangan = '$lapangan' AND score_a='0' AND score_b='0' ORDER BY `order` ASC LIMIT 1";
$qq = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($qq) != 0) {
    $q = mysqli_fetch_array($qq);
    $runningText = "NEXT MATCH • " . $nama[$q['pa1']] . " & " . $nama[$q['pa2']] . " vs " . $nama[$q['pb1']] . " & " . $nama[$q['pb2']];
} else {
    $runningText = "TERIMA KASIH TELAH BERPARTISIPASI DI MERDEKA TOURNAMENT PADEL OLJEN!";
}
?>
<html>

<head>
    <title><?= $judulwebsite ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="<?= $judulwebsite ?>" />
    <meta property="og:description" content="FUN TOURNAMENT" />
    <meta property="og:url" content="https://<?= $urlwebsite ?>" />
    <meta property="og:image" itemprop="image" content="https://oljen.my.id/images/thumbnail3.jpg" />
    <meta property="og:type" content="website" />

    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/site.webmanifest">

    <link rel="stylesheet" href="select.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reddit+Sans+Condensed&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        @font-face {
            font-family: Lost;
            src: url('../font/Lost in South.otf');
        }

        @font-face {
            font-family: norwester;
            src: url('../font/norwester.otf');
        }

        @font-face {
            font-family: doto;
            src: url('../font/Doto-Regular.ttf');
        }

        html {
            scroll-behavior: smooth;
        }

        html,
        body,
        h2,
        h3,
        h4,
        h5,
        button,
        .reddit {
            font-family: "Reddit Sans Condensed", sans-serif;
            color: #121212;
        }

        h3 {
            color: #2c3e50;
        }

        .whiteshadow {
            color: #fff;
            text-shadow: 2px 2px 4px #000000;
        }

        .judul {
            font-family: "norwester", sans-serif;
            color: #121212;
        }

        .nomor {
            font-family: "Inconsolata", monospace;
            color: #121212;
        }
    </style>
</head>

<body>
    <label id="top"></label>
    <div class="w3-top">
        <div class="w3-bar w3-pale-blue w3-left-align" style="background: linear-gradient(90deg, #fff, #fff);">
            <div style="display: flex; justify-content: space-between;">
                <div class="w3-bar-item w3-padding" style="margin-top: 3px;">
                    <div style="display: flex; justify-content:flex-end;">
                        <div>
                            <img src="../images/logo1.png" style="height: 22px;">
                        </div>
                        <div class="w3-large" style="
                        font-family:Lost;
                        text-align:left;
                        text-shadow: 1px 1px 0 #000, -1px 1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000; color: #fff;">
                            PADEL
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content:flex-end;">
                    <div>
                        <a href="https://oljen.my.id/padel/adminn.php" class="w3-bar-item w3-button w3-center w3-hover-blue" title="Refresh">
                            <div style="display: flex; flex-direction:column; width: 30px;">
                                <div><i class="fa-solid fa-user-tie"></i></div>
                                <div class="w3-tiny">Admin</div>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="https://oljen.my.id/padel/?page=<?= $page ?>" class="w3-bar-item w3-button w3-center w3-hover-blue" title="Refresh">
                            <div style="display: flex; flex-direction:column; width: 30px;">
                                <div><i class="fa-solid fa-rotate"></i></div>
                                <div class="w3-tiny">Refresh</div>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="#top" class="w3-bar-item w3-button w3-center w3-hover-blue" title="Top">
                            <div style="display: flex; flex-direction:column; width: 30px;">
                                <div><i class="fa-solid fa-arrows-up-to-line"></i></div>
                                <div class="w3-tiny">Top</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="w3-container w3-content" style="max-width:1400px; margin-top:80px;">
        <!-- The Grid -->
        <div class="w3-row">
            <!-- Left Column -->
            <aside class="w3-col m3">
                <div class="w3-center" style="margin-bottom: 32px;">
                    <div align="center">
                        <img src="../images/padel.png" width="300">
                    </div>
                    <div class="w3-large" align="center" style="color: #fff;
                    text-shadow: 2px 2px 4px #000000, 1px 1px 0 #000, -1px 1px 0 #000, 1px -1px 0 #000, -1px -1px 0 #000;">
                        Minggu, 17 Agustus 2025
                    </div>
                </div>

                <div style="display: flex; justify-content: space-evenly; align-items: center;">
                    <div class="w3-round">
                        <button class="cool-button w3-blue w3-hover-white" onclick="window.location.href = '?page=men';" style="width: 120px;">
                            <i class="fa-solid fa-mars icon"></i> MEN
                        </button>
                    </div>
                    <div class="w3-round">
                        <button class="cool-button w3-pink w3-hover-white" onclick="window.location.href = '?page=women';" style="width: 120px;">
                            <i class="fa-solid fa-venus icon"></i> WOMEN
                        </button>
                    </div>
                </div>
                <br>
                <?php
                if ($page == "women") $col = "w3-pink";
                else $col = "w3-blue";
                ?>
                <div class="w3-card <?= $col ?> w3-padding-large" style="width:100%;">
                    <div class="w3-center w3-xlarge whiteshadow" style="color:#fff; font-family: 'norwester', sans-serif;">
                        <i class="fa-solid fa-trophy icon" style="color: gold;"></i> <?= strtoupper($page) . "'S" ?> TOURNAMENT
                    </div>
                </div>
                <br>
                <?php include("klasemen.php"); ?>
            </aside>
            <!-- End Left Column -->

            <!-- Middle Column -->
            <div class="w3-col m6 w3-center">
                <div class="w3-row-padding">
                    <div class="w3-col m12">
                        <div class="marquee">
                            <div class="marquee-text">
                                <?= $runningText ?>
                            </div>
                        </div>
                        <br>
                        <div class="w3-card w3-round w3-white">
                            <?php
                            include("entry.php");
                            ?>
                        </div>
                        <br>
                        <div class="w3-card w3-round w3-white">
                            <?php
                            include("input.php");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Middle Column -->

            <!-- Right Column -->

            <!-- End Right Column -->
            <br>
        </div>
        <div align=center>
            <img src="../images/oljenpadellogo.png" style="width: 100%; height:300px; object-fit: cover; object-position: 0 40px; position:relative;">
        </div>
        <!-- End Grid -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
        </div>
        <div class='box' style="z-index: -1;">
            <div class='wave -one'></div>
            <div class='wave -two'></div>
            <div class='wave -three'></div>
        </div>
    </main>
    <!-- End Page Container -->
    <footer class="w3-container w3-bottom" style="background: linear-gradient(90deg, #fff, #fff);">
        <div style="display: flex; justify-content:space-between; margin: 4px 10px 4px 10px;">
            <div style="text-align: right;" class="w3-hover-blue">
                <a href="https://instagram.com/oljen.cc" target="_blank" style="text-decoration:none;">
                    &nbsp;&nbsp;&nbsp;<i class="fa-brands fa-instagram"></i> oljen.cc&nbsp;&nbsp;&nbsp;
                </a>
            </div>
            <div class="w3-hover-blue">
                <a href="https://instagram.com/suryo" target="_blank" style="text-decoration:none;">
                    &nbsp;&nbsp;&nbsp;<i class="fa-brands fa-instagram"></i> suryo&nbsp;&nbsp;&nbsp;
                </a>
            </div>
        </div>
    </footer>
</body>


</html>

<script src="select.js"></script>

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
