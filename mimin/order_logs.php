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
                    <?php
                    if (!$r['deleted_at']) {
                        ?>
                        <form method="post" onsubmit="return confirm('Batalkan iuran?')">
                            <input type="hidden" name="action" value="delete iuran log">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button type="submit" class="topbar-btn w3-text-red">
                                <i class="fa-solid fa-trash w3-medium"></i>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
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
                <td align="right" rowspan="2" class="w3-medium deleted-amount">
                    <?php if (!$r['deleted_at']): ?>
                        <a href="kwitansi.php?idiuran=<?= $r['id'] ?>" target="_blank" class="w3-text-indigo"
                            style="margin-left:4px;">
                            <?= shortNominal($r['payment']) ?>
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="<?= $rowClass ?>">
                <td style="line-height: 12px;">
                    <a href="?page=members&idmember=<?= $r['member_id'] ?>">
                        <?= $r['member_name'] ?> <i class="fa-solid fa-angle-right w3-opacity w3-tiny"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php


