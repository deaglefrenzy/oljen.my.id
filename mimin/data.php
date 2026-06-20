<?php
include 'config/website.php';

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
