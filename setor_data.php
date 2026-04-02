<?php
$action = $_POST['action'] ?? '';

if ($action == "setor ride") {
    $orang_id = $_POST['orang_id'];
    $link = $_POST['link'];
    $query = "INSERT INTO rides (orang_id, link) VALUES ('$orang_id', '$link')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    pesan("Ride berhasil disetor!");
}
