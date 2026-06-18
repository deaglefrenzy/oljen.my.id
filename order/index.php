<?php
require_once '../config/connection.php';
include '../config/utils.php';
include 'data.php';
include 'usecases.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Jersey OLJEN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Order Jersey OLJEN" />
    <meta property="og:description" content="Form pemesanan jersey Event OLJEN" />
    <meta property="og:url" content="https://oljen.my.id/order/" />
    <meta property="og:type" content="website" />
    <link rel="stylesheet" href="../run/config/components.css?v=<?= filemtime('config/components.css') ?>">
    <link rel="stylesheet" href="../run/config/w3v4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type=text],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .jersey-entry {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            background: #fafafa;
        }

        .entry-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #444;
            text-align: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            border: 0;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .add-btn {
            width: 100%;
            padding: 12px;
            border: 0;
            background: #3498db;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .summary {
            background: #f0f8ff;
        }

        .order-summary {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .main-price {
            font-weight: bold;
            font-size: 1.05em;
        }

        .extra {
            color: #666;
            padding-left: 15px;
            font-size: .9em;
        }

        .subtotal {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-weight: bold;
            font-size: 1.1em;
        }

        .remove-btn {
            border: 0;
            background: #f44336;
            color: white;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }

        .remove-btn:hover {
            opacity: .9;
        }

        .total {
            font-size: 22px;
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 10px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: 0;
            background: #27ae60;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
        }

        @media (max-width: 700px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .payment-summary {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .payment-total {
            text-align: center;
            margin-bottom: 20px;
        }

        .payment-total .label {
            color: #777;
            font-size: 14px;
        }

        .payment-total .amount {
            font-size: 32px;
            font-weight: bold;
            color: #2e7d32;
            margin-top: 8px;
        }

        .transfer-info {
            margin-top: 20px;
        }

        .transfer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transfer-table td {
            padding: 6px 0;
        }

        .note {
            margin-top: 12px;
            padding: 10px;
            background: #fff8e1;
            border-radius: 8px;
            font-size: 14px;
        }

        .upload-section {
            margin-top: 20px;
        }

        .upload-section input[type=file] {
            width: 100%;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
        }

        .member-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 14px;
            letter-spacing: 1px;
            color: #777;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .member-card {
            display: inline-block;
            padding: 12px 24px;
            background: #f5f5f5;
            border: 2px solid #ddd;
            border-radius: 12px;
        }

        .member-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .member-name {
            font-size: 28px;
            font-weight: bold;
            color: #222;
            margin-top: 4px;
        }

        .logo {
            display: block;
            width: 100px;
            margin: 0 auto;
        }
    </style>
</head>
<?php
$token = $_GET['token'];
if (empty($token)) {
    header("Location: ../index.php");
    exit();
}
$q = mysqli_query($conn, "SELECT * FROM members WHERE token = '$token'");
$member_id = $q->num_rows > 0 ? $q->fetch_assoc()['id'] : 0;
$event_id = $_GET['event_id'] ?? 0;
$orders = [];
if ($member_id > 0 && $event_id > 0) {
    $query = "SELECT * FROM orders WHERE member_id='$member_id' AND event_id='$event_id' ORDER BY id ASC";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[$row['id']] = $row;
    }
}
?>

<body>
    <div class="container">
        <div class="card">
            <img src="../images/logo1.png" class="logo">
            <div class="member-header">
                <div class="page-title">
                    SISTEM PEMESANAN JERSEY OLJEN
                </div>
                <div class="member-card">
                    <div class="member-label">
                        Member
                    </div>
                    <div class="member-name">
                        <?= $members[$member_id]['name'] ?>
                    </div>
                    <?php
                    foreach ($related_ids[$member_id] as $related_id) {
                        ?>
                        <div class="member-name w3-medium">
                            <?= $members[$related_id]['name'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <label>Event</label>
            <form method="get">
                <input type="hidden" name="token" value="<?= $token ?>">
                <select name="event_id" onchange="this.form.submit()">
                    <option value="">-- Pilih Event --</option>
                    <?php
                    foreach ($events as $event):
                        ?>
                        <option value="<?= $event['id'] ?>" <?= $event['id'] == $event_id ? 'selected' : '' ?>>
                            <?= $event['name'] ?>
                        </option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </form>
        </div>
        <?php
        if ($event_id > 0):
            $start_date = $events[$event_id]['start_date'];
            $end_date = $events[$event_id]['end_date'];
            if (date('Y-m-d') >= $start_date && date('Y-m-d') <= $end_date) {
                $available = true;
            }
            if (count($orders) > 0):
                include "order.php";
            endif;
            ?>
            <div class="jersey">
                <a href="images/<?= $events[$event_id]['jersey'] ?>" target="_blank">
                    <img class="image" src="images/<?= $events[$event_id]['jersey'] ?>">
                </a>
            </div>
            <div style="height:10px;"></div>
            <?php include "form.php"; ?>
        <?php endif; ?>
    </div>
</body>

</html>
