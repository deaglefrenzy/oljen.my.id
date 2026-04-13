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
        <table align="center" width="100%">
            <tbody>
                <?php
                $count = 0;
                foreach ($ridesByDate[$tanggal] as $r):
                    $count++;
                ?>
                    <tr>
                        <td colspan="4" style="background:#999; height:1px;"></td>
                    </tr>
                    <tr>
                        <td width=25><?= $count ?></td>
                        <td class="w3-small">
                            <?= $r['input_time'] ?>
                            <br>
                            <?= $r['name'] ?>
                        </td>
                        <form method="post" onsubmit="return confirm('Hapus ride?');">
                            <td class="w3-small">
                                <?php if (empty($r['deleted_at'])): ?>
                                    <button type="submit" name="action" value="delete ride" class="w3-tiny w3-red w3-button w3-round">🗑️</button>
                                <?php endif; ?>
                            </td>
                        </form>
                        <form method="post">
                            <input type="hidden" name="ride_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="action" value="edit distance">
                            <td align="right">
                                <input
                                    type="text"
                                    name="distance"
                                    value="<?= $r['distance'] ?>"
                                    inputmode="numeric"
                                    style="text-align:right; width: 60px;"
                                    onfocus="this.select();"
                                    onclick="this.select();">
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <td colspan="4" class="w3-small">
                            <a href="<?= $r['link'] ?>" target="_blank"><i class="fa fa-link"></i> <?= $r['link'] ?></a>
                        </td>
                    </tr>
                    <!-- <tr>
                        <form method="post">
                            <input type="hidden" name="ride_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="action" value="edit note">
                            <td colspan="2" class="w3-small">
                                <input type="text" name="link" value="<?= $r['link'] ?>">
                            </td>
                            <td><input type="text" name="pesan" placeholder="pesan" value="<?= $r['pesan'] ?>"></td>
                        </form>
                    </tr> -->
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="background:#999; height:1px;"></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>
