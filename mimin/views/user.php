<style>
    .account-page {
        max-width: 500px;
        margin: auto;
        padding: 16px;
    }

    .account-card {
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 20px;
        color: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    }

    .account-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .account-avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .account-title {
        font-size: 18px;
        font-weight: 700;
    }

    .account-subtitle {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.65);
        margin-top: 3px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.75);
    }

    .form-group input {
        width: 100%;
        height: 46px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        padding: 0 14px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #3b82f6;
        background: rgba(255, 255, 255, 0.08);
    }

    hr {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin: 24px 0;
    }
</style>

<div class="account-page">
    <div class="account-card">
        <div class="account-header">
            <div class="account-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <div class="account-title">
                    <?= $login_name ?>
                </div>
            </div>
        </div>
        <form method="post">
            <input type="hidden" name="action" value="update password">
            <input type="hidden" name="user_id" value="<?= $admin_id ?>">
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="new_password" placeholder="Kosongkan jika tidak diubah"
                    onfocus="this.select()">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" placeholder="Ulangi password baru"
                    onfocus="this.select()">
            </div>
            <button type="submit" class="button">
                <i class="fa-solid fa-key"></i>
                Ubah Password
            </button>
        </form>
    </div>
    <br>
    <button class="button danger" onclick="location.href='auth/logout.php'">
        <i class="fa-solid fa-right-from-bracket"></i>
        Keluar
    </button>
</div>
