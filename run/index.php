<?php
require_once "../connection.php";
require_once "../../cdn/func.php";
$judulwebsite = "OLJEN RUN KMC";
$urlwebsite = "oljen.my.id/run";
$p = @$_GET['p'];

$action = @$_POST['action'];
if ($action == "inputride") {
    $waktu = date('Y-m-d H:i:s');
    $stravalink = $_POST['link'];
    $idorang = $_POST['idorang'];
    preg_match('#https?://\S+#i', $stravalink, $matches);
    $link = $matches[0] ?? null;
    $word = "/shareable_images";
    if (strpos($link, $word)) $link = strstr($link, "/shareable_images", true);

    if (!empty($stravalink)) {
        if ($link) {
            $v = mysqli_query($conn, "SELECT * FROM runs WHERE orang_id='$idorang' AND link='$link'");
            if (mysqli_num_rows($v) == 0) {
                mysqli_query($conn, "INSERT INTO runs SET input_time='$waktu', orang_id='$idorang', link='$link', raw='$stravalink'");
?>
                <dialog open>
                    <p>Setoran terinput dan akan direview terlebih dahulu.</p>
                    <center>
                        <form method="dialog">
                            <button class="cool-button" onclick="myFunction('Demo<?php echo $idorang; ?>')">OK</button>
                        </form>
                    </center>
                </dialog>
<?php
            } else pesan("Ride ini sudah terinput sebelumnya.");
        } else pesan("Inputan harus mempunyai link ke aktivitas Strava");
    } else pesan("Link menuju ride STRAVA Anda tidak boleh kosong!");
}

$dis = "";
$state = "";
$now = strtotime(date("Y-m-d"));
$date1 = strtotime("2025-05-14");
$date2 = strtotime("2025-05-28");
$diff = ($now - $date1) / (60 * 60 * 24);
$numday = floor($diff) + 1;

if ($now <= $date2) {
    $state = "event";
    $judultime = "Waktu Tersisa";
} else {
    $state = "after";
    $dis = "disabled";
    $judultime = "Challenge Selesai. <br>Terima Kasih Sudah Berpartisipasi.";
}

$que = "SELECT * FROM runner ORDER BY name ASC";
$q = mysqli_query($conn, $que) or die(mysqli_error($conn));

$result = mysqli_query($conn, "SELECT COUNT(DISTINCT runner.id) AS total FROM runner JOIN runs ON runner.id = runs.orang_id WHERE runs.distance > 0");
$jumrider = mysqli_fetch_assoc($result)['total'];

$e = mysqli_fetch_array(mysqli_query($conn, "SELECT *,sum(distance) as kolektif FROM runs"));
$kmkolektif = $e['kolektif'];

$ee = mysqli_query($conn, "SELECT id FROM runs WHERE distance!='0'");
$totalRuns = mysqli_num_rows($ee);

$e = mysqli_fetch_array(mysqli_query($conn, "SELECT updatedAt FROM runner WHERE id='1'"));
$updatedAt = $e['updatedAt'];
?>
<html>

<head>
    <title><?= $judulwebsite ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="<?= $judulwebsite ?>" />
    <meta property="og:description" content="RUN Kilometer Challenge 2025" />
    <meta property="og:url" content="https://<?= $urlwebsite ?>" />
    <meta property="og:image" itemprop="image" content="https://oljen.my.id/thumbnail2.png" />
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

        .roadto {
            color: #fff;
            font-family: Lost;
            text-shadow: 2px 2px 4px #000000,
                1px 1px 0 #000,
                -1px 1px 0 #000,
                1px -1px 0 #000,
                -1px -1px 0 #000;
            /* filter: drop-shadow(2px 2px #000);
            background-image: linear-gradient(90deg, white, red);
            -webkit-background-clip: text;
            -moz-background-clip: text;
            background-clip: text;
            color: transparent; */
        }

        .jersey {
            margin-bottom: 48px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 1) 15%, rgba(255, 217, 0, 1) 100%);
        }
    </style>
</head>

<?php
function runKM($nilai)
{
    $parts = explode(',', number_format($nilai, 1, ",", "."));
    $hasil = "<font style='font-family: Inconsolata;'>" . $parts[0] . "</font>";
    $hasil .= "<font style='font-family: Reddit Sans Condensed;'>,</font>";
    $hasil .= "<font style='font-family: Inconsolata;'>" . $parts[1] . "</font>";
    return $hasil;
}
?>

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
                        <div class="w3-large w3-text-white" style="
                        font-family:Lost;
                        text-align:left;
                        text-shadow: 1px 1px 0 #000, -1px 1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000;">
                            <font class="w3-text-orange">RUN</font> KMC
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content:flex-end;">
                    <div>
                        <a href="https://oljen.my.id/run" class="w3-bar-item w3-button w3-center w3-hover-blue" title="Refresh">
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
                        <img src="../images/runkmc.png" width="300">
                    </div>
                    <div class="w3-xxlarge roadto" align="center">
                        Kilometer Challenge
                    </div>
                    <div class="w3-large" align="center" style="color: #fff;
                    text-shadow: 2px 2px 4px #000000, 1px 1px 0 #000, -1px 1px 0 #000, 1px -1px 0 #000, -1px -1px 0 #000;">
                        14 - 28 Mei 2025
                    </div>
                </div>
                <div class="w3-card w3-white" style="margin-bottom: 48px; border-radius: 20px;">
                    <div class="w3-container">
                        <h2 class="w3-center judul w3-text-orange">
                            Finisher Jersey
                        </h2>
                        <div class="w3-center judul w3-text-white">
                            <img src="../images/runkmcjersey.png" style="width: 90%;">
                        </div>
                        <!--
                        <p class="w3-center">
                            <img src="../images/jerseynobg.png" class="thumbnail" alt="Zoom">
                        </p>
                        <div style="margin-top: -30px;">
                            <i class="fa-solid fa-magnifying-glass-plus w3-right w3-opacity w3-xlarge"></i>
                        </div>
                        -->
                    </div>
                </div>

                <?php
                $c = 0;
                $g = mysqli_query($conn, "SELECT * FROM runner ORDER BY name");
                while ($gg = mysqli_fetch_array($g)) {
                    $c++;
                    $num[$gg['id']] = $c;
                }

                ?>
                <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
                    <div class="w3-container w3-center">
                        <table width=90% align="center" style="border-collapse: collapse; margin-bottom:8px;">
                            <tr>
                                <td class="judul">
                                    <i class="fa-solid fa-forward-fast buttonicon"></i> Shortcut
                                </td>
                            </tr>
                        </table>
                        <input list="options" id="searchInput" placeholder="Ketik nama Oljener">
                        <datalist id="options">
                            <?php
                            $count = 0;
                            $g = mysqli_query($conn, "SELECT * FROM runner ORDER BY name");
                            while ($gg = mysqli_fetch_array($g)) {
                                $count++;
                                $gocount = $num[$gg['id']];
                                $name = $gg['name'];
                            ?>
                                <option
                                    value="<?php echo $name; ?>"
                                    data-url="#row<?= $gocount ?>"
                                    data-id="<?php echo $gg['id']; ?>">
                                <?php
                            }
                                ?>
                        </datalist>
                    </div>

                    <script>
                        const input = document.getElementById('searchInput');
                        const datalist = document.getElementById('options');

                        input.addEventListener('input', function() {
                            const selectedOption = Array.from(datalist.options).find(
                                option => option.value === input.value
                            );

                            if (selectedOption) {
                                const selectedId = selectedOption.getAttribute('data-id');
                                myFunction('Demo' + selectedId);
                                window.location.href = selectedOption.getAttribute('data-url');
                            }
                        });
                    </script>
                </div>
                <?php
                $r = mysqli_query($conn, "SELECT o.*, SUM(r.distance) AS tot FROM runner o JOIN runs r ON o.id = r.orang_id GROUP BY o.id HAVING tot > 99 ORDER BY o.finish ASC") or die(mysqli_error($conn));
                if (mysqli_num_rows($r) > 0) {
                ?>
                    <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
                        <div class="w3-container w3-center">
                            <h2 class="judul w3-text-red">
                                <i class="fa-solid fa-flag-checkered"></i> 100km Finishers
                            </h2>
                            <table width=80% align="center" style="border-collapse: collapse;">
                                <?php
                                $count = 0;
                                while ($rr = mysqli_fetch_array($r)) {
                                    $nama = $rr['name'];
                                    $count++;
                                    $gocount = $num[$rr['id']];
                                    $finishdiff = strtotime($rr['finish']) - $date1;
                                    $dayfinish = floor($finishdiff / (60 * 60 * 24)) + 1;
                                ?>
                                    <tr>
                                        <td align="left">
                                            <b><?= $count . "." ?></b>
                                        </td>
                                        <td align="left">
                                            <a href="#row<?= $gocount ?>" onclick="myFunction('Demo<?php echo $rr['id']; ?>')"><?= $nama ?></a>
                                        </td>
                                        <td align="right" class="nomor w3-large">
                                            <?php echo $dayfinish ?> <font class="w3-tiny reddit">hari</font>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3" align="center">...</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
                    <div class="w3-container">
                        <?php
                        $r = mysqli_query($conn, "SELECT id, orang_id, SUM(distance) AS tot FROM runs GROUP BY orang_id ORDER BY tot DESC LIMIT 10") or die(mysqli_error($conn));
                        if (mysqli_num_rows($r) > 0) {
                        ?>
                            <br>
                            <table width=80% align="center" style="border-collapse: collapse; margin-bottom:8px;">
                                <tr>
                                    <td class="w3-large judul">
                                        <i class="fa-solid fa-person-running buttonicon"></i> Top Runners
                                    </td>
                                </tr>
                            </table>
                            <table width=80% align="center" style="border-collapse: collapse;">
                                <?php
                                $count = 0;
                                while ($rr = mysqli_fetch_array($r)) {
                                    $idorang = $rr['orang_id'];
                                    $n = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM runner WHERE id='$idorang'"));
                                    $nama = $n['name'];
                                    $count++;
                                    $gocount = $num[$idorang];
                                ?>
                                    <tr>
                                        <td align="left">
                                            <b><?= $count . "." ?></b>
                                        </td>
                                        <td align="left">
                                            <a href="#row<?= $gocount ?>" onclick="myFunction('Demo<?php echo $idorang; ?>')"><?= $nama ?></a>
                                        </td>
                                        <td align="right" class="nomor w3-large">
                                            <?= runKM($rr['tot']) ?> <font class="w3-tiny reddit">km</font>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } ?>
                        <br>
                        <table width=80% align="center" style="border-collapse: collapse; margin-bottom:8px;">
                            <tr>
                                <td class="w3-large judul">
                                    <i class="fa-solid fa-road buttonicon"></i> Single Run Terjauh
                                </td>
                            </tr>
                        </table>
                        <?php
                        $r = mysqli_query($conn, "SELECT * FROM runner, runs WHERE runner.id=runs.orang_id ORDER BY runs.distance DESC LIMIT 5") or die(mysqli_error($conn));
                        if (mysqli_num_rows($r) > 0) {
                        ?>
                            <table width=80% align="center" style="border-collapse: collapse; margin-bottom:8px;">
                                <?php
                                $count = 0;
                                while ($rr = mysqli_fetch_array($r)) {
                                    $nama = $rr['name'];
                                    $link = $rr['link'];
                                    $count++;
                                ?>
                                    <tr>
                                        <td align="left">
                                            <b><?= $count . "." ?></b>
                                        </td>
                                        <td align="left">
                                            <?= $nama ?>
                                        </td>
                                        <td align="right" class="nomor w3-large">
                                            <a href="<?= $link ?>" target="_blank"><?= runKM($rr['distance']) ?> <font class="w3-tiny reddit">km</font></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else echo "<center>-</center>";
                        ?>
                        <br>
                        <table width=80% align="center" style="border-collapse: collapse; margin-bottom:8px;">
                            <tr>
                                <td class="w3-large judul">
                                    <i class="fa-solid fa-people-group buttonicon"></i> Jarak Kolektif
                                </td>
                            </tr>
                            <tr>
                                <td class="w3-xxlarge nomor">
                                    <?= runKM($kmkolektif) ?><font class="w3-large w3-center"> km</font>
                                    <font class="w3-medium" style="font-family: Reddit Sans Condensed;">
                                        <br>
                                        dari <font class="nomor w3-large"><?= $totalRuns ?></font> activity
                                        <br>
                                        oleh <font class="nomor w3-large"><?= $jumrider ?></font> Oljeners
                                    </font>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div>
                </div>
            </aside>
            <!-- End Left Column -->

            <!-- Middle Column -->
            <div class="w3-col m6 w3-center">
                <div class="w3-container">
                    <div class="w3-center w3-padding w3-xxxlarge roadto" style="line-height: 45px;">
                        ROAD <font class="w3-xxlarge">TO</font>
                        <font class="w3-text-green">5O</font>/<font class="w3-text-orange">75</font>/<font class="w3-text-red">1OO</font>
                        <font class="w3-xlarge">km</font>
                    </div>
                    <h1 class="w3-center judul whiteshadow w3-text-white">
                        DAY <font class="w3-text-blue"><?= $numday ?></font> / 15
                    </h1>
                    <?php
                    $ha = $harifullchar[date("N", strtotime($updatedAt))];
                    $tg = date("d", strtotime($updatedAt));
                    $bl = $bulan3char[date("n", strtotime($updatedAt))];
                    $str = "$ha, $tg $bl " . date("H:i", strtotime($updatedAt));
                    ?>
                    Last update : <?= $str ?>
                </div>
                <br>
                <div class="w3-row-padding">
                    <div class="w3-col m12">
                        <div class="w3-card w3-round w3-white">
                            <?php
                            include("entry.php");
                            ?>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <!-- End Middle Column -->

            <!-- Right Column -->

            <!-- End Right Column -->
            <br>
        </div>
        <div align=center>
            <img src="../images/olo.png">
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
