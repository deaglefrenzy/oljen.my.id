<?php
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$query = "
SELECT r.*, o.name
FROM rides r
JOIN orang o ON r.orang_id = o.id
WHERE DATE(r.input_time)='$tanggal'
ORDER BY r.id DESC, r.input_time DESC";
$q = mysqli_query($conn, $query);
$ridesByDate = [];
while ($row = mysqli_fetch_assoc($q)) {
    $tanggal = date('Y-m-d', strtotime($row['input_time']));
    $ridesByDate[$tanggal][] = $row;
}
?>
<div class="card">
    <form method="get">
        <input type="date" name="tanggal" value="<?= $tanggal ?>" required onchange="this.form.submit();">
    </form>
</div>
<div class="card">
    <?php if (!$ridesByDate): ?>
        <div class="empty">No data</div>
    <?php else: ?>
        <div class="rides">
            <?php
            $count = 0;
            foreach ($ridesByDate[$tanggal] as $r):
                $count++;
            ?>
                <div class="ride-card">

                    <!-- Header -->
                    <div class="ride-header">
                        <span class="ride-number"><?= $count ?></span>
                        <div>
                            <div class="ride-time"><?= $r['input_time'] ?></div>
                            <div class="ride-name"><?= $r['name'] ?></div>
                        </div>
                    </div>

                    <!-- Actions Row -->
                    <div class="ride-actions">

                        <!-- Delete -->
                        <form method="post" onsubmit="return confirm('Hapus ride?');">
                            <input type="hidden" name="ride_id" value="<?= $r['id'] ?>">
                            <?php if (empty($r['deleted_at'])): ?>
                                <button type="submit" name="action" value="delete ride" style="width: 40px; height:45px;">❌</button>
                            <?php else: ?>
                                <span class="deleted">Deleted</span>
                            <?php endif; ?>
                        </form>

                        <!-- Date -->
                        <form method="post">
                            <input type="hidden" name="ride_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="action" value="edit tanggal">
                            <input type="date"
                                name="tanggal"
                                value="<?= date('Y-m-d', strtotime($r['input_time'])) ?>"
                                onchange="this.form.submit();">
                        </form>

                        <!-- Distance -->
                        <form method="post">
                            <input type="hidden" name="ride_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="action" value="edit distance">
                            <input
                                type="text"
                                name="distance"
                                value="<?= $r['distance'] ?>"
                                inputmode="numeric"
                                class="<?= ($r['distance'] == 0 ? 'distance-zero' : '') ?>"
                                style="text-align:right;"
                                onfocus="this.select();"
                                onclick="this.select();">
                        </form>
                    </div>

                    <!-- Link -->
                    <div class="ride-link">
                        <a href="<?= $r['link'] ?>" target="_blank">
                            🔗 <?= $r['link'] ?>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
