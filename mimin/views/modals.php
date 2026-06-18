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
