<style>
    .size-chart-link {
        font-size: 12px;
        color: #666;
        text-decoration: none;
    }

    .size-chart-link:hover {
        color: #000;
        text-decoration: underline;
    }

    .size-chart {
        display: none;
        margin-top: 10px;
    }

    .image {
        width: 100%;
        max-width: 500px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .jersey {
        margin-top: 10px;
    }
</style>
<?php
$can_add_order =
    $events[$event_id]['active'] == 1 &&
    (
        empty($orders) ||
        $events[$event_id]['nonmember'] > 0
    );

if ($can_add_order && $available):
    ?>
    <div class="card">
        <form method="post" onsubmit="return confirm('Tambah Pemesanan Jersey?')">
            <input type="hidden" name="member_id" value="<?= $member_id ?>">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <input type="hidden" name="type" value="<?= $events[$event_id]['type'] ?>">
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="hidden" name="action" value="add jersey">

            <!-- Member Entry -->
            <div class="jersey-entry">

                <div class="page-title">
                    PESANAN BARU (<?= count($orders) < 2 ? 'MEMBER' : 'FAMILY' ?>)
                </div>

                <a href="#" class="size-chart-link" onclick="toggleSizeChart(this); return false;">
                    📏 Lihat Size Chart
                </a>

                <div class="size-chart">
                    <a href="images/<?= $events[$event_id]['size_chart'] ?>" target="_blank">
                        <img class="image" src="images/<?= $events[$event_id]['size_chart'] ?>">
                    </a>
                </div>

                <div style="height:10px;"></div>

                <div class="grid">

                    <div>
                        <label>Kategori</label>
                        <select name="category">
                            <?php foreach ($categories as $v): ?>
                                <option value="<?= $v ?>">
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label>Ukuran</label>
                        <select name="size" required>
                            <option value="">-- Pilih Ukuran --</option>
                            <?php foreach ($sizes as $v): ?>
                                <option value="<?= $v ?>">
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label>Variasi</label>
                        <select name="variant">
                            <?php
                            $vcount = 0;
                            foreach ($variants as $v):
                                $vcount++;
                                if ($vcount >= 3) {
                                    continue;
                                }
                                ?>
                                <option value="<?= $v ?>">
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label>Material</label>
                        <select name="material">
                            <?php foreach ($materials as $v): ?>
                                <option value="<?= $v ?>">
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>


            <button class="add-btn">
                <i class="fa-solid fa-circle-plus"></i> Tambah Pesanan
            </button>
        </form>
    </div>
<?php endif; ?>

<script>
    function toggleSizeChart(el) {
        const chart = el.nextElementSibling;

        if (chart.style.display === 'block') {
            chart.style.display = 'none';
            el.innerHTML = '📏 Lihat Size Chart';
        } else {
            chart.style.display = 'block';
            el.innerHTML = '✕ Tutup Size Chart';
        }
    }
</script>
