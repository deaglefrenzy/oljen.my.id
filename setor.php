<?php
include_once 'setor_data.php';
?>
<div class="w3-content w3-center" style="width: 90%; max-width: 480px; text-align: center; margin-top:10px;">
    <div class="w3-center metal-text">
        Setor Ride
    </div>
    <div class="glass-card w3-padding w3-center">
        <form method="post" onsubmit="return confirm('Setor ride ini?');">
            <div class="filter-row">
                <div class="glass-select-wrap">
                    <select name="orang_id" class="glass-select w3-large w3-text-black w3-border">
                        <option value="">Pilih Rider</option>
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
            </div>
            <label class="w3-text-white">Link STRAVA</label>
            <input type="text" name="link" placeholder="Contoh: https://strava.app.link/YH8fP9vSnSb" class="w3-input w3-left-align w3-border w3-margin-bottom" required autocomplete="off">
            <?php if ($is_available): ?>
                <button type="submit" name="action" value="setor ride" class="w3-button w3-green w3-margin-bottom w3-round w3-xlarge">
                    <i class="fa-regular fa-floppy-disk"></i> SETOR
                </button>
            <?php else: ?>
                <button type="button" class="w3-button w3-grey w3-margin-bottom w3-round w3-xlarge" disabled>
                    <i class="fa-solid fa-lock"></i> CLOSED
                </button>
                <p class="w3-small w3-text-black">Penyetoran dibuka 12 - 26 April 2026</p>
            <?php endif; ?>
        </form>
    </div>

    <div style="height: 30px;"></div>
    <div class="w3-center metal-text w3-large">
        Setoran Terakhir
    </div>
    <div class="glass-card w3-padding w3-center">
        <?php
        $query = "
        SELECT r.*, o.name
        FROM rides r
        JOIN orang o ON r.orang_id = o.id
        WHERE deleted_at IS NULL
        ORDER BY r.id DESC, r.input_time DESC LIMIT 10";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "<p class=\"w3-text-black\">Belum ada ride yang disetor.</p>";
        } else {
            echo "<ul style='list-style:none; padding-left:0; text-align:left;'>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li style='text-align: left; padding: 10px; border-bottom: 1px solid #ddd;'>";
                echo "<strong>{$row['name']}</strong><br>";
                echo "<small>" . date('d M Y H:i', strtotime($row['input_time'])) . "</small><br>";
                echo "<a href=\"{$row['link']}\" target=\"_blank\">{$row['link']}</a>";
                echo "</li>";
            }

            echo "</ul>";
        }
        ?>
    </div>
</div>
