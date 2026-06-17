<label class="w3-margin-top"><i class="fa-solid fa-clock-rotate-left"></i> Recent Orders</label>
<?php
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
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

include("order_logs.php");

