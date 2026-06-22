<style>
    .summary {
        background: #f0f8ff;
    }

    .order-summary {
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
    }

    .main-price {
        font-size: 1.05em;
    }

    .extra {
        color: #666;
        padding-left: 15px;
        font-size: .9em;
    }

    .subtotal {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
        font-weight: bold;
        font-size: 1.1em;
    }

    .remove-btn {
        border: 0;
        background: #f44336;
        color: white;
        border-radius: 6px;
        width: 32px;
        height: 32px;
        cursor: pointer;
    }

    .remove-btn:hover {
        opacity: .9;
    }

    .total {
        font-size: 22px;
        font-weight: bold;
        border-top: 1px solid #ccc;
        padding-top: 10px;
        margin-top: 10px;
    }

    .payment-summary {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .payment-total {
        text-align: center;
        margin-bottom: 20px;
    }

    .payment-total .label {
        color: #777;
        font-size: 14px;
    }

    .payment-total .amount {
        font-size: 32px;
        font-weight: bold;
        color: #2e7d32;
        margin-top: 8px;
    }

    .transfer-info {
        margin-top: 20px;
    }

    .transfer-table {
        width: 100%;
        border-collapse: collapse;
    }

    .transfer-table td {
        padding: 6px 0;
    }

    .note {
        margin-top: 12px;
        padding: 10px;
        background: #fff8e1;
        border-radius: 8px;
        font-size: 14px;
    }
</style>
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
        $base = $order['payment'] - $oversize - $long - $upgrade;
        $subtotal = $base + $oversize + $long + $upgrade;
        $total += $subtotal;
        ?>
        <div class="order-summary">
            <div class="order-header">
                <div>
                    <?php $isMemberPrice = ($base == $event['base']); ?>

                    <span class="w3-tag w3-round <?= $isMemberPrice ? 'w3-green' : 'w3-blue' ?>">
                        #<?= $count ?>
                    </span>

                    <span class="w3-tag w3-round <?= $isMemberPrice ? 'w3-pale-green' : 'w3-pale-blue' ?>">
                        <i class="fa-solid <?= $isMemberPrice ? 'fa-circle-user' : 'fa-house-user' ?>"></i>
                        <?= $isMemberPrice ? 'Member' : 'Family' ?>
                    </span>
                    <div class="w3-small w3-text-gray">
                        <?= $order['type'] ?>
                        ·
                        <?= $order['category'] ?>
                        ·
                        <?= $order['size'] ?>
                    </div>
                </div>
                <?php if ($order['status'] == 0): ?>
                    <form method="post" onsubmit="return confirm('Hapus jersey ini dari pemesanan?')">
                        <input type="hidden" name="action" value="remove order">
                        <input type="hidden" name="id" value="<?= $i ?>">
                        <button class="remove-btn" type="submit" <?= $available ? '' : 'disabled' ?>>
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="price-row main-price">
                <span>Jersey <?= $order['material'] ?></span>
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
            <?php if ($order['status'] == 1): ?>
                <div class="w3-pale-green w3-border-green w3-center">
                    <b class="w3-text-green"><i class="fa-solid fa-circle-check"></i> LUNAS</b>
                </div>
            <?php endif; ?>
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
