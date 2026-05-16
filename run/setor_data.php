<?php
$action = $_POST['action'] ?? '';
if ($action == "setor run") {
    $orang_id = $_POST['orang_id'];
    $raw = $_POST['link'];
    preg_match('/https?:\/\/\S*(strava|garmin)\S*/i', $raw, $matches);
    $link = $matches[0] ?? null;

    if ($link) {
        $link = strtok($link, '?');
        $query = "SELECT * FROM runs WHERE orang_id='$orang_id' AND link='$link'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0) {
            $query = "INSERT INTO runs (orang_id, input_time, link, `raw`) VALUES ('$orang_id', NOW(), '$link', '$raw')";
            mysqli_query($conn, $query) or die(mysqli_error($conn));
            pesan("Run berhasil disetor!");
        } else {
            pesan("Run ini sudah disetor sebelumnya!");
        }
    } else {
        pesan("Link tidak valid!");
    }
}
