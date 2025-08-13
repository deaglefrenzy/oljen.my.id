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
                    // generate all combinations of 2 from the 3 players
                    for ($i = 0; $i < count($members); $i++) {
                        for ($j = $i + 1; $j < count($members); $j++) {
                            $id1 = $members[$i]['id'];
                            $name1 = $members[$i]['name'];
                            $id2 = $members[$j]['id'];
                            $name2 = $members[$j]['name'];

                            // value could be "id1,id2" or something else depending on your needs
                            $value = $id1 . ',' . $id2;
                ?>
                            <option value="<?= $value ?>">
                                <?= $teamName . " - " . $name1 . " & " . $name2 ?>
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
                ?>
                            <option value="<?= $value ?>">
                                <?= $teamName . " - " . $name1 . " & " . $name2 ?>
                            </option>
                <?php
                        }
                    }
                }
                ?>
            </select>
            <br><br>
            <button type="submit" name="action" value="tambah match" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                <i class="fa-solid fa-plus-circle"></i> Tambah Match
            </button>
        </div>
    </form>
</div>
