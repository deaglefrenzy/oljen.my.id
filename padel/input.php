<div id="inputMatch" class="w3-hide w3-container w3-padding-16" style="box-shadow:
            inset -10px 5px 6px -5px rgba(0, 0, 0, 0.7),
            inset 10px 5px 6px -5px rgba(0, 0, 0, 0.7);">
    <form action="https://oljen.my.id/padel/?page=<?= $page ?>#inputMatch" method="post">
        New Match
        <div>
            <select name="pa1" class="w3-select w3-border w3-xlarge" required>
                <option value="" disabled selected>Select player</option>
                <?php
                foreach ($nama as $n) {
                ?>
                    <option value="<?= $n['id'] ?>" <?php if ($n['id'] == $pa1) echo "selected"; ?>><?= $n['name'] . "(" . $n['team']  ?></option>
                <?php
                }
                ?>
            </select>
            <button type="submit" name="action" value="tambah match" <?php echo $dis; ?> class="w3-button w3-green" style="margin-bottom: 10px;">
                <i class="fa-solid fa-plus-circle"></i> Tambah Match
            </button>
        </div>
    </form>
</div>
