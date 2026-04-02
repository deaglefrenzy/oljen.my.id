<?php
include 'config/website.php';

$q = mysqli_query($conn, "SELECT * FROM orang ORDER BY name ASC");
$orang = [];
while ($row = mysqli_fetch_assoc($q)) {
    $orang[$row['id']] = $row;
}
