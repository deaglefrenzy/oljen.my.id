<?php
$count = 0;
$query = "SELECT * FROM `pmatch` WHERE `lapangan` = '$lapangan' ORDER BY `order` ASC";
$q = mysqli_query($conn, $query) or die(mysqli_error($conn));
while ($qq = mysqli_fetch_array($q)) {
    $idmatch = $qq['id'];
    $score_a = $qq['score_a'];
    $score_b = $qq['score_b'];

    if (($score_a == 0) && ($score_b == 0)) {
        $skora = "";
        $skorb = "";
        $kiri = "";
        $kanan = "";
    } else {
        $skora = str_pad($score_a, 2, "0", STR_PAD_LEFT);
        $skorb = str_pad($score_b, 2, "0", STR_PAD_LEFT);

        if ($score_a > $score_b) {
            $kiri = "<i class='fa-solid fa-circle-check w3-text-green w3-tiny'></i>";
            $kanan = "";
        } else if ($score_a < $score_b) {
            $kiri = "";
            $kanan = "<i class='fa-solid fa-circle-check w3-text-green w3-tiny'></i>";
        } else {
            $kiri = "";
            $kanan = "";
        }
    }

    $pa1 = $qq['pa1'];
    $pa2 = $qq['pa2'];
    $pb1 = $qq['pb1'];
    $pb2 = $qq['pb2'];
    $order = $qq['order'];

    $warnaa = "";
    $warnab = "";

    if ($team[$pa1] == "A") $warnaa = "w3-text-red";
    if ($team[$pa1] == "B") $warnaa = "w3-text-blue-grey";
    if ($team[$pa1] == "C") $warnaa = "w3-text-green";
    if ($team[$pa1] == "D") $warnaa = "w3-text-orange";

    if ($team[$pa2] == "A") $warnab = "w3-text-red";
    if ($team[$pb1] == "B") $warnab = "w3-text-blue-grey";
    if ($team[$pb1] == "C") $warnab = "w3-text-green";
    if ($team[$pb1] == "D") $warnab = "w3-text-orange";
    $count++;
?>
    <div class="w3-card w3-round" id="<?= "row" . $order ?>">
        <div id="<?php echo $idmatch; ?>"></div>
        <button onclick="myFunction('Demo<?php echo $idmatch; ?>')"
            class="w3-button w3-block w3-left-align entry" style="
            border-width:2px 3px;
            border-color:#333;
            border-style:solid;">
            <table width="100%" align="center" class="w3-large">
                <tr valign="middle">
                    <td width=10% align="left" class="w3-xlarge">
                        <?= $order; ?>
                    </td>
                    <td class="<?= $warnaa ?>" align="left" width="25%">
                        <?= $nama[$pa1] ?><br><?= $nama[$pa2] ?>
                    </td>
                    <td class="w3-xlarge" style="width: 14%;" align="right">
                        <?= $kiri ?><font class="nomor"><?= $skora ?></font>
                    </td>
                    <td class="w3-xlarge" style="width: 2%; padding-bottom:3px;" align="center">
                        :
                    </td>
                    <td class="w3-xlarge" style="width: 14%;" align="left">
                        <font class="nomor"><?= $skorb ?></font><?= $kanan ?>
                    </td>
                    <td class="<?= $warnab ?>" align="right" width="25%">
                        <?= $nama[$pb1] ?><br><?= $nama[$pb2] ?>
                    </td>
                    <?php if ($admin == "ok") {
                    ?>
                        <td width=10% align="right" id="caret-<?php echo $idmatch; ?>">
                            <i class="fa-solid fa-caret-down w3-small"></i>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            </table>
        </button>
        <div id="Demo<?php echo $idmatch; ?>" class="w3-hide w3-container w3-padding-16" style="box-shadow:
            inset -10px 5px 6px -5px rgba(0, 0, 0, 0.7),
            inset 10px 5px 6px -5px rgba(0, 0, 0, 0.7);">
            <form action="https://oljen.my.id/padel/?page=<?= $page ?>#row<?= $order ?>" method="post">
                <input type="hidden" name="idmatch" value="<?= $idmatch ?>">
                Input Skor <?= $nama[$pa1] . " & " . $nama[$pa2] ?>
                <div>
                    <input type="tel" class="w3-xlarge" name="score_a" <?php echo $dis; ?> size="2" maxlength="2" value="<?= $score_a ?>" style="text-align: center; width: 50px;" id="inputSelect">
                    <button type="submit" name="action" value="updateskor" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                        <i class="fa-solid fa-check"></i> Update Skor
                    </button>
                </div>
            </form>
            <br>
            <!-- <form action="https://oljen.my.id/padel/?page=<?= $page ?>#row<?= $order ?>" method="post">
                <input type="hidden" name="idmatch" value="<?= $idmatch ?>">
                <div>
                    <input type="tel" class="w3-xlarge" name="order" <?php echo $dis; ?> size="2" maxlength="2" value="<?= $order ?>" style="text-align: center; width: 50px;" id="inputSelect">
                    <button type="submit" name="action" value="urutanmatch" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                        <i class="fa-solid fa-list-ol"></i> Ubah Urutan Match
                    </button>
                </div>
            </form>
            <br> -->
            <form action="https://oljen.my.id/padel/?page=<?= $page ?>#row<?= $order ?>" method="post" onsubmit="return confirm('Yakin ingin reset skor?');">
                <input type="hidden" name="idmatch" value="<?= $idmatch ?>">
                <div>
                    <button type="submit" name="action" value="resetskor" <?php echo $dis; ?> class="w3-small w3-button w3-red">
                        <i class="fa-solid fa-arrows-spin"></i> Reset Skor
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
}
?>

<script>
    const inputElement = document.getElementById("inputSelect");

    inputElement.addEventListener("click", function() {
        this.select();
    });
</script>
