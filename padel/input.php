<div id="inputMatch">
    <form action="https://oljen.my.id/padel/?page=<?= $page ?>#inputMatch" method="post">
        New Match
        <div>
            <?php
            $q = mysqli_query($conn, "SELECT * FROM padelist ORDER BY team, name ASC");
            $players = [];
            while ($gg = mysqli_fetch_array($q)) {
                $players[] = $gg;
            }
            ?>
            <select name="player">
                <?php foreach ($players as $p) { ?>
                    <option value="<?= $p['id'] ?>" <?php if ($p['id'] == $pa1) echo "selected"; ?>>
                        <?= $p['name'] . " (" . $p['team'] . ")" ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="action" value="tambah match" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                <i class="fa-solid fa-plus-circle"></i> Tambah Match
            </button>
        </div>
    </form>
</div>
