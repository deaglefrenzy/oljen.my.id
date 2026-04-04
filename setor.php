<?php
include_once 'setor_data.php';
?>
<div class="w3-content w3-center" style="width: 90%; max-width: 480px; text-align: center; margin-top:10px;">
    <div class="w3-center metal-text">
        Setor Ride
    </div>
    <form method="post">
        <div class="filter-row">
            <div class="glass-select-wrap">
                <select name="orang_id" class="glass-select w3-large">
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
        <input type="text" name="link" placeholder="Contoh: https://strava.app.link/YH8fP9vSnSb" class="w3-input w3-border w3-margin-bottom" required>
        <?php if ($is_available): ?>
            <button type="submit" name="action" value="setor ride" class="w3-button w3-green w3-margin-bottom w3-round w3-xlarge">
                <i class="fa-regular fa-floppy-disk"></i> SETOR
            </button>
        <?php else: ?>
            <button type="button" class="w3-button w3-grey w3-margin-bottom w3-round w3-xlarge" disabled>
                <i class="fa-solid fa-lock"></i> CLOSED
            </button>
            <p class="w3-small w3-text-white">Penyetoran dibuka 12 - 26 April 2026</p>
        <?php endif; ?>
    </form>
</div>
