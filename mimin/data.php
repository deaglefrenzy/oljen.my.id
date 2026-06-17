<?php
include 'config/website.php';

$members = [];
$query = "
SELECT * FROM members WHERE active = 1 ORDER BY name ASC
";
$q = mysqli_query($conn, $query) or die(mysqli_error($conn));
while ($row = mysqli_fetch_assoc($q)) {
    $members[$row['id']] = $row;
}

$menu_items = [
    'members' => [
        'label' => 'MEMBERS',
        'color' => 'blue',
        'href' => '?page=members',
        'icon' => 'fa-solid fa-children',
    ],
    'orders' => [
        'label' => 'ORDERS',
        'color' => 'green',
        'href' => '?page=orders',
        'icon' => 'fa-solid fa-hand-holding-dollar',
    ],
    'user' => [
        'label' => $login_name,
        'color' => 'red',
        'href' => '?page=user',
        'icon' => 'fa-solid fa-user-gear',
    ],
];

$top_items = [

];
