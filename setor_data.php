<?php
$action = $_POST['action'] ?? '';

if ($action == "setor ride") {
    $orang_id = $_POST['orang_id'];
    $link = $_POST['link'];

    $query = "SELECT * FROM rides WHERE orang_id='$orang_id' AND link='$link'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO rides (orang_id, link) VALUES ('$orang_id', '$link')";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
        pesan("Ride berhasil disetor!");
    } else {
        pesan("Ride ini sudah disetor sebelumnya!");
    }
}
