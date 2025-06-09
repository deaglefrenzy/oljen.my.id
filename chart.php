<?php
require_once "connection.php";
require_once "../cdn/func.php";

$id = @$_GET['id'];
$type = @$_GET['type'];
if (!$type) {
    $type = "rides";
    $orang = "orang";
} else {
    $orang = "runner";
}
$que = "SELECT * FROM $orang WHERE id='$id'";
$u = mysqli_fetch_array(mysqli_query($conn, $que));
$nama = $u['name'];
?>
<html>

<head>
    <title>Chart KMC <?php $nama; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
</head>
<?php
$rawData = [];
$que = "SELECT * FROM $type WHERE orang_id='$id'";
$o = mysqli_query($conn, $que);
while ($oo = mysqli_fetch_array($o)) {
    $date = date('Y-m-d', strtotime($oo['input_time']));
    $rawData[] = array($date, $oo['distance']);
}
// Step 1: Aggregate values by date
$dateMap = [];
foreach ($rawData as $row) {
    $date = $row[0];
    $value = $row[1];
    if (!isset($dateMap[$date])) {
        $dateMap[$date] = 0;
    }
    $dateMap[$date] += $value;
}

// Step 2: Sort by date
uksort($dateMap, function ($a, $b) {
    return strtotime($a) - strtotime($b);
});

// Step 3: Calculate cumulative values and extract day numbers
$cumulative = 0;
$chartData = [['Tanggal', 'Jarak']];
$dayLabels = [];

// Add starting point at day before first data point with value 0
$firstDate = array_key_first($dateMap);
$firstDay = date('j', strtotime($firstDate));
$startDay = max(1, $firstDay - 1); // Ensure we don't go below day 1
$chartData[] = [$startDay, 0];
$dayLabels[] = ['v' => $startDay, 'f' => 'Start']; // First label shows as "Start"

foreach ($dateMap as $date => $value) {
    $cumulative += $value;
    $dayNumber = date('d', strtotime($date));
    $chartData[] = [$dayNumber, $cumulative];
    $dayLabels[] = $dayNumber;
}

// Convert PHP arrays to JSON for JavaScript
$chartDataJson = json_encode($chartData);
$dayLabelsJson = json_encode(array_values(array_unique($dayLabels)));
?>

<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Get data from PHP
        var chartData = <?php echo $chartDataJson; ?>;
        var dayLabels = <?php echo $dayLabelsJson; ?>;

        // Create the data table
        var data = google.visualization.arrayToDataTable(chartData);

        // Prepare ticks for hAxis
        var ticks = [];
        for (var i = 0; i < dayLabels.length; i++) {
            if (typeof dayLabels[i] === 'object') {
                // This is our "Start" label
                ticks.push(dayLabels[i]);
            } else {
                // Regular day numbers
                ticks.push({
                    v: parseInt(dayLabels[i]),
                    f: dayLabels[i].toString()
                });
            }
        }

        // Set chart options for curved line
        var options = {
            title: 'Grafik KMC <?php echo $nama; ?>',
            hAxis: {
                title: 'Tanggal',
                ticks: ticks,
                minValue: Math.min(...dayLabels.map(function(d) {
                    return typeof d === 'object' ? d.v : parseInt(d);
                })) - 0.5,
                maxValue: Math.max(...dayLabels.map(function(d) {
                    return typeof d === 'object' ? d.v : parseInt(d);
                })) + 0.5
            },
            vAxis: {
                title: 'Jarak (km)',
                minValue: 0,
                viewWindow: {
                    min: 0
                }
            },
            legend: {
                position: 'none'
            },
            width: 900,
            chartArea: {
                width: '85%'
            },
            curveType: 'function', // This makes the line curved
            series: {
                0: {
                    lineWidth: 3,
                    pointSize: 5,
                    pointsVisible: true,
                    // Make the line smooth
                    interpolation: 'smooth' // Alternative to curveType
                }
            }
        };

        // Instantiate and draw the chart
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
