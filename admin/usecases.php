<?php
$action = $_POST['action'] ?? '';

if ($action == "add orang") {
    $name = $_POST['name'];
    $profile = $_POST['profile'];
    $query = "INSERT INTO orang (name, profile, active) VALUES ('$name', '$profile', 1)";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "delete ride") {
    $ride_id = $_POST['ride_id'];
    $query = "UPDATE rides SET deleted_at=NOW() WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "edit distance") {
    $ride_id = $_POST['ride_id'];
    $distance = $_POST['distance'];
    $orang_id = $_POST['orang_id'];
    $input_time = $_POST['input_time'];
    $query = "UPDATE rides SET distance='$distance' WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    $query = "SELECT SUM(distance) AS total_distance FROM rides WHERE orang_id='$orang_id'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);
    $total_distance = $row['total_distance'];

    if ($total_distance >= 1000) {
        $query = "UPDATE orang SET finish = '$input_time' WHERE id='$orang_id'";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    }
}

if ($action == "edit tanggal") {
    $ride_id = $_POST['ride_id'];
    $tanggal = $_POST['tanggal'];
    $query = "UPDATE rides SET input_time='$tanggal' WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "edit note") {
    $ride_id = $_POST['ride_id'];
    $pesan = $_POST['pesan'];
    $link = $_POST['link'];
    $query = "UPDATE rides SET pesan='$pesan', link='$link' WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "activate orang") {
    $id = $_POST['id'];
    $active = $_POST['active'];
    if ($active) {
        $query = "UPDATE orang SET active=0 WHERE id='$id'";
    } else {
        $query = "UPDATE orang SET active=1 WHERE id='$id'";
    }
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}
