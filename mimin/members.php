<?php
$memberID = isset($_GET['member_id']) ? (int) $_GET['member_id'] : null;

// SEARCH
include("member_search.php");
if (!empty($memberID)) {
    include("members_profile.php");
} else {
    $members = getData('members', 'active = 1', 'name ASC');
    ?>
    <div class="card">
        <?php if (!isset($members)): ?>
            <div class="empty">Belum ada data</div>
        <?php else: ?>
            <table align="center" width="100%">
                <tbody class="w3-small">
                    <?php
                    $count = 0;
                    foreach ($members as $r):
                        $count++;
                        ?>
                        <tr onclick="location.href='?page=members&member_id=<?= $r['id'] ?>'" style="cursor:pointer;">
                            <td width="30" class="w3-opacity">
                                <?= $count ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($r['name']) ?>

                                <div class="w3-tiny w3-opacity">
                                    <?php
                                    if (!empty($r['dob'])) {
                                        $umur = (new DateTime($r['dob']))->diff(new DateTime());
                                        echo $umur->y . " thn " . $umur->m . " bln";
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </div>
                            </td>

                            <td width="20" align="right" class="w3-opacity">
                                <i class="fa-solid fa-chevron-right"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" style="background:#999; height:1px;"></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php } ?>

