<?php
$order = getRow('orders', $order_id);
$member = getRow('members', $order['member_id']);
?>
<div class="card">
    <span class="w3-large">
        Order #<?= $order_id ?> -
        <a href="?page=members&member_id=<?= $order['member_id'] ?>" class="w3-text-blue">
            <i class="fa-solid fa-circle-user"></i> <?= $member['name'] ?>
        </a>
    </span>
    <form method="post" onsubmit="return confirm('Edit Pesanan?')">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <input type="hidden" name="action" value="edit order">
        <!-- Member Entry -->
        <div>
            <div class="grid">
                <div>
                    <label>Kategori</label>
                    <select name="category">
                        <?php foreach ($categories as $v): ?>
                            <option value="<?= $v ?>" <?= $v == $order['category'] ? 'selected' : '' ?>>
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
                            <option value="<?= $v ?>" <?= $v == $order['size'] ? 'selected' : '' ?>>
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
                            <option value="<?= $v ?>" <?= $v == $order['variant'] ? 'selected' : '' ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Material</label>
                    <select name="material">
                        <?php foreach ($materials as $v): ?>
                            <option value="<?= $v ?>" <?= $v == $order['material'] ? 'selected' : '' ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Payment</label>
                    <input type="text" name="payment" value="<?= $order['payment'] ?>">
                </div>
            </div>
        </div>
        <button class="button">
            <i class="fa-solid fa-edit"></i> Edit Pesanan
        </button>
    </form>
</div>
