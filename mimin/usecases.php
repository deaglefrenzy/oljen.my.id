<?php
$action = $_POST['action'] ?? '';

if ($action == "add member") {
    $nama = strtoupper($_POST['nama']);
    $ortu = $_POST['ortu'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tgl_join = $_POST['tgl_join'];
    $sekolah = $_POST['sekolah'];
    $school = $_POST['school'];
    $query = "INSERT INTO member (sekolah, nama, ortu, hp, alamat, tgllahir, tgljoin, school) VALUES (
    '$sekolah', '$nama', '$ortu', '$hp', '$alamat', '$tgl_lahir', '$tgl_join', '$school')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    pesan(
        "Member $nama berhasil ditambahkan",
        "?page=" . $page . "&member_id=" . mysqli_insert_id($conn)
    );
    $inserted = true;
}

if ($action == "edit member") {
    $id = $_POST['members_id'];
    $nama = $_POST['nama'];
    $ortu = $_POST['ortu'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tgl_join = $_POST['tgl_join'];
    $sekolah = $_POST['sekolah'];
    $school = $_POST['school'];
    $query = "
    UPDATE member SET
    sekolah = '$sekolah',
    nama = '$nama',
    ortu = '$ortu',
    hp = '$hp',
    alamat = '$alamat',
    tgllahir = '$tgl_lahir',
    tgljoin = '$tgl_join',
    school = '$school'
    WHERE idmember = '$id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    pesan(
        "Profil member berhasil diubah"
    );
}

if ($action == "delete iuran log") {
    $id = $_POST['id'];

    $query = "UPDATE iuran SET deleted_at = '$now', deleted_by = '$admin_id' WHERE idiuran = '$id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_query($conn, $query) or die(mysqli_error($conn));
    $inserted = true;
}

if ($action == "update password") {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != '') {
        if ($new_password == $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE user SET password = '$hashed_password' WHERE id = '$user_id'";
            mysqli_query($conn, $query) or die(mysqli_error($conn));
            pesan(
                "Password berhasil diperbarui",
                "?page=user"
            );
        } else {
            pesan(
                "Konfirmasi password tidak cocok",
                "?page=user"
            );
        }
    } else {
        pesan(
            "Password tidak diubah",
            "?page=user"
        );
    }
}

if ($action == "add iuran") {

    $member_id = $_POST['member_id'];
    $jumlah = $_POST['jumlah'];
    $tglbayar = $_POST['tglbayar'];
    $periode = date('Y-m-01', strtotime($_POST['periode']));

    $query = "
        SELECT COUNT(*) AS total
        FROM iuran
        WHERE
            idmember = '$member_id'
            AND periode = '$periode'
            AND deleted_at IS NULL
    ";

    $q = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $exists = mysqli_fetch_assoc($q)['total'];

    if ($exists > 0) {

        pesan(
            "Anggota sudah membayar iuran untuk periode ini.",
            "?page=iuran"
        );
        exit;

    }

    $query = "
        INSERT INTO iuran (
            idmember,
            tglbayar,
            periode,
            jumlah,
            iduser,
            created_at
        ) VALUES (
            '$member_id',
            '$tglbayar',
            '$periode',
            '$jumlah',
            '$admin_id',
            '$now'
        )
    ";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    $inserted = true;
}

if ($action == "edit tipe iuran") {
    $tarif = $_POST['tarif'];

    foreach ($tarif as $key => $value) {
        $query = "UPDATE bulanan SET tarif = '$value' WHERE id = '$key'";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    }

    pesan(
        "Tipe iuran berhasil diperbarui"
    );
}

if ($action == 'upload photo' && !empty($_FILES['foto']['name'])) {

    $member_id = (int) $_POST['member_id'];

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $filename = 'member_' . $member_id . '_' . time() . '.' . $ext;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        'foto/' . $filename
    );

    mysqli_query(
        $conn,
        "UPDATE member SET foto='$filename' WHERE idmember='$member_id'"
    );

}
