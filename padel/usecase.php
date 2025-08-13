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
