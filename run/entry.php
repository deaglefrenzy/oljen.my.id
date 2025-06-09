<?php
$count = 0;
while ($qq = mysqli_fetch_array($q)) {
    $idorang = $qq['id'];
    $tglride = date("Y-m-d", strtotime($qq['input_time']));
    $name = $qq['name'];
    $firstname = explode(" ", $name)[0];
    $count++;

    $e = mysqli_fetch_array(mysqli_query($conn, "SELECT distance FROM runs WHERE orang_id='$idorang' ORDER BY id DESC"));
    $kmterakhir = $e['distance'];

    $ttt = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(distance) as total FROM runs WHERE orang_id='$idorang'"));
    $total = $ttt['total'];
    if (!isset($total)) $total = 0;
    $sisa = 100 - $total;
    if ($sisa < 0) $sisa = 0;
    $progress = $total;

    $dayfinish = 0;
    if ($finish = $qq['finish']) {
        $finishdiff = strtotime($finish) - $date1;
        $dayfinish = floor($finishdiff / (60 * 60 * 24)) + 1;
    } else {
        if ($state != "before") $dayfinish = $numday;
    }
?>
    <div class="w3-card w3-round" id="<?= "row" . $count ?>">
        <div id="<?php echo $idorang; ?>"></div>
        <button onclick="myFunction('Demo<?php echo $idorang; ?>')"
            class="w3-button w3-block w3-left-align entry" style="
            border-width:2px 3px;
            border-color:#333;
            border-style:solid;
            <?php
            echo "background: linear-gradient(45deg, #fff, #fff";
            if ($total >= 49) echo " , #4CAF50";
            if ($total >= 74) echo " , #ff9800";
            if ($total >= 99) echo " , #f44336";
            echo ");";
            ?>
            ">
            <table width="100%" align="center">
                <tr align="center">
                    <td align="left" style="padding-left: 10px; line-height:10px;">
                        <?php
                        $kapital = substr($firstname, 0, 1);
                        $namanya = substr($name, 1, strlen($name) - 1);
                        ?>
                        <font style="font-family: norwester;" class="w3-xlarge"><?= $kapital ?></font><?= $namanya ?>
                    </td>
                    <td width=100 align="right" class="w3-xlarge">
                        <font class="nomor"><?= runKM($total) ?><font class="w3-small"> km</font>
                    </td>
                    <td width=25 align="center" id="caret-<?php echo $idorang; ?>">
                        <i class="fa-solid fa-caret-down w3-small"></i>
                    </td>
                </tr>
            </table>
        </button>
        <div id="Demo<?php echo $idorang; ?>" class="w3-hide w3-container w3-padding-16" style="box-shadow:
            inset -10px 5px 6px -5px rgba(0, 0, 0, 0.7),
            inset 10px 5px 6px -5px rgba(0, 0, 0, 0.7);">
            <?php
            $t = mysqli_query($conn, "SELECT distance FROM runs WHERE orang_id='$idorang' AND distance > 0 ORDER BY distance DESC");
            $results = mysqli_fetch_all($t);
            $furthestDistance = reset($results)[0];
            $shortestDistance = end($results)[0];
            if (!$furthestDistance) $furthestDistance = 0;
            if (!$shortestDistance) $shortestDistance = 0;

            $r = mysqli_query($conn, "SELECT * FROM runs WHERE orang_id='$idorang' ORDER BY input_time ASC") or die(mysqli_error($conn));
            $jumlahRide = mysqli_num_rows($t);
            if ($jumlahRide > 0) $rataRata = $ttt['total'] / $jumlahRide;
            else $rataRata = 0;
            ?>
            <div class="w3-padding-small">
                <div style="display: flex; align-items: center; width:90%; margin: 0 auto;">
                    <div class="w3-center w3-padding-tiny w3-xlarge" style="color: #2c3e50; flex-grow: 1; display: flex; justify-content:left;">
                        <img src="../images/olo full.png" style="height: 25px; margin-top:3px;">
                        &nbsp;
                        <a href="<?= $qq['profile'] ?>" target="_blank"><?= $name ?></a>
                    </div>
                </div>
                <?php if ($total < 100) { ?>
                    <div>
                        <div style="display: flex; width:90%; margin: 0 auto; margin-bottom:-6px;" class="w3-tiny">
                            <div style="flex: 1 0 50%;"></div>
                            <div style="flex: 1 0 50%; display:flex;">
                                <div style="flex: 1; text-align:left; margin-left:-9px;" class="w3-text-green">50 km</div>
                                <div style="flex: 1; text-align:center;" class="w3-text-orange">75 km</div>
                                <div style="flex: 1; text-align:right; margin-right:-11px;" class="w3-text-red">100 km</div>
                            </div>
                        </div>
                        <div style="display: flex; width:90%; margin: 0 auto; margin-bottom:-2px;" class="w3-tiny">
                            <div style="flex: 1 0 50%;"></div>
                            <div style="flex: 1 0 50%; display:flex;">
                                <div style="flex: 1; text-align:left; margin-left:-12px;" class="w3-text-green">Dolphin</div>
                                <div style="flex: 1; text-align:center;" class="w3-text-orange">Arwana</div>
                                <div style="flex: 1; text-align:right; margin-right:-12px;" class="w3-text-red">Piranha</div>
                            </div>
                        </div>
                        <div style="display: flex; width:90%; margin: 0 auto;">
                            <div style="flex: 1 0 50%;"></div>
                            <div style="flex: 1 0 50%; display:flex;">
                                <div style="flex: 1; text-align:left;"><i class="fa-solid fa-arrow-down w3-tiny"></i></div>
                                <div style="flex: 1; text-align:center;"><i class="fa-solid fa-arrow-down w3-tiny"></i></div>
                                <div style="flex: 1; text-align:right;"><i class="fa-solid fa-arrow-down w3-tiny"></i></div>
                            </div>
                        </div>
                        <progress value="<?= $progress ?>" max="100"> <?= $progress ?>% </progress>
                    </div>
                <?php } ?>
                <table align="center" style="width: 90%; margin-top:10px;">
                    <tr class="w3-small" valign=bottom>
                        <td width="33%">
                            <font class="w3-xlarge nomor"><?= $jumlahRide ?></font>
                            <br>
                            <font class="w3-small w3-opacity">Runs</font>
                        </td>
                        <td>
                            <font class="w3-xlarge nomor"><?= $dayfinish ?></font>
                            <br>
                            <font class="w3-small w3-opacity">Hari</font>
                        </td>
                        <td width="33%">
                            <font class="w3-xlarge nomor" style="color:#2962FF;"><?= runKM($total) ?></font> km
                            <br>
                            <font class="w3-small w3-opacity">Ditempuh</font>
                        </td>
                    </tr>
                </table>
                <table align="center" style="width: 90%; margin-top:10px;">
                    <tr class="w3-small" align="left">
                        <td width="33%">
                            <font class="w3-large nomor"><?= runKM($furthestDistance) ?></font> km
                            <br>
                            <font class="w3-small w3-opacity">Terjauh</font>
                        </td>
                        <td>
                            <font class="w3-large nomor"><?= runKM($shortestDistance) ?></font> km
                            <br>
                            <font class="w3-small w3-opacity">Terdekat</font>
                        </td>
                        <td width="33%">
                            <font class="w3-large nomor"><?= runKM($rataRata) ?></font> km
                            <br>
                            <font class="w3-small w3-opacity">Rata-Rata</font>
                        </td>
                    </tr>
                </table>
                <br>
                <table width=90% align="center" style="border-collapse: collapse;">
                    <tr>
                        <form action="../chart.php" target="_blank" method="get">
                            <input type="hidden" name="id" value="<?= $idorang ?>">
                            <input type="hidden" name="type" value="runs">
                            <td align="left">
                                <button class="cool-button w3-small" type="submit">
                                    <i class="fa-solid fa-chart-line buttonicon"></i> Grafik
                                </button>
                            </td>
                        </form>
                        <form action="../history.php" target="_blank" method="get">
                            <input type="hidden" name="id" value="<?= $idorang ?>">
                            <input type="hidden" name="type" value="runs">
                            <td align="right">
                                <button class="cool-button w3-small" type="submit">
                                    <i class="fa-solid fa-clock-rotate-left buttonicon"></i> History
                                </button>
                            </td>
                        </form>
                    </tr>
                </table>
                <?php if ($state == "event") { ?>
                    <hr style=" border: 0;
                                height: 2px;
                                background: linear-gradient(90deg, #25a7d7, #2962FF);
                                margin: 20px 0;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                width:90%;
                                margin-left:5%;
                                margin-right:5%;">

                    <?php
                    $g = mysqli_query($conn, "SELECT link, pesan FROM runs WHERE orang_id='$idorang' AND distance='0'");
                    $numReview = mysqli_num_rows($g);
                    if ($numReview > 0) {
                    ?>
                        <table width=90% align="center" style="border-collapse: collapse; margin-bottom:20px;" class="w3-small">
                            <tr>
                                <td>Run sedang dalam review : </td>
                            </tr>
                            <?php
                            while ($gg = mysqli_fetch_row($g)) {
                            ?>
                                <tr>
                                    <td align="left">
                                        <li>
                                            <a href="<?= $gg[0] ?>" target="_blank"><?= $gg[0] ?></a>
                                            <?php
                                            if (!empty($gg[1])) echo "<font class='w3-text-red'> | Pesan ADMIN : " . $gg[1] . "</font>"; ?>
                                        </li>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php
                    }
                    if ($count > 3) $gocount = $count - 3;
                    ?>
                    <form action="https://oljen.my.id/run/#row<?= $gocount ?>" method="post" onsubmit="return confirm('Setor Ride Ini?');">
                        <div style="display: flex; flex-direction:column">
                            <div>
                                <input type="hidden" name="idorang" value="<?= $idorang ?>">
                                <input type="text" class="w3-small" name="link" placeholder="Contoh : https://strava.app.link/mZhDrxSOaBb" <?php echo $dis; ?>>
                            </div>
                            <div style="margin-top: 10px;">
                                <button type="submit" class="cool-button small" name="action" value="inputride" <?php echo $dis; ?>>
                                    <i class="fa fa-plus"></i> <i class="fa-solid fa-person-running buttonicon"></i> Setor <?= $firstname ?>
                                </button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
}
?>
