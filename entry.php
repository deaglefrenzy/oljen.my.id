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
    FROM rides
    WHERE deleted_at IS NULL
    GROUP BY orang_id
) AS stats ON orang.id = stats.orang_id
LEFT JOIN rides AS latest_ride ON latest_ride.orang_id = stats.orang_id
    AND latest_ride.input_time = stats.max_time
    AND latest_ride.deleted_at IS NULL
WHERE orang.active = 1
ORDER BY total_distance DESC, orang.name ASC;
";

$result = mysqli_query($conn, $query);

$entries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $entries[] = $row;
}

$count = 0;
foreach ($entries as $qq) {
    $name = $qq['name'];
    $total = $qq['total_distance'];
    $idorang = $qq['id'];
    $count++;
    $space = "&nbsp;";
    if ($count < 10) $space = "&nbsp;&nbsp;";
    $progress = round(($total / 1000) * 100);
    $sisa = 1000 - $total;
    $jumlahRide = $qq['ride_count'];
    $furthestDistance = $qq['max_distance'];
    $shortestDistance = $qq['min_distance'];
    $rataRata = ($qq['ride_count'] > 0) ? ($qq['total_distance'] / $qq['ride_count']) : 0;
    if ($total < 500) {
        $diskon = "Min.500km";
    } else {
        $calc_dist = min($total, 1000);
        $diskon = floor(($calc_dist - 500) / 2) * 1000;
    }
?>
    <div class="w3-card w3-round reddit" id="<?= "row" . $count ?>">
        <div id="<?php echo $idorang; ?>"></div>
        <button onclick="myFunction('Demo<?php echo $idorang; ?>')"
            class="w3-button w3-block w3-left-align
            <?php
            if ($total < 1000) {
                echo "entry";
                $textColor = "#e8f5e9";
            } else {
                echo "finish";
                $textColor = "#101010";
            }
            ?>
            ">
            <table width="100%" align="center" style="color: <?= $textColor ?>">
                <tr>
                    <td align="left" style="padding-left: 10px; line-height:10px;">
                        <span class="monospace w3-large"><?= $count . $space; ?></span>
                        <?= $name ?>
                    </td>
                    <td width=100 align="right" class="w3-xlarge">
                        <span class="monospace"><?= $total ?></span><span class="w3-small"> km</span>
                    </td>
                    <td width=25 align="center" id="caret-<?php echo $idorang; ?>">
                        <i class="fa-solid fa-caret-down w3-small"></i>
                    </td>
                </tr>
            </table>
        </button>
    </div>
    <div id="Demo<?php echo $idorang; ?>" class="w3-hide w3-container w3-padding-16 w3-white w3-card" style="margin-top: -10px; margin-bottom: 10px;">
        <div class="w3-padding-small">
            <div style="display: flex; align-items: left; padding-left:25px; padding-top:10px;">
                <div class="w3-left w3-padding-tiny" style="font-size:20px;">
                    <img src="images/olo full.png" style="height: 20px; margin-top:-8px;">
                    <?= $name ?>
                </div>
                <?php
                if ($qq['profile'] != null || $qq['profile'] != "") {
                ?>
                    &nbsp;&nbsp;&nbsp;
                    <div style="margin-top:1px;">
                        <a href="<?= $qq['profile'] ?>" target="_blank" style="text-decoration:none;">
                            <img src="images/strava.svg" style="width: 25px;" alt="Profil Strava">
                        </a>
                    </div>
                <?php } ?>
            </div>
            <table align="center" style="width: 95%; margin-top:10px; padding-left:15px;">
                <tr class="w3-small" align="left" valign="bottom">
                    <td width="33%">
                        <font class="w3-xlarge monospace"><?= $jumlahRide ?></font>
                    </td>
                    <td>
                        <font class="w3-xlarge monospace"><?= $total ?></font> km
                    </td>
                    <td width="33%">
                        <font class="w3-medium w3-text-green monospace"><?= $diskon ?></font>
                    </td>
                </tr>
                <tr class="w3-small" align="left">
                    <td width="33%">
                        <font class="w3-opacity">Ride<?= ($jumlahRide > 1) ? "s" : "" ?></font>
                    </td>
                    <td>
                        <font class="w3-opacity">Ditempuh</font>
                    </td>
                    <td width="33%">
                        <font class="w3-opacity">Diskon</font>
                    </td>
                </tr>
                <tr>
                    <td style="height: 10px;"></td>
                </tr>
                <tr class="w3-small" align="left">
                    <td width="33%">
                        <font class="w3-xlarge monospace"><?= $furthestDistance ?></font> km
                        <br>
                        <font class="w3-opacity">Terjauh</font>
                    </td>
                    <td>
                        <font class="w3-xlarge monospace"><?= $shortestDistance ?></font> km
                        <br>
                        <font class="w3-opacity">Terdekat</font>
                    </td>
                    <td width="33%">
                        <font class="w3-xlarge monospace"><?= round($rataRata) ?></font> km
                        <br>
                        <font class="w3-opacity">Rata-Rata</font>
                    </td>
                </tr>
            </table>
            <br>
            <table width=90% align="center" style="border-collapse: collapse;">
                <?php
                $que = "SELECT * FROM rides WHERE orang_id='$idorang' AND deleted_at IS NULL ORDER BY input_time ASC";
                $r = mysqli_query($conn, $que) or die(mysqli_error($conn));
                $rcount = 0;
                $rawData = [];
                while ($rr = mysqli_fetch_array($r)) {
                    $date = date('Y-m-d', strtotime($rr['input_time']));
                    $rawData[] = array($date, $rr['distance']);
                    $rcount++;
                    if ($rcount < 10) $rcounts = "0" . $rcount;
                    else $rcounts = $rcount;
                ?>
                    <tr>
                        <td align="left" class="monospace">
                            <?= $rcounts ?>
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
                                echo "<span class='w3-small'>" . $hari[date("N", strtotime($time))] . "</span> ";
                                ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            echo date("d", strtotime($time));
                            echo " <font class=w3-small>" . date("M Y", strtotime($time)) . "</font>";
                            ?>
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
                                <font class="w3-large monospace"><?= $rr['distance'] ?></font>
                                <font class="w3-small">km</font>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php } ?>
