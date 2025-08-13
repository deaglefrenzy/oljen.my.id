<div id="inputMatch">
    <form action="https://oljen.my.id/padel/?page=<?= $page ?>#inputMatch" method="post">
        <h3>New Match</h3>
        <div>
            <?php
            if ($page == "men") $jk = "L";
            else $jk = "P";

            $query = "SELECT * FROM padelist WHERE jk='$jk' ORDER BY team, name ASC";
            $q = mysqli_query($conn, $query) or die(mysqli_error($conn));

            $teams = [];
            while ($gg = mysqli_fetch_array($q)) {
                $teams[$gg['team']][] = $gg; // group players by team
            }

            ?>
            <select name="pa" class="w3-select w3-border w3-round" style="width: 90%; display: inline-block;">
                <option value="" selected>Tim 1</option>
                <?php
                foreach ($teams as $teamName => $members) {
                    // generate all combinations of 2 from the team members
                    for ($i = 0; $i < count($members); $i++) {
                        for ($j = $i + 1; $j < count($members); $j++) {
                            $id1 = $members[$i]['id'];
                            $name1 = $members[$i]['name'];
                            $id2 = $members[$j]['id'];
                            $name2 = $members[$j]['name'];

                            $value = $id1 . ',' . $id2;
                            $timm = "";
                            if ($jk == "L") $timm = $teamName . " - ";

                            // 🔍 Check how many matches this pair has played
                            $id1_esc = mysqli_real_escape_string($conn, $id1);
                            $id2_esc = mysqli_real_escape_string($conn, $id2);

                            $checkQuery = "
                    SELECT COUNT(*) AS cnt
                    FROM pmatch
                    WHERE
                        ( (pa1='$id1_esc' AND pa2='$id2_esc') OR (pa1='$id2_esc' AND pa2='$id1_esc') )
                        OR
                        ( (pb1='$id1_esc' AND pb2='$id2_esc') OR (pb1='$id2_esc' AND pb2='$id1_esc') )
                ";
                            $checkRes = mysqli_query($conn, $checkQuery) or die(mysqli_error($conn));
                            $checkRow = mysqli_fetch_assoc($checkRes);
                            $matchCount = $checkRow['cnt'];

                            $disabled = ($matchCount >= 2) ? 'disabled' : '';
                ?>
                            <option value="<?= $value ?>" <?= $disabled ?>>
                                <?= $timm . $name1 . " & " . $name2 ?>
                            </option>
                <?php
                        }
                    }
                }
                ?>
            </select>
            <br>
            vs
            <br>
            <select name="pb" class="w3-select w3-border w3-round" style="width: 90%; display: inline-block;">
                <option value="" selected>Tim 2</option>
                <?php
                foreach ($teams as $teamName => $members) {
                    // generate all combinations of 2 from the 3 players
                    for ($i = 0; $i < count($members); $i++) {
                        for ($j = $i + 1; $j < count($members); $j++) {
                            $id1 = $members[$i]['id'];
                            $name1 = $members[$i]['name'];
                            $id2 = $members[$j]['id'];
                            $name2 = $members[$j]['name'];

                            // value could be "id1,id2" or something else depending on your needs
                            $value = $id1 . ',' . $id2;
                            $timm = "";
                            if ($jk == "L") $timm = $teamName . " - ";
                ?>
                            <option value="<?= $value ?>">
                                <?= $timm . $name1 . " & " . $name2 ?>
                            </option>
                <?php
                        }
                    }
                }
                ?>
            </select>
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
