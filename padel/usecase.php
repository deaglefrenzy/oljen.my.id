<?php
if ($action == "updateskor") {
    $idmatch = $_POST['idmatch'];
    $score_a = $_POST['score_a'];
    $score_b = 16 - $score_a;
    if (is_numeric($score_a) && $score_a >= 0 && $score_a <= 16) {
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
    $pa1 = $_POST['pa1'];
    $pa2 = $_POST['pa2'];
    $pb1 = $_POST['pb1'];
    $pb2 = $_POST['pb2'];

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
