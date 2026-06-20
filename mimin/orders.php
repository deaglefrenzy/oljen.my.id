<?php
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$show = isset($_GET['show']) ? $_GET['show'] : 'recent';
if ($order_id) {
    include("order_detail.php");
} else {
    ?>
    <div class="w3-margin-bottom" style="display:flex; justify-content:space-between;">
        <a href="?page=orders&show=recent" class="w3-button w3-small w3-light-grey w3-round">
            <i class="fa-solid fa-clock-rotate-left"></i> Recent Orders
        </a>

        <a href="?page=orders&show=notlunas" class="w3-button w3-small w3-light-grey w3-round">
            <i class="fa-solid fa-receipt"></i> Not Lunas
        </a>
    </div>
    <?php
    if ($show == 'recent') {
        $query = "
SELECT
    o.*,
    m.name AS member_name,
    m.id AS member_id
FROM orders o
LEFT JOIN members m ON o.member_id = m.id
ORDER BY o.created_at DESC, o.id DESC
LIMIT 50
";
    } elseif ($show == 'notlunas') {
        $query = "
SELECT
    o.*,
    m.name AS member_name,
    m.id AS member_id
FROM orders o
LEFT JOIN members m ON o.member_id = m.id
WHERE o.status = 0
ORDER BY o.created_at DESC, o.id DESC
";
    }
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    include("order_logs.php");
}
