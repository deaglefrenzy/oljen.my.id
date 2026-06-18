<div class="card summary">
    <div class="page-title">
        PESANAN
    </div>
    <?php
    $count = 0;
    $total = 0;
    foreach ($orders as $i => $order): ?>
        <?php
        $count++;
        $is_member = ($count <= count($related_ids[$order['member_id']]) + 1);
        $event = $events[$order['event_id']];
        $base = ($is_member)
            ? $event['base']
            : $event['nonmember'];
        $oversize = ($order['size'] == "3XL")
            ? (($order['material'] == "DRYFIT")
                ? $event['oversize'] - 15000
                : $event['oversize'])
            : 0;
        $long = ($order['variant'] == "Lengan Panjang")
            ? (($order['material'] == "DRYFIT")
                ? $event['longsleeves'] - 20000
                : $event['longsleeves'])
            : 0;
        $upgrade = ($order['material'] == "PRO")
            ? $event['upgrade']
            : 0;
        $subtotal = $base + $oversize + $long + $upgrade;
        $total += $subtotal;
        ?>
        <div class="order-summary">
            <div class="order-header">
                <div>
                    <b>
                        <?= $is_member ? "<i class='fa-solid fa-circle-user'></i> Member" : "<i class='fa-solid fa-house-user'></i> Family" ?>
                        #<?= $count ?>
                    </b>
                    <div class="w3-small w3-text-gray">
                        <?= $order['type'] ?>
                        ·
                        <?= $order['category'] ?>
                        ·
                        <?= $order['size'] ?>
                    </div>
                </div>
                <form method="post" onsubmit="return confirm('Hapus jersey ini dari pemesanan?')">
                    <input type="hidden" name="action" value="remove order">
                    <input type="hidden" name="id" value="<?= $i ?>">
                    <button class="remove-btn" type="submit" <?= $available ? '' : 'disabled' ?>>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>
            </div>
            <div class="price-row main-price">
                <span>Jersey</span>
                <span>Rp
                    <?= number_format($base) ?>
                </span>
            </div>
            <?php if ($oversize): ?>
                <div class="price-row extra">
                    <span>+ Oversize
                        <?= $order['size'] ?>
                    </span>
                    <span>Rp
                        <?= number_format($oversize) ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($long): ?>
                <div class="price-row extra">
                    <span>+ Lengan Panjang</span>
                    <span>Rp
                        <?= number_format($long) ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($upgrade): ?>
                <div class="price-row extra">
                    <span>+ Material PRO</span>
                    <span>Rp
                        <?= number_format($upgrade) ?>
                    </span>
                </div>
            <?php endif; ?>
            <div class="price-row subtotal">
                <span>Subtotal</span>
                <span>Rp
                    <?= number_format($subtotal) ?>
                </span>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="payment-summary">
        <div class="payment-total">
            <div class="label">Total Pembayaran</div>
            <div class="amount">
                Rp
                <?= number_format($total) ?>
            </div>
        </div>
        <hr>
        <div class="transfer-info">
            <h3>Informasi Transfer</h3>
            <table class="transfer-table">
                <tr>
                    <td>Bank</td>
                    <td>: BCA</td>
                </tr>
                <tr>
                    <td>No. Rekening</td>
                    <td>: 7970148480</td>
                </tr>
                <tr>
                    <td>Atas Nama</td>
                    <td>: Suryo Sucianto</td>
                </tr>
            </table>
            <div class="note">
                Silakan transfer sesuai nominal di atas dan kirim bukti pembayaran ke
                <a href="
                                https://wa.me/6282187257433?text=Bukti%20pembayaran
                                ">
                    Admin Oljen
                </a>.
            </div>
        </div>
    </div>
    <div class="w3-small w3-text-gray w3-center">
        <i class="fa-solid fa-circle-info"></i> Anda masih dapat menambah pesanan lewat menu di bawah sampai
        <?= date('d/m/Y', strtotime($end_date)) ?>.
    </div>
</div>
