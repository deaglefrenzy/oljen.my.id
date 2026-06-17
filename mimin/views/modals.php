<style>
    .custom-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;

        background: rgba(0, 0, 0, .45);

        overflow-y: auto;
    }

    .custom-modal-content {
        background: #fff;

        width: min(420px, calc(100% - 40px));

        margin: 20px auto;

        border-radius: 18px;
        padding: 20px;

        box-sizing: border-box;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        margin-bottom: 18px;

        font-size: 18px;
        font-weight: 700;
    }

    .close-btn {
        border: none;
        background: none;

        font-size: 28px;
        cursor: pointer;
    }

    .custom-modal input[type=text] {
        width: 100%;

        padding: 12px;

        margin-bottom: 15px;

        border: 1px solid #ccc;
        border-radius: 12px;

        box-sizing: border-box;
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
</style>

<div id="addMemberModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="modal-header">
            <span>Tambah Member Baru</span>
            <button type="button" class="close-btn"
                onclick="document.getElementById('addMemberModal').style.display='none'">
                &times;
            </button>
        </div>
        <form method="post">
            <input type="hidden" name="action" value="add member">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="ortu" placeholder="Nama Orang Tua">
            <input type="text" name="hp" placeholder="No. HP">
            <input type="text" name="alamat" placeholder="Alamat">
            <label>Tanggal Lahir:</label>
            <input type="date" name="tgl_lahir" required>
            <label>Tanggal Join:</label>
            <input type="date" name="tgl_join" value="<?= date('Y-m-d') ?>">
            <label>Tipe Iuran:</label>
            <div class="pill-select">
                <?php
                foreach ($bulanan as $key => $value):
                    ?>
                    <input type="radio" id="sekolah<?= $key ?>" name="sekolah" value="<?= $key ?>" <?= $key == 1 ? 'checked' : '' ?>>
                    <label for="sekolah<?= $key ?>">
                        <?= $value['nama'] ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <input type="text" name="school" placeholder="Sekolah">
            <button type="submit" class="button">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </form>
    </div>
</div>

<div id="editMemberModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="modal-header">
            <span>Edit Member</span>
            <button type="button" class="close-btn"
                onclick="document.getElementById('editMemberModal').style.display='none'">
                &times;
            </button>
        </div>
        <form method="post">
            <input type="hidden" name="action" value="edit member">
            <input type="hidden" name="members_id" value="<?= $memberID ?>">
            <input type="text" name="nama" placeholder="Nama Lengkap" required
                value="<?= $members[$memberID]['nama'] ?>">
            <input type="text" name="ortu" placeholder="Nama Orang Tua" value="<?= $members[$memberID]['ortu'] ?>">
            <input type="text" name="hp" placeholder="No. HP" value="<?= $members[$memberID]['hp'] ?>">
            <input type="text" name="alamat" placeholder="Alamat" value="<?= $members[$memberID]['alamat'] ?>">
            <label>Tanggal Lahir:</label>
            <input type="date" name="tgl_lahir" required value="<?= $members[$memberID]['tgllahir'] ?>">
            <label>Tanggal Join:</label>
            <input type="date" name="tgl_join" value="<?= $members[$memberID]['tgljoin'] ?>">
            <label>Tipe Iuran:</label>
            <div class="pill-select">
                <?php
                foreach ($bulanan as $key => $value):
                    $radioID = 'sekolah_' . md5($key); ?>

                    <input type="radio" id="<?= $radioID ?>" name="sekolah" value="<?= $key ?>"
                        <?= $key == $members[$memberID]['sekolah'] ? 'checked' : '' ?>>

                    <label for="<?= $radioID ?>">
                        <?= $value['nama'] ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <input type="text" name="school" placeholder="Sekolah" value="<?= $members[$memberID]['school'] ?>">
            <button type="submit" class="button">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </form>
    </div>
</div>

<div id="addIuranModal" class="custom-modal" onclick="if(event.target === this) this.style.display='none'">
    <div class="custom-modal-content">
        <div class="modal-header">
            <span><?= $members[$memberID]['nama'] ?></span>
            <button type="button" class="close-btn"
                onclick="document.getElementById('addIuranModal').style.display='none'">
                &times;
            </button>
        </div>
        <?php $photo = $members[$memberID]['foto'] ?? '';
        $hasPhoto = !empty($photo) && file_exists("foto/$photo");
        ?>
        <div class="profile-photo">
            <?php if ($hasPhoto): ?>
                <img src="foto/<?= $photo ?>" alt="Photo">
            <?php else: ?>
                <div class="photo-placeholder">
                    <i class="fa-solid fa-user"></i>
                </div>
            <?php endif; ?>
        </div>
        <br>
        <span class="w3-medium">
            <b>Tipe Iuran:</b>
            <?= $bulanan[$members[$memberID]['sekolah']]['nama'] . " (Rp" . desimal($bulanan[$members[$memberID]['sekolah']]['tarif'], 0) . ")" ?>
        </span>
        <form method="post">
            <input type="hidden" name="action" value="add iuran">
            <input type="hidden" name="member_id" required value="<?= $memberID ?>">
            <label>Jumlah Dibayar:</label>
            <input type="number" name="jumlah" required onfocus="this.select()" step="1000"
                value="<?= $bulanan[$members[$memberID]['sekolah']]['tarif'] ?>">
            <label>Tanggal Bayar:</label>
            <input type="date" name="tglbayar" value="<?= $date ?>" required>
            <label>Periode Iuran:</label>
            <input type="month" name="periode" value="<?= date("Y-m", strtotime($date)) ?>" required>
            <button type="submit" class="button">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </form>
    </div>
</div>

<div id="editTipeIuranModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="modal-header">
            <span>Edit Tipe Iuran</span>
            <button type="button" class="close-btn"
                onclick="document.getElementById('editTipeIuranModal').style.display='none'">
                &times;
            </button>
        </div>
        <form method="post">
            <input type="hidden" name="action" value="edit tipe iuran">
            <?php foreach ($bulanan as $key => $value): ?>
                <label><?= $value['nama'] ?>:</label>
                <input type="number" name="tarif[<?= $key ?>]" required value="<?= $value['tarif'] ?>" step="1000">
            <?php endforeach; ?>
            <button type="submit" class="button">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </form>
    </div>
</div>
