<div id="inputMatch">
    <form action="https://oljen.my.id/padel/?page=<?= $page ?>#inputMatch" method="post">
        <h3>New Match</h3>
        <div>
            <?php renderTeamSelect($conn, "L", "pa", "Tim 1"); ?>
            <br>
            vs
            <br>
            <?php renderTeamSelect($conn, "L", "pb", "Tim 2"); ?>
            <br>
            Round
            <select name="round" class="w3-select w3-border w3-round" style="width: 90%; display: inline-block;">
                <option value="1" selected>Penyisihan</option>
                <option value="2">Semifinal</option>
                <option value="3">Final</option>
            </select>
            <br><br>
            <button type="submit" name="action" value="tambah match" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                <i class="fa-solid fa-plus-circle"></i> Tambah Match
            </button>
        </div>
    </form>
</div>

<?php

function renderTeamSelect($conn, $jk, $selectName, $label = "Pilih Tim")
{
    // Get player list grouped by team
    $query = "SELECT * FROM padelist WHERE jk='$jk' ORDER BY team, name ASC";
    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $teams = [];
    while ($gg = mysqli_fetch_array($q)) {
        $teams[$gg['team']][] = $gg;
    }

    // Preload all match counts for efficiency
    $matchCountMap = [];
    $matchQuery = "SELECT pa1, pa2, pb1, pb2 FROM pmatch";
    $mq = mysqli_query($conn, $matchQuery) or die(mysqli_error($conn));
    while ($m = mysqli_fetch_array($mq)) {
        $pairs = [
            [$m['pa1'], $m['pa2']],
            [$m['pb1'], $m['pb2']]
        ];
        foreach ($pairs as $pair) {
            sort($pair); // order-independent
            $key = implode(',', $pair);
            if (!isset($matchCountMap[$key])) {
                $matchCountMap[$key] = 0;
            }
            $matchCountMap[$key]++;
        }
    }

    // Render the select
    echo '<select name="' . htmlspecialchars($selectName) . '" class="w3-select w3-border w3-round" style="width: 90%; display: inline-block;">';
    echo '<option value="" selected>' . htmlspecialchars($label) . '</option>';

    foreach ($teams as $teamName => $members) {
        for ($i = 0; $i < count($members); $i++) {
            for ($j = $i + 1; $j < count($members); $j++) {
                $id1 = $members[$i]['id'];
                $name1 = $members[$i]['name'];
                $id2 = $members[$j]['id'];
                $name2 = $members[$j]['name'];

                $value = $id1 . ',' . $id2;
                $timm = ($jk == "L") ? $teamName . " - " : "";

                // Check match count from preloaded map
                $key = implode(',', array_map('strval', [min($id1, $id2), max($id1, $id2)]));
                $matchCount = $matchCountMap[$key] ?? 0;
                $disabled = ($matchCount >= 2) ? 'disabled' : '';

                echo '<option value="' . htmlspecialchars($value) . '" ' . $disabled . '>';
                echo htmlspecialchars($timm . $name1 . " & " . $name2);
                echo '</option>';
            }
        }
    }

    echo '</select>';
}
