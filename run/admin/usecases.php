<?php
$action = $_POST['action'] ?? '';

if ($action == "add orang") {
    $name = $_POST['name'];
    $profile = $_POST['profile'];
    $query = "INSERT INTO orang (name, profile, running) VALUES ('$name', '$profile', 1)";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "delete run") {
    $run_id = $_POST['run_id'];
    $query = "UPDATE runs SET deleted_at=NOW() WHERE id='$run_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "edit distance") {
    $run_id = $_POST['run_id'];
    $distance = $_POST['distance'];
    $orang_id = $_POST['orang_id'];
    $input_time = $_POST['input_time'];
    $query = "UPDATE runs SET distance='$distance' WHERE id='$run_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    $query = "SELECT SUM(distance) AS total_distance FROM runs WHERE orang_id='$orang_id'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);
    $total_distance = $row['total_distance'];

    if ($total_distance >= 100) {
        $query = "UPDATE orang SET run_finish = '$input_time' WHERE id='$orang_id'";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    }
}

if ($action == "edit tanggal") {
    $run_id = $_POST['run_id'];
    $tanggal = $_POST['tanggal'];
    $query = "UPDATE runs SET input_time='$tanggal' WHERE id='$run_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "edit note") {
    $run_id = $_POST['run_id'];
    $pesan = $_POST['pesan'];
    $link = $_POST['link'];
    $query = "UPDATE runs SET pesan='$pesan', link='$link' WHERE id='$run_id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}

if ($action == "activate orang") {
    $id = $_POST['id'];
    $running = $_POST['running'];
    if ($running == 1) {
        $query = "UPDATE orang SET running=0 WHERE id='$id'";
    } else {
        $query = "UPDATE orang SET running=1 WHERE id='$id'";
    }
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}
