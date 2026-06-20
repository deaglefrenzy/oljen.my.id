<style>
    .deleted-row {
        opacity: .60;
        color: red;
    }

    .deleted-row .w3-tag {
        background: red !important;
        color: #fff !important;
    }
</style>

<table align="center" width="100%">
    <tbody class="w3-small">
        <?php
        $count = 0;
        foreach ($result as $r):
            $count++;
            $rowClass = $r['deleted_at'] ? 'deleted-row' : '';
            ?>
            <tr>
                <td colspan="5" style="background:#999; height:1px;"></td>
            </tr>
            <tr class="<?= $rowClass ?>">
                <td rowspan="2" align="center" width="50px">
                    <form method="post" onsubmit="return confirm('Hapus Pesanan?')">
                        <input type="hidden" name="order_id" value="<?= $r['id'] ?>">
                        <input type="hidden" name="action" value="remove order">
                        <button type="submit" class="topbar-btn w3-text-red">
                            <i class="fa-solid fa-trash w3-medium"></i>
                        </button>
                    </form>
                </td>
                <td colspan="2" class="w3-tiny">
                    <?php if ($r['deleted_at']): ?>
                        <span class="w3-tag w3-round-large w3-red">
                            BATAL
                        </span>
                    <?php endif; ?>

                    <span class="w3-opacity">
                        <?= date('d M Y H:i', strtotime($r['created_at'])) ?>
                    </span>
                </td>
                <td align="right" rowspan="2" class="w3-medium">
                    <form method="post">
                        <input type="hidden" name="action" value="lunas order">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button type="submit" class="topbar-btn <?= $r['status'] ? 'w3-text-green' : 'w3-text-red' ?>">
                            <?= shortNominal($r['payment']) ?>&nbsp;
                            <?= $r['status'] ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-xmark"></i>' ?>
                        </button>
                    </form>
                </td>
                <td align="right" rowspan="2" class="w3-medium" style="padding-left: 15px;">
                    <a href="?page=orders&order_id=<?= $r['id'] ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </td>
            </tr>
            <tr class="<?= $rowClass ?>">
                <td style="line-height: 12px;">
                    <a href="?page=members&member_id=<?= $r['member_id'] ?>">
                        <?= $r['member_name'] ?> <i class="fa-solid fa-angle-right w3-opacity w3-tiny"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php


