<?php
function getMatchResults($conn, $lapangan, $round, $team)
{
    $query = "SELECT * FROM pmatch WHERE lapangan = '$lapangan' AND round = '$round' ORDER BY id ASC";
    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $point = $play = $skor = $tpoint = $headToHead = $win = $lose = $draw = [];

    while ($qq = mysqli_fetch_array($q)) {
        $pa1 = $qq['pa1'];
        $pa2 = $qq['pa2'];
        $pb1 = $qq['pb1'];
        $pb2 = $qq['pb2'];

        $teamA = $team[$pa1];
        $teamB = $team[$pb1];

        // Add points for each player
        $point[$pa1] = ($point[$pa1] ?? 0) + $qq['score_a'];
        $point[$pa2] = ($point[$pa2] ?? 0) + $qq['score_a'];
        $point[$pb1] = ($point[$pb1] ?? 0) + $qq['score_b'];
        $point[$pb2] = ($point[$pb2] ?? 0) + $qq['score_b'];

        // Count matches played
        if ($qq['score_a'] != 0 && $qq['score_b'] != 0) {
            $play[$teamA] = ($play[$teamA] ?? 0) + 1;
            $play[$teamB] = ($play[$teamB] ?? 0) + 1;
        }

        // Team score
        $skor[$teamA] = ($skor[$teamA] ?? 0) + $qq['score_a'];
        $skor[$teamB] = ($skor[$teamB] ?? 0) + $qq['score_b'];

        $tpoint[$teamA]['score'] = $skor[$teamA];
        $tpoint[$teamB]['score'] = $skor[$teamB];

        // Head-to-head score difference
        $headToHead[$teamA][$teamB] = ($headToHead[$teamA][$teamB] ?? 0) + ($qq['score_a'] - $qq['score_b']);
        $headToHead[$teamB][$teamA] = ($headToHead[$teamB][$teamA] ?? 0) + ($qq['score_b'] - $qq['score_a']);

        // Win / lose / draw + points
        if ($qq['score_a'] > $qq['score_b']) {
            $tpoint[$teamA]['point'] = ($tpoint[$teamA]['point'] ?? 0) + 3;
            $win[$teamA] = ($win[$teamA] ?? 0) + 1;
            $lose[$teamB] = ($lose[$teamB] ?? 0) + 1;
        } else if ($qq['score_a'] < $qq['score_b']) {
            $tpoint[$teamB]['point'] = ($tpoint[$teamB]['point'] ?? 0) + 3;
            $win[$teamB] = ($win[$teamB] ?? 0) + 1;
            $lose[$teamA] = ($lose[$teamA] ?? 0) + 1;
        } else {
            if ($qq['score_a'] != 0 && $qq['score_b'] != 0) {
                $tpoint[$teamA]['point'] = ($tpoint[$teamA]['point'] ?? 0) + 1;
                $tpoint[$teamB]['point'] = ($tpoint[$teamB]['point'] ?? 0) + 1;
                $draw[$teamA] = ($draw[$teamA] ?? 0) + 1;
                $draw[$teamB] = ($draw[$teamB] ?? 0) + 1;
            }
        }
    }

    // Sort players by points
    arsort($point);

    // Sort teams by points → wins → head-to-head → score
    uasort($tpoint, function ($a, $b) use ($win, $headToHead, $tpoint) {
        $teamA = array_search($a, $tpoint);
        $teamB = array_search($b, $tpoint);

        // 1️⃣ Points
        if (($a['point'] ?? 0) != ($b['point'] ?? 0)) {
            return ($b['point'] ?? 0) - ($a['point'] ?? 0);
        }

        // 2️⃣ Wins
        if (($win[$teamA] ?? 0) != ($win[$teamB] ?? 0)) {
            return ($win[$teamB] ?? 0) - ($win[$teamA] ?? 0);
        }

        // 3️⃣ Head-to-head
        if (isset($headToHead[$teamA][$teamB]) && isset($headToHead[$teamB][$teamA])) {
            $diff = $headToHead[$teamA][$teamB] - $headToHead[$teamB][$teamA];
            if ($diff != 0) {
                return $diff > 0 ? -1 : 1; // higher diff wins
            }
        }

        // 4️⃣ Score
        return ($b['score'] ?? 0) - ($a['score'] ?? 0);
    });

    return [
        'points' => $point,
        'tpoints' => $tpoint,
        'play' => $play,
        'skor' => $skor,
        'headToHead' => $headToHead,
        'win' => $win,
        'lose' => $lose,
        'draw' => $draw,
        'numMatches' => mysqli_num_rows($q)
    ];
}

$results = getMatchResults($conn, $lapangan, 1, $team);
$tpoint    = $results['tpoints'];
$play      = $results['play'];
$win       = $results['win'];
$draw      = $results['draw'];
$lose      = $results['lose'];
$skor      = $results['skor'];
?>

<div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
    <div class="w3-container w3-center">
        <h3 class="judul">
            GROUP STAGE
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
                        <?= $tim ?>
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

<!-- <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
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
</div> -->

<?php
$results = getMatchResults($conn, $lapangan, 2, $team);
$tpoint    = $results['tpoints'];
$play      = $results['play'];
$win       = $results['win'];
$draw      = $results['draw'];
$lose      = $results['lose'];
$skor      = $results['skor'];
$numMatches = $results['numMatches'];
if ($numMatches > 0) {
?>

    <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
        <div class="w3-container w3-center">
            <h3 class="judul">
                SEMIFINAL 1
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
                            <?= $tim ?>
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
                    </tr>
                <?php } ?>
            </table>
        </div>
        <br>
    </div>
<?php } ?>

<?php
$results = getMatchResults($conn, $lapangan, 3, $team);
$tpoint    = $results['tpoints'];
$play      = $results['play'];
$win       = $results['win'];
$draw      = $results['draw'];
$lose      = $results['lose'];
$skor      = $results['skor'];
$numMatches = $results['numMatches'];
if ($numMatches > 0) {
?>

    <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
        <div class="w3-container w3-center">
            <h3 class="judul">
                SEMIFINAL 2
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
                            <?= $tim ?>
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
                    </tr>
                <?php } ?>
            </table>
        </div>
        <br>
    </div>
<?php } ?>

<?php
$results = getMatchResults($conn, $lapangan, 4, $team);
$tpoint    = $results['tpoints'];
$play      = $results['play'];
$win       = $results['win'];
$draw      = $results['draw'];
$lose      = $results['lose'];
$skor      = $results['skor'];
$numMatches = $results['numMatches'];
if ($numMatches > 0) {
?>

    <div class="w3-card w3-round w3-padding-16 w3-white" style="margin-bottom: 48px; border-radius: 20px;">
        <div class="w3-container w3-center">
            <h3 class="judul">
                FINAL
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
                            <?= $tim ?>
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
                    </tr>
                <?php } ?>
            </table>
        </div>
        <br>
    </div>
<?php } ?>
