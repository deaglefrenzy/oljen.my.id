<div id="inputMatch">
    <form action="https://oljen.my.id/padel/?page=<?= $page ?>#inputMatch" method="post">
        <h3>New Match</h3>
        <div>
            <?php renderTeamSelect($conn, $page, "pa", "Tim 1"); ?>
            <br>
            vs
            <br>
            <?php renderTeamSelect($conn, $page, "pb", "Tim 2"); ?>
            <br>
            Round
            <select name="round" class="w3-select w3-border w3-round" style="width: 90%; display: inline-block;">
                <option value="1" selected>Group Stage</option>
                <option value="2">SemiFinal 1</option>
                <option value="3">SemiFinal 2</option>
                <option value="4">Final</option>
            </select>
            <br><br>
            <button type="submit" name="action" value="tambah match" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                <i class="fa-solid fa-plus-circle"></i> Tambah Match
            </button>
        </div>
    </form>
</div>

<?php

function renderTeamSelect($conn, $page, $selectName, $label = "Pilih Tim")
{
    if ($page == "men") $jk = "L";
    else $jk = "P";
    // Get player list grouped by team
    $query = "SELECT * FROM padelist WHERE jk='$jk' ORDER BY team, name ASC";
    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $teams = [];
    while ($gg = mysqli_fetch_array($q)) {
        $teams[$gg['team']][] = $gg;
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

                echo '<option value="' . htmlspecialchars($value) . '"' . '>';
                echo htmlspecialchars($timm . $name1 . " & " . $name2);
                echo '</option>';
            }
        }
    }

    echo '</select>';
}
