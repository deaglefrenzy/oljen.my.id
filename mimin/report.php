<?php
require_once 'auth/auth.php';
$categoryColors = [
    'w3-pale-blue',
    'w3-pale-red',
    'w3-pale-green',
    'w3-pale-yellow',
    'w3-sand',
    'w3-khaki'
];

$categoryClass = [];
$i = 0;

$query = "
    SELECT
        o.*,
        m.name AS member_name
    FROM orders o
    LEFT JOIN members m
        ON m.id = o.member_id
    WHERE o.status = 1
    ORDER BY
        o.category,
        o.variant,
        o.size,
        m.name
";
$result = mysqli_query($conn, $query);
$size_order = [
    '3XS',
    '2XS',
    'XS',
    'S',
    'M',
    'L',
    'XL',
    '2XL',
    '3XL'
];
$report = [];
$memberReport = [];

while ($row = mysqli_fetch_assoc($result)) {

    $category = $row['category'];
    $variant = $row['variant'];
    $size = $row['size'];
    $material = $row['material'];
    $member = $row['member_name'];

    $variantShort = str_replace(
        ['Lengan Pendek', 'Lengan Panjang'],
        ['Pendek', 'Panjang'],
        $variant
    );

    // Existing report
    $report[$category][$variantShort][$size][] = $member;

    // Member report
    // $memberReport[$member][] = [
    //     'category' => $category,
    //     'text' => "{$category} {$variantShort} {$material} {$size}"
    // ];
}

foreach ($report as $category => $variants) {
    $categoryClass[$category] =
        $categoryColors[$i % count($categoryColors)];
    $i++;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Order Report</title>
    <link rel="stylesheet" href="assets/w3v4.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .page-break {
                page-break-before: always;
            }
        }

        body {
            padding: 20px;
        }

        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="w3-container">
        <div class="w3-center w3-margin-bottom">
            <h2>ORDER REPORT</h2>
        </div>
        <button class="w3-button w3-blue no-print w3-margin-bottom" onclick="window.print()">
            Print / Save PDF
        </button>
        <div class="w3-card w3-white">
            <header class="w3-container w3-light-grey">
                <h3>Summary</h3>
            </header>
            <table class="w3-table w3-bordered w3-small">
                <tr class="w3-light-grey">
                    <th>Category</th>
                    <?php foreach ($size_order as $size): ?>
                        <th class="w3-center"><?= $size ?></th>
                    <?php endforeach; ?>
                    <th class="w3-right">Total</th>
                </tr>

                <?php
                $grandTotal = 0;
                ?>

                <?php foreach ($report as $category => $variants): ?>
                    <?php foreach ($variants as $variant => $sizes): ?>
                        <?php
                        $total = 0;
                        ?>
                        <tr>
                            <td class="<?= $categoryClass[$category] ?>"><?= $category . " " . $variant ?></td>

                            <?php foreach ($size_order as $size): ?>
                                <?php
                                $qty = count($sizes[$size] ?? []);
                                $total += $qty;
                                ?>
                                <td class="w3-center w3-border">
                                    <?= $qty ?: '' ?>
                                </td>
                            <?php endforeach; ?>

                            <td class="w3-right"><b><?= $total ?></b></td>
                        </tr>

                        <?php
                        $grandTotal += $total;
                        ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <!-- GRAND TOTAL ROW -->
                <tr class="w3-light-grey">
                    <td colspan="<?= 1 + count($size_order) ?>">
                        <b>Grand Total</b>
                    </td>
                    <td class="w3-right"><b><?= $grandTotal ?></b></td>
                </tr>
            </table>
        </div>
        <div class="w3-margin-top"></div>
        <div class="w3-card w3-white">
            <header class="w3-container w3-light-grey">
                <h3>Details</h3>
            </header>
            <table class="w3-table w3-bordered w3-small w3-white">
                <tr class="w3-light-grey">
                    <th>Category</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Members</th>
                </tr>
                <?php foreach ($report as $category => $variants): ?>
                    <?php foreach ($variants as $variant => $sizes): ?>
                        <?php foreach ($sizes as $size => $members):
                            ?>
                            <tr>
                                <td class="<?= $categoryClass[$category] ?>" style="white-space: nowrap;">
                                    <?= $category . " " . $variant ?>
                                </td>
                                <td><?= $size ?></td>
                                <td><?= count($members) ?></td>
                                <td>
                                    <?php foreach ($members as $member): ?>
                                        <span class="w3-border w3-round w3-padding-small" style="display:inline-block;margin:2px;">
                                            <?= htmlspecialchars($member) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>

        <?php if (count($memberReport) > 0): ?>
            <div class="page-break"></div>

            <div class="w3-card w3-white w3-margin-top">
                <header class="w3-container w3-light-grey w3-margin-bottom">
                    <h3>Orders By Member</h3>
                </header>

                <div class="w3-row-padding" style="font-size:11px;">

                    <?php ksort($memberReport); ?>

                    <?php foreach ($memberReport as $member => $items): ?>
                        <div class="w3-third w3-margin-bottom">

                            <div class="w3-border w3-round" style="padding:6px;">

                                <div style="
                        font-weight:bold;
                        font-size:12px;
                        border-bottom:1px solid #ddd;
                        padding-bottom:2px;
                        margin-bottom:4px;
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                    ">
                                    <?= htmlspecialchars($member) ?>
                                </div>

                                <div style="
                        display:flex;
                        flex-wrap:wrap;
                        gap:2px;
                        line-height:1.2;
                    ">
                                    <?php foreach ($items as $item): ?>
                                        <span class="<?= $categoryClass[$item['category']] ?>" style="
              display:inline-block;
              padding:1px 4px;
              margin:1px;
              border-radius:3px;
              font-size:10px;
              white-space:nowrap;
          ">
                                            <?= htmlspecialchars($item['text']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
