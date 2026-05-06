<?php
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$query = "
SELECT r.*, o.name
FROM runs r
JOIN orang o ON r.orang_id = o.id
WHERE DATE(r.input_time)='$tanggal'
ORDER BY r.id DESC, r.input_time DESC";
$q = mysqli_query($conn, $query);
$runsByDate = [];
while ($row = mysqli_fetch_assoc($q)) {
    $tanggal = date('Y-m-d', strtotime($row['input_time']));
    $runsByDate[$tanggal][] = $row;
}
?>
<div class="card">
    <form method="get">
        <input type="date" name="tanggal" value="<?= $tanggal ?>" required onchange="this.form.submit();">
    </form>
</div>
<div class="card">
    <?php if (!$runsByDate): ?>
        <div class="empty">No data</div>
    <?php else: ?>
        <div class="runs">
            <?php
            $count = 0;
            foreach ($runsByDate[$tanggal] as $r):
                $count++;
                ?>
                <div class="run-card">

                    <!-- Header -->
                    <div class="run-header">
                        <span class="run-number"><?= $count ?></span>
                        <div>
                            <div class="run-time"><?= $r['input_time'] ?></div>
                            <div class="run-name"><?= $r['name'] ?></div>
                        </div>
                    </div>

                    <!-- Actions Row -->
                    <div class="run-actions">

                        <!-- Delete -->
                        <form method="post" onsubmit="return confirm('Hapus run?');">
                            <input type="hidden" name="run_id" value="<?= $r['id'] ?>">
                            <?php if (empty($r['deleted_at'])): ?>
                                <button type="submit" name="action" value="delete run" style="width: 40px; height:45px;">❌</button>
                            <?php else: ?>
                                <span class="deleted">Deleted</span>
                            <?php endif; ?>
                        </form>

                        <!-- Date -->
                        <form method="post">
                            <input type="hidden" name="run_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="action" value="edit tanggal">
                            <input type="date" name="tanggal" value="<?= date('Y-m-d', strtotime($r['input_time'])) ?>"
                                onchange="this.form.submit();">
                        </form>

                        <!-- Distance -->
                        <form method="post">
                            <input type="hidden" name="run_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="orang_id" value="<?= $r['orang_id'] ?>">
                            <input type="hidden" name="input_time" value="<?= $r['input_time'] ?>">
                            <input type="hidden" name="action" value="edit distance">
                            <input type="text" name="distance" value="<?= $r['distance'] ?>" inputmode="numeric"
                                class="<?= ($r['distance'] == 0 ? 'distance-zero' : '') ?>" style="text-align:right;"
                                onfocus="this.select();" onclick="this.select();">
                        </form>
                    </div>

                    <!-- Link -->
                    <div class="run-link">
                        <a href="<?= $r['link'] ?>" target="_blank">
                            🔗 <?= $r['link'] ?>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
