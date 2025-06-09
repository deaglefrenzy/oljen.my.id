<?php
$count = 0;
$query = "SELECT * FROM pmatch WHERE lapangan = '$lapangan' ORDER BY id ASC";
$q = mysqli_query($conn, $query) or die(mysqli_error($conn));
while ($qq = mysqli_fetch_array($q)) {
    $idmatch = $qq['id'];
    $pa1 = $qq['pa1'];
    $pa2 = $qq['pa2'];
    $pb1 = $qq['pb1'];
    $pb2 = $qq['pb2'];

    $point[$pa1] += $qq['score_a'];
    $point[$pa2] += $qq['score_a'];
    $point[$pb1] += $qq['score_b'];
    $point[$pb2] += $qq['score_b'];

    if ($qq['score_a'] != 0 && $qq['score_b'] != 0) {
        $play[$team[$pa1]]++;
        $play[$team[$pb1]]++;
    }

    $skor[$team[$pa1]] += $qq['score_a'];
    $skor[$team[$pb1]] += $qq['score_b'];

    $tpoint[$team[$pa1]]['score'] = $skor[$team[$pa1]];
    $tpoint[$team[$pb1]]['score'] = $skor[$team[$pb1]];

    if ($qq['score_a'] > $qq['score_b']) {
        $tpoint[$team[$pa1]]['point'] += 3;
        $win[$team[$pa1]]++;
        $lose[$team[$pb1]]++;
    } else if ($qq['score_a'] < $qq['score_b']) {
        $tpoint[$team[$pb1]]['point'] += 3;
        $win[$team[$pb1]]++;
        $lose[$team[$pa1]]++;
    } else {
        if ($qq['score_a'] != 0 && $qq['score_b'] != 0) {
            $tpoint[$team[$pa1]]['point'] += 1;
            $tpoint[$team[$pb1]]['point'] += 1;
            $draw[$team[$pa1]]++;
            $draw[$team[$pb1]]++;
        }
    }
}
arsort($point);

uasort($tpoint, function ($a, $b) {
    if ($a['point'] != $b['point']) {
        return $b['point'] - $a['point'];
    }
    return $b['score'] - $a['score'];
});


?>

<div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
    <div class="w3-container w3-center">
        <h3 class="judul">
            <i class="fa-solid fa-people-group icon"></i> TEAMS
        </h3>
        <table width=90% align="center" style="border-collapse: collapse;">
            <tr>
                <th width="10%">#</th>
                <th align="left">Team</th>
                <th width=12%>P</th>
                <th width=12%>W</th>
                <th width=12%>D</th>
                <th width=12%>L</th>
                <th width=12%>Sco</th>
                <th width=12%>Pts</th>
            </tr>
            <?php
            $count = 0;
            foreach ($tpoint as $tim => $poin) {
                $count++;
                $warna = "";
                if ($tim == "A") $warna = "w3-text-red";
                if ($tim == "B") $warna = "w3-text-blue-grey";
                if ($tim == "C") $warna = "w3-text-green";
                if ($tim == "D") $warna = "w3-text-orange";
            ?>
                <tr style="border-bottom: 1px solid #ccc;" align="center">
                    <td class="nomor">
                        <?= $count ?>
                    </td>
                    <td align="left" class="<?= $warna ?>">
                        Team <?= $tim ?>
                    </td>
                    <td class="nomor">
                        <?php
                        if (isset($play[$tim])) echo $play[$tim];
                        else echo "0";
                        ?>
                    </td>
                    <td class="nomor">
                        <?php
                        if (isset($win[$tim])) echo $win[$tim];
                        else echo "0";
                        ?>
                    </td>
                    <td class="nomor">
                        <?php
                        if (isset($draw[$tim])) echo $draw[$tim];
                        else echo "0";
                        ?>
                    </td>
                    <td class="nomor">
                        <?php if (isset($lose[$tim])) echo $lose[$tim];
                        else echo "0";
                        ?>
                    </td>
                    <td class="nomor">
                        <?php if (isset($skor[$tim])) echo $skor[$tim];
                        else echo "0";
                        ?>
                    </td>
                    <td class="nomor w3-large">
                        <?php
                        if (isset($poin['point'])) echo $poin['point'];
                        else echo "0";
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <br>
</div>

<div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
    <div class="w3-container w3-center">
        <h3 class="judul">
            <i class="fa-solid fa-user icon"></i> PLAYERS
        </h3>
        <table width=90% align="center" style="border-collapse: collapse;">
            <tr>
                <th width="10%" align="left">#</th>
                <th align="left">Player</th>
                <th align="left">Team</th>
                <th width=15%>Score</th>
            </tr>
            <?php
            $count = 0;
            $prevPoint = 0;
            $nextCount = 0;
            foreach ($point as $id => $poin) {
                $count++;
                if ($prevPoint != $poin) {
                    $count += $nextCount;
                    $prevPoint = $poin;
                    $nextCount = 0;
                } else {
                    $count--;
                    $nextCount++;
                }

                $player = $nama[$id];
                $tim = $team[$id];

                $warna = "";
                if ($tim == "A") $warna = "w3-text-red";
                if ($tim == "B") $warna = "w3-text-blue-grey";
                if ($tim == "C") $warna = "w3-text-green";
                if ($tim == "D") $warna = "w3-text-orange";
            ?>
                <tr class="<?= $warna ?>" style="border-bottom: 1px solid #ccc;">
                    <td align="left" class="nomor">
                        <?php
                        if ($count > 0) echo $count;
                        else echo "-";
                        ?>
                    </td>
                    <td align="left">
                        <?= $player ?>
                    </td>
                    <td align="left">
                        <?= $tim ?>
                    </td>
                    <td align="right" class="nomor w3-large">
                        <?php echo $poin ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <br>
</div>
