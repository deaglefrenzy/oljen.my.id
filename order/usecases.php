<?php
$action = $_POST['action'] ?? '';
if ($action == 'add jersey') {

    $member_id = (int) $_POST['member_id'];
    $event_id = (int) $_POST['event_id'];
    $token = $_POST['token'];

    $type = trim($_POST['type']);
    $category = trim($_POST['category']);
    $size = trim($_POST['size']);
    $variant = trim($_POST['variant']);
    $material = trim($_POST['material']);

    // --------------------------------------------------
    // Validate size by category
    // --------------------------------------------------

    $kids_sizes = ['3XS', '2XS', 'XS', 'S', 'M', 'L'];
    $adult_sizes = ['2XS', 'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];

    $valid = ($category == 'Kids')
        ? in_array($size, $kids_sizes)
        : in_array($size, $adult_sizes);

    if (!$valid) {
        pesan('Ukuran tidak valid');
    }

    // --------------------------------------------------
    // Determine member/nonmember pricing
    // --------------------------------------------------

    $query = "
        SELECT id
        FROM orders
        WHERE member_id='$member_id'
        AND event_id='$event_id'
        LIMIT 1
    ";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $is_member = (mysqli_num_rows($result) == 0);

    $total = $is_member
        ? $events[$event_id]['base']
        : $events[$event_id]['nonmember'];

    // --------------------------------------------------
    // Add-ons
    // --------------------------------------------------

    if ($size == '3XL') {
        $total += $events[$event_id]['oversize'];
    }

    if ($variant == $variants[1]) {
        $total += $events[$event_id]['longsleeves'];
    }

    if ($material == $materials[1]) {
        $total += $events[$event_id]['upgrade'];
    }

    // --------------------------------------------------
    // Insert
    // --------------------------------------------------

    $query = "
        INSERT INTO orders (
            member_id,
            event_id,
            type,
            category,
            size,
            variant,
            material,
            payment
        ) VALUES (
            '$member_id',
            '$event_id',
            '$type',
            '$category',
            '$size',
            '$variant',
            '$material',
            '$total'
        )
    ";

    if ($valid) {
        mysqli_query($conn, $query) or die(mysqli_error($conn));

        pesan("Jersey $category $size berhasil ditambahkan");
    }
}

if ($action == "remove order") {
    $id = $_POST['id'];
    $query = "DELETE FROM orders WHERE id='$id'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    pesan(
        "Jersey dihapus"
    );
}
