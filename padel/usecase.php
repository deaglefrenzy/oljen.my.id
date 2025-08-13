<?php
if ($action == "updateskor") {
    $idmatch = $_POST['idmatch'];
    $score_a = $_POST['score_a'];
    $score_b = 24 - $score_a;
    if (is_numeric($score_a) && $score_a >= 0 && $score_a <= 24) {
        $query = "UPDATE pmatch SET score_a='$score_a', score_b='$score_b' WHERE id='$idmatch'";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    } else pesan("Skor tidak valid. Harus berupa angka antara 0 dan 16.");
}

if ($action == "urutanmatch") {
    $idmatch = $_POST['idmatch'];
    $order = $_POST['order'];
    if (is_numeric($order) && $order > 0) {
        $query = "UPDATE pmatch SET `order`='$order' WHERE `id`='$idmatch'";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    } else {
        pesan("Urutan tidak valid. Harus berupa angka positif.");
    }
}

if ($action == "resetskor") {
    $idmatch = $_POST['idmatch'];
    $query = "UPDATE pmatch SET score_a='0', score_b='0' WHERE id='$idmatch'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "tambah match") {
    $pa = $_POST['pa'];
    $pb = $_POST['pb'];

    $pa1 = explode(',', $pa)[0];
    $pa2 = explode(',', $pa)[1];
    $pb1 = explode(',', $pb)[0];
    $pb2 = explode(',', $pb)[1];

    if ($page == "men") $lapangan = "Merah";
    else $lapangan = "Biru";

    if ($pa1 && $pa2 && $pb1 && $pb2) {

        // Check if all player IDs are unique
        $players = [$pa1, $pa2, $pb1, $pb2];
        if (count($players) !== count(array_unique($players))) {
            pesan("Pemain tidak boleh sama.");
        } else {
            $query = "INSERT INTO pmatch (pa1, pa2, pb1, pb2, lapangan) VALUES ('$pa1', '$pa2', '$pb1', '$pb2', '$lapangan')";
            mysqli_query($conn, $query) or die(mysqli_error($conn));
            pesan("Match berhasil ditambahkan.");
        }
    } else {
        pesan("Semua pemain harus dipilih.");
    }
}
if ($action == "hapus match") {
    $idmatch = $_POST['idmatch'];
    $query = "DELETE FROM pmatch WHERE id='$idmatch'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    pesan("Match berhasil dihapus.");
}
