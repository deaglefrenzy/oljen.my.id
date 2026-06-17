<style>
    .profile-card {
        max-width: 800px;
        margin: auto;
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
    }

    .profile-header {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 15px;
    }

    .profile-photo {
        position: relative;
        width: 120px;
        height: 120px;
        flex-shrink: 0;
    }

    .profile-photo img,
    .photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #eee;
    }

    .photo-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        color: #999;
        font-size: 40px;
    }

    .photo-btn {
        position: absolute;
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .2);
        cursor: pointer;
    }

    .view-btn {
        top: 4px;
        right: 4px;
    }

    .edit-btn {
        bottom: 4px;
        right: 4px;
    }

    .photo-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .8);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .photo-modal img {
        max-width: 95%;
        max-height: 95%;
        border-radius: 12px;
    }

    .profile-info {
        flex: 1;
    }

    .profile-info h2 {
        margin: 0;
        font-size: 24px;
        line-height: 1.2;
    }

    .member-status {
        display: inline-block;
        margin-top: 5px;
        margin-bottom: 8px;
        padding: 4px 10px;
        background: #f3f3f3;
        border-radius: 999px;
        font-size: 12px;
        color: #555;
    }

    .profile-details {
        border-top: 1px solid #eee;
        margin-top: 12px;
        padding-top: 12px;
    }

    .profile-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .profile-table td {
        padding: 4px 0;
        vertical-align: top;
    }

    .profile-table td:first-child {
        width: 110px;
        color: #777;
        font-weight: 600;
        white-space: nowrap;
    }

    .profile-table td:nth-child(2) {
        width: 10px;
        color: #bbb;
    }

    .profile-table td:last-child {
        color: #222;
    }

    @media (max-width: 600px) {
        .profile-header {
            align-items: center;
        }

        .profile-info h2 {
            font-size: 20px;
        }
    }

    .order-link-box {
        max-width: 500px;
    }

    #order-link {
        word-break: break-all;
        font-weight: bold;
    }

    .copy-btn {
        border: 0;
        padding: 8px 14px;
        border-radius: 8px;

        background: #2196F3;
        color: white;

        cursor: pointer;
    }

    .copy-btn:hover {
        opacity: .9;
    }
</style>
<div class="profile-card">
    <div class="profile-header">
        <?php
        $photo = $members[$memberID]['foto'] ?? '';
        $hasPhoto = !empty($photo) && file_exists("foto/$photo");
        ?>
        <form method="post" enctype="multipart/form-data" id="photoForm">
            <input type="hidden" name="action" value="upload photo">
            <input type="hidden" name="member_id" value="<?= $memberID ?>">
            <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none"
                onchange="document.getElementById('photoForm').submit()">
            <div class="profile-photo">
                <?php if ($hasPhoto): ?>
                    <img src="foto/<?= $photo ?>" alt="Photo">
                    <button type="button" class="photo-btn view-btn" onclick="openPhotoPreview('foto/<?= $photo ?>')">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                <?php else: ?>
                    <div class="photo-placeholder">
                        <i class="fa-solid fa-user"></i>
                    </div>
                <?php endif; ?>
                <button type="button" class="photo-btn edit-btn" onclick="document.getElementById('fotoInput').click()">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>
        </form>
        <div class="profile-info">
            <h2>
                <?= htmlspecialchars($members[$memberID]['name']) ?>
            </h2>
            <button class="button" onclick="openModal('editMemberModal',<?= $memberID ?>)">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Profil
            </button>
        </div>
    </div>
    <div class="profile-details">
        <table class="profile-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= htmlspecialchars($members[$memberID]['name']) ?></td>
            </tr>
            <tr>
                <td>Lahir</td>
                <td>:</td>
                <td>
                    <?php
                    if (!empty($members[$memberID]['dob'])) {
                        $lahir = new DateTime($members[$memberID]['dob']);
                        $umur = $lahir->diff(new DateTime());

                        echo date('d M Y', strtotime($members[$memberID]['dob']));
                        echo " • {$umur->y} thn {$umur->m} bln";
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Order Link</td>
                <td>:</td>
                <td>

                    <div class="order-link-box">

                        <?php
                        $link = "https://oljen.my.id/order/?token=" . $members[$memberID]['token'];
                        ?>

                        <a href="<?= $link ?>" target="_blank" id="order-link">
                            <?= $link ?>
                        </a>

                            <br><br>
 
                              <but ton type="button" class="copy-btn" onclick="copyOrderLink()">
                                📋 Copy Link
                        </button>

                    </div>

                </td>
            </tr>
        </table>
    </div>
</div>

<div style="height: 20px;"></div>

<?php
$query = "
SELECT
o.*,
m.name AS member_name
FROM orders o
LEFT JOIN members m ON o.member_id = m.id
WHERE o.member_id = $memberID
ORDER BY o.id ASC
";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
include("order_logs.php");
?>

<div id="photoModal" class="photo-modal" onclick="closePhotoPreview()">
    <img id="photoModalImg" src="">
</div>
<script>
    function openPhotoPreview(src) {
        document.getElementById('photoModalImg').src = src;
        document.getElementById('photoModal').style.display = 'flex';
    }
    function closePhotoPreview() {
        document.getElementById('photoModal').style.display = 'none';
    }
</script>

<script>
    function copyOrderLink() {

        const text = `Halo <?= $members[$memberID]['name'] ?>!
Pemesanan jersey event OLJEN dapat dilakukan melalui link berikut:

<?= $link ?>


Link ini bersifat unik dan terhubung hanya dengan data member <?= $members[$memberID]['name'] ?>,
jadi harap jangan sebarkan link ini kepada member/orang lain.
Pakai link ini juga untuk pemesanan jersey event-event OLJEN berikutnya.

Silakan lengkapi pesanan dan kirimkan bukti pembayaran di chat admin.

Terima kasih.`;

        navigator.clipboard.writeText(text);
    }
</script>
