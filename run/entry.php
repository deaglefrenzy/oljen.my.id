<?php
$query = "
SELECT
    orang.*,
    COALESCE(stats.total_distance, 0) AS total_distance,
    COALESCE(stats.max_distance, 0) AS max_distance,
    COALESCE(stats.min_distance, 0) AS min_distance,
    COALESCE(stats.ride_count, 0) AS ride_count,
    latest_ride.distance AS last_ride_distance,
    latest_ride.input_time AS last_ride_time
FROM orang
LEFT JOIN (
    SELECT
        orang_id,
        SUM(distance) AS total_distance,
        MAX(distance) AS max_distance,
        MIN(distance) AS min_distance,
        COUNT(*) AS ride_count,
        MAX(input_time) AS max_time
    FROM runs
    WHERE deleted_at IS NULL
    GROUP BY orang_id
) AS stats ON orang.id = stats.orang_id
LEFT JOIN runs AS latest_ride ON latest_ride.orang_id = stats.orang_id
    AND latest_ride.input_time = stats.max_time
    AND latest_ride.deleted_at IS NULL
WHERE orang.running = 1
ORDER BY orang.run_finish IS NULL, orang.run_finish ASC, total_distance DESC, orang.name ASC;
";

$result = mysqli_query($conn, $query);

$entries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $entries[] = $row;
}

$count = 0;
foreach ($entries as $qq) {
    $name = $qq['name'];
    $total = round($qq['total_distance'], 1);
    $idorang = $qq['id'];
    $count++;
    $space = "&nbsp;";
    if ($count < 10)
        $space = "&nbsp;&nbsp;";
    $percent = min(($total / 100) * 100, 100);
    $sisa = 100 - $total;
    $jumlahRide = $qq['ride_count'];
    $furthestDistance = round($qq['max_distance'], 1);
    $shortestDistance = round($qq['min_distance'], 1);
    $rataRata = ($qq['ride_count'] > 0) ? round(($qq['total_distance'] / $qq['ride_count']), 1) : 0;
    if ($total < 50) {
        $menujuDiskon = 50 - $total;
        $diskon = "-" . desimal($menujuDiskon, 1) . unit('km');
    } else {
        $calc_dist = min($total, 100);
        $diskon_value = floor($calc_dist - 50) * 2;
        $diskon = unit('Rp') . ribuan($diskon_value) . unit('rb');
    }
    ?>
    <div class="w3-card w3-round" id="<?= "row" . $count ?>">

        <div id="<?php echo $idorang; ?>"></div>

        <button onclick="myFunction('Demo<?php echo $idorang; ?>')" class="w3-button w3-block w3-left-align w3-padding progress-btn
    <?php echo ($total < 1000) ? 'entry' : 'finish'; ?>" style="--progress: <?= $percent ?>%;">

            <div class="progress-fill"></div>

            <div class="w3-row w3-align-middle">

                <!-- Left: Rank + Name -->
                <div class="w3-col s7">
                    <div class="w3-medium reddit" style="padding-top:5px;">
                        <?= $count . ". " . $space . "&nbsp;" . $name; ?>
                    </div>
                </div>

                <!-- Right: Distance -->
                <div class="w3-col s4 w3-right-align">
                    <div class="w3-xlarge">
                        <?= desimal($total, 1) . unit('km', 'small') ?>
                    </div>
                </div>

                <!-- Caret -->
                <div class="w3-col s1 w3-center" id="caret-<?php echo $idorang; ?>" style="padding-top:10px;">
                    <i class="fa-solid fa-caret-down w3-small"></i>
                </div>

            </div>

        </button>
    </div>
    <div id="Demo<?php echo $idorang; ?>" class="w3-hide w3-container w3-padding-16 w3-white w3-card"
        style="margin-top: -10px; margin-bottom: 10px;">
        <div class="w3-padding-small">
            <div class="w3-padding">

                <!-- Header (Name + Strava) -->
                <div class="w3-row w3-margin-bottom" style="align-items:center;">

                    <div class="w3-col s9 font2 w3-medium" style="display:flex; align-items:center;">
                        <img src="images/olo.png"
                            style="height:20px; margin-right:6px; margin-top:-3px; vertical-align:middle;">
                        <?= $name ?>
                    </div>

                    <?php if ($qq['profile']) { ?>
                        <div class="w3-col s3 w3-right-align">
                            <a href="<?= $qq['profile'] ?>" target="_blank" style="text-decoration:none;">
                                <img src="images/strava.svg" style="width:22px;" alt="Profil Strava">
                            </a>
                        </div>
                    <?php } ?>

                </div>

                <!-- Main Stats -->
                <div class="w3-row w3-center w3-margin-bottom">

                    <!-- <div class="w3-col s4">
                        <div class="w3-xlarge"><?= $jumlahRide ?></div>
                        <div class="w3-small w3-opacity">
                            Ride<?= ($jumlahRide > 1) ? "s" : "" ?>
                        </div>
                    </div> -->

                    <div class="w3-col s4">
                        <div class="w3-xlarge"><?= desimal($total, 1) . unit('km', 'small') ?></div>
                        <div class="w3-small w3-opacity">Ditempuh</div>
                    </div>

                    <div class="w3-col s4">
                        <div class="w3-xlarge w3-text-red"><?= $diskon ?></div>
                        <div class="w3-small w3-opacity">Diskon</div>
                    </div>

                    <div class="w3-col s4">
                        <div class="w3-xlarge w3-text-green">
                            <?php
                            if ($total >= 50) {
                                echo unit('Rp', 'small') . ribuan(100 - $diskon_value) . unit('rb', 'small');
                            } else
                                echo "-";
                            ?>
                        </div>
                        <div class="w3-small w3-opacity">Nilai Tebus</div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="w3-border-top w3-margin bottom" style="opacity:0.5;"></div>

                <!-- Secondary Stats -->
                <div class="w3-row w3-center">

                    <div class="w3-col s4">
                        <div class="w3-large"><?= desimal($furthestDistance, 1) . unit('km', 'small') ?></div>
                        <div class="w3-small w3-opacity">Terjauh</div>
                    </div>

                    <div class="w3-col s4">
                        <div class="w3-large"><?= desimal($shortestDistance, 1) . unit('km', 'small') ?></div>
                        <div class="w3-small w3-opacity">Terdekat</div>
                    </div>

                    <div class="w3-col s4">
                        <div class="w3-large"><?= desimal($rataRata, 1) . unit('km', 'small') ?></div>
                        <div class="w3-small w3-opacity">Rata-Rata</div>
                    </div>

                </div>

            </div>
            <br>
            <table class="w3-table w3-small" style="width:95%; margin:auto;">

                <?php
                $que = "SELECT * FROM runs WHERE orang_id='$idorang' AND deleted_at IS NULL ORDER BY input_time ASC";
                $r = mysqli_query($conn, $que) or die(mysqli_error($conn));
                $rcount = 0;

                while ($rr = mysqli_fetch_array($r)) {

                    $time = $rr['input_time'];
                    $date = date('Y-m-d', strtotime($time));

                    $rcount++;
                    $rcounts = str_pad($rcount, 2, "0", STR_PAD_LEFT);

                    $hari = ["", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
                    ?>

                    <tr class="w3-border-bottom">

                        <!-- No -->
                        <td style="width:35px; vertical-align: middle;">
                            <div style="display:flex; align-items:center; height:100%;">
                                <?= $rcounts ?>
                            </div>
                        </td>

                        <!-- Day + Date -->
                        <td style="vertical-align: middle;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="w3-small">
                                    <?= tgl($time) ?>
                                </span>

                                <span class="w3-text-grey w3-tiny">
                                    <?= $hari[date("N", strtotime($time))] ?>
                                </span>
                            </div>
                        </td>

                        <!-- Distance -->
                        <td align="right" style="width:80px; vertical-align: middle;">
                            <?php if ($rr['distance'] == 0) { ?>
                                <div class="w3-text-grey w3-tiny">
                                    <i class='fa-solid fa-circle-pause w3-small'></i> on review
                                </div>
                            <?php } else { ?>
                                <div style="display:flex; justify-content:flex-end; align-items:baseline; gap:2px;">
                                    <span class="w3-large"><?= desimal($rr['distance'], 1) ?></span>
                                    <?= unit("km") ?>
                                </div>
                            <?php } ?>
                        </td>

                        <!-- Link -->
                        <?php
                        $link = strtolower($rr['link']);

                        $icon =
                            strpos($link, 'strava') !== false ? 'strava.svg' :
                            (strpos($link, 'garmin') !== false ? 'garmin-connect.webp' : '');
                        ?>

                        <td style="width:30px; vertical-align: middle;">
                            <div style="display:flex; justify-content:center; align-items:center;">
                                <?php if (!empty($rr['link'])): ?>
                                    <a href="<?= $rr['link'] ?>" target="_blank">
                                        <img src="images/<?= $icon ?>" style="width:16px;">
                                    </a>
                                <?php else: ?>
                                    <span class="tooltip-trigger">
                                        🩸
                                        <span class="tooltip-box">
                                            Bonus<br>
                                            Donor Darah<br>
                                        </span>
                                    </span>

                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>

                <?php } ?>


            </table>
        </div>
    </div>
<?php } ?>

