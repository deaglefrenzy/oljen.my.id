<div class="w3-card w3-padding-large w3-round-large">
    <form method="post" onsubmit="return confirm('Setor run ini?');">
        <!-- Runner -->
        <div class="w3-margin-bottom">
            <select name="orang_id" class="w3-select w3-border w3-round-large w3-padding w3-margin-top w3-large"
                style="background-color:#fff;" required>
                <option value="" disabled <?= empty($orang_id) ? 'selected' : '' ?>>
                    -- 👤 Pilih Oljener --
                </option>
                <?php
                if (is_array($orang)) {
                    foreach ($orang as $o) {
                        $selected = $orang_id == $o['id'] ? 'selected' : '';
                        echo "<option value=\"{$o['id']}\" $selected>{$o['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <!-- Action -->
        <div class="w3-center w3-margin-bottom">
            <button type="submit" name="action" value="setor donor"
                class="w3-button w3-round-large w3-xlarge w3-padding-large w3-hover-shadow" style="
                        width:100%;
                        background: linear-gradient(135deg, #ff9800, #f57c00);
                        color:white;
                        font-weight:600;
                        letter-spacing:0.5px;
                    ">
                <i class="fa-solid fa-file-arrow-down"></i> SETOR DONOR 10K
            </button>
        </div>
    </form>
</div>

<?php
$query = "
    SELECT r.*, o.name
    FROM runs r
    JOIN orang o ON r.orang_id = o.id
    WHERE link IS NULL AND distance = '10' AND deleted_at IS NULL
    ORDER BY o.name ASC";
$result = mysqli_query($conn, $query);
?>
<div class="w3-white w3-border w3-round-large w3-margin-top">
    <?php
    if (mysqli_num_rows($result) == 0) {
        echo "<div class='w3-padding w3-text-grey'>Belum ada runs yang disetor</div>";
    } else {
        ?>
        <ul class='w3-ul w3-small'>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li style='padding:8px 12px; color:#333;'>
                    <div class='w3-left-align'>
                        <strong style="margin-left:2px;">
                            <i class="fa-solid fa-user"></i> &nbsp;&nbsp;
                            <?= $row['name'] ?>
                        </strong>
                        <span class='w3-text-grey w3-tiny'>
                            &nbsp;
                            <?= tglRelatif($row['input_time']) ?>
                        </span>
                        <br>
                        <i class="fa-solid fa-link"></i>&nbsp;
                        <?php if ($row['link']): ?>
                            <a href="<?php echo $row['link']; ?>" target="_blank" class="w3-text-orange w3-small">
                                <?= $row['link'] ?>
                            </a>
                        <?php else: ?>
                            <span class="w3-text-red w3-small">
                                <?= $row['raw'] ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
    ?>
</div>
