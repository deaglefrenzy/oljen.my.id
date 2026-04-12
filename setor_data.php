<?php
$action = $_POST['action'] ?? '';

if ($action == "setor ride") {
    $orang_id = $_POST['orang_id'];
    $raw = $_POST['link'];
    preg_match('/https?:\/\/\S+/', $raw, $matches);
    $link = $matches[0] ?? null;

    $query = "SELECT * FROM rides WHERE orang_id='$orang_id' AND link='$link'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO rides (orang_id, input_time, link, `raw`) VALUES ('$orang_id', NOW(), '$link', '$raw')";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
        pesan("Ride berhasil disetor!");
    } else {
        pesan("Ride ini sudah disetor sebelumnya!");
    }
}
