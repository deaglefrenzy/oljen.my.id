<?php
$q = mysqli_query($conn, "SELECT * FROM events WHERE active = 1 ORDER BY id ASC");
$events = [];
while ($row = mysqli_fetch_assoc($q)) {
    $events[$row['id']] = $row;
}

$q = mysqli_query($conn, "SELECT * FROM members WHERE active = 1 ORDER BY id ASC");
$members = [];
while ($row = mysqli_fetch_assoc($q)) {
    $members[$row['id']] = $row;
}

$q = mysqli_query($conn, "SELECT member_id, related_id FROM members_link");
$related_ids = [];

while ($row = mysqli_fetch_assoc($q)) {

    $a = $row['member_id'];
    $b = $row['related_id'];

    $related_ids[$a][] = $b;
    $related_ids[$b][] = $a;
}

$materials = [
    "DRYFIT",
    "PRO"
];

$categories = [
    "Men",
    "Women",
    "Kids"
];

$sizes = [
    "3XS",
    "2XS",
    "XS",
    "S",
    "M",
    "L",
    "XL",
    "2XL",
    "3XL"
];

$variants = [
    "Lengan Pendek",
    "Lengan Panjang",
    "Singlet",
    "Kerah Polo",
    "Muscle Tee"
];

$available = false;
$start_date = $events[$event_id]['start_date'];
$end_date = $events[$event_id]['end_date'];
if (date('Y-m-d') >= $start_date && date('Y-m-d') <= $end_date) {
    $available = true;
}
