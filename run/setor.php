<?php
include_once 'setor_data.php';
?>
<div class="w3-content w3-center" style="width: 90%; max-width: 480px; text-align: center;">
    <div class="w3-card w3-white w3-padding-large w3-round-large"
        style="max-width:500px; margin:auto; margin-top:30px;">
        <form method="post" onsubmit="return confirm('Setor run ini?');">
            <h3 class="w3-center w3-margin-bottom font4 w3-xxlarge" style="font-weight:600;">
                <i class="fa-solid fa-person-running"></i> Setor Run
            </h3>
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
            <!-- Strava Link -->
            <div class="w3-margin-bottom">
                <input type="text" name="link" placeholder="https://strava.app.link/xxxx"
                    class="w3-input w3-border w3-round-large w3-padding" style="font-size:16px;" required
                    autocomplete="off">
                <div class="w3-right w3-small w3-text-grey">
                    <i class="fa-brands fa-strava"></i> Link Run
                </div>
            </div>
            <br>
            <!-- Action -->
            <div class="w3-center w3-margin-top">
                <?php if ($is_available): ?>
                    <button type="submit" name="action" value="setor run"
                        class="w3-button w3-round-large w3-xlarge w3-padding-large w3-hover-shadow" style="
                        width:100%;
                        background: linear-gradient(135deg, #4CAF50, #2e7d32);
                        color:white;
                        font-weight:600;
                        letter-spacing:0.5px;
                    ">
                        <i class="fa-solid fa-check-circle"></i> SETOR RUN
                    </button>
                <?php else: ?>
                    <button type="button" class="w3-button w3-grey w3-round-large w3-xlarge w3-padding-large"
                        style="width:100%;" disabled>
                        <i class="fa-solid fa-lock"></i> CLOSED
                    </button>
                    <p class="w3-small w3-text-grey w3-margin-top">
                        Penyetoran dibuka 15 - 24 Mei 2026
                    </p>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <div style="height: 50px;"></div>
    <?php
    $query = "
    SELECT r.*, o.name
    FROM runs r
    JOIN orang o ON r.orang_id = o.id
    WHERE deleted_at IS NULL
    ORDER BY r.id DESC, r.input_time DESC LIMIT 15";
    $result = mysqli_query($conn, $query);
    ?>
    <div class="w3-large w3-margin-bottom w3-text-white" style="font-weight:600;">
        <i class="fa-solid fa-clock-rotate-left"></i> Setoran Terakhir
    </div>
    <div class="w3-white w3-border w3-round">
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<div class='w3-padding w3-text-grey'>Belum ada runs yang disetor.</div>";
        } else {
            echo "<ul class='w3-ul w3-small'>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li style='padding:8px 12px;'>";
                // Single compact line
                echo "<div class='w3-left-align'>";
                echo "<strong>{$row['name']}</strong>";
                echo " <span class='w3-text-grey' style='font-size:11px;'>";
                echo date('d M H:i', strtotime($row['input_time']));
                echo "</span>";
                echo "<br>";
                echo "<a href=\"{$row['link']}\" target=\"_blank\" class='w3-text-blue' style='text-decoration:none; font-size:12px;'>";
                echo "<i class='fa-brands fa-strava'></i> {$row['link']}";
                echo "</a>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
</div>
