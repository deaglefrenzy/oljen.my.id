<?php
$action = $_POST['action'] ?? '';

if ($action == "add orang") {
    $name = $_POST['name'];
    $query = "INSERT INTO orang (name) VALUES ('$name')";
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
    $query = "UPDATE rides SET distance='$distance' WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "edit note") {
    $ride_id = $_POST['ride_id'];
    $pesan = $_POST['pesan'];
    $link = $_POST['link'];
    $query = "UPDATE rides SET pesan='$pesan', link='$link' WHERE id='$ride_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}
