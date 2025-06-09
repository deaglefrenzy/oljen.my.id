<?php
require_once "connection.php";
require_once "../cdn/func.php";

$id = @$_GET['id'];
$type = @$_GET['type'];
if (!$type) {
    $type = "rides";
    $orang = "orang";
} else {
    $orang = "runner";
}

$que = "SELECT * FROM $orang WHERE id='$id'";
$u = mysqli_fetch_array(mysqli_query($conn, $que));
$nama = $u['name'];
?>
<html>

<head>
    <title>History KMC <?php $nama; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reddit+Sans+Condensed&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        button {
            font-family: "Reddit Sans Condensed", sans-serif;
            color: #121212;
        }
    </style>
</head>

<body>
    <h3 align=center>
        History KMC <?= $nama ?>
    </h3>
    <table width=90% align="center" style="border-collapse: collapse;">
        <?php
        $que = "SELECT * FROM $type WHERE orang_id='$id' ORDER BY input_time ASC";
        $r = mysqli_query($conn, $que) or die(mysqli_error($conn));
        $count = 0;
        $rawData = [];
        while ($rr = mysqli_fetch_array($r)) {
            $date = date('Y-m-d', strtotime($rr['input_time']));
            $rawData[] = array($date, $rr['distance']);
            $count++;
            if ($count < 10) $counts = "0" . $count;
            else $counts = $count;
        ?>
            <tr>
                <td align="left">
                    <b><?= $counts . "." ?></b>
                </td>
                <td align="left">
                    <a href="<?= $rr['link'] ?>" target="_blank">
                        <img src="images/strava.svg" style="width: 15px;">
                    </a>
                </td>
                <td align="left">
                    <a href="<?= $rr['link'] ?>" target="_blank">
                        <?php
                        $time = $rr['input_time'];
                        $hari = array("", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
                        $ha = $hari[date("N", strtotime($time))];
                        echo $ha . "&nbsp;";
                        echo date("d", strtotime($time));
                        echo " <font class=w3-small>" . date("M Y", strtotime($time)) . "</font>";
                        ?>
                    </a>
                </td>
                <td align="right">
                    <?php
                    if ($rr['distance'] == 0) {
                    ?>
                        <div style="display: flex; font-family:monospace; line-height:8px; justify-content:flex-end;">
                            <div style="margin-top:2px; margin-right:3px;"><i class='fa-solid fa-circle-pause'></i></div>
                            <div style="display: flex; flex-direction:column; text-align:left;" class="w3-tiny">
                                <div>ADMIN&#10003;</div>
                                <div>REVIEW</div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <font class="w3-large"><?= $rr['distance'] ?></font>
                        <font class="w3-small">km</font>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
