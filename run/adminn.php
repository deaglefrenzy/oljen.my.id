<?php
require_once "../connection.php";
require_once "../../cdn/func.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin KMC</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="OLJEN Kilometer Challenge" />
    <meta property="og:description" content="OLJEN Kilometer Challenge" />
    <meta property="og:url" content="https://oljen.my.id" />
    <meta property="og:image" itemprop="image" content="https://oljen.my.id/thumbnail.png" />
    <meta property="og:type" content="website" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
    </script>

</head>
<?php
$admin = @$_COOKIE['admin'];
$action = @$_POST['action'];
date_default_timezone_set('Asia/Makassar');
$now = date('Y-m-d H:i:s');

if ($action == "editdistance") {
    $idrides = $_POST['idrides'];
    $distancebaru = $_POST['distancebaru'];
    $idorg = $_POST['idorg'];
    $wktin = $_POST['wktin'];
    mysqli_query($conn, "UPDATE runs SET distance='$distancebaru' WHERE id='$idrides'");
    $e = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(distance) as tot FROM runs WHERE orang_id='$idorg'"));
    $f = mysqli_fetch_array(mysqli_query($conn, "SELECT finish FROM runner WHERE id='$idorg'"));
    $jauh = $e['tot'];
    if ((!isset($f['finish'])) && ($jauh >= 100)) {
        mysqli_query($conn, "UPDATE runner SET finish='$wktin' WHERE id='$idorg'");
    }
    mysqli_query($conn, "UPDATE runner SET updatedAt='$now' WHERE id='1'");
}
if ($action == "orgbaru") {
    $namaorg = $_POST['namaorg'];
    $profile = $_POST['profile'];
    mysqli_query($conn, "INSERT INTO runner SET name='$namaorg', profile='$profile'") or die(mysqli_error($conn));
    pesan("Orang Baru!");
}
if ($action == "hapusrides") {
    $idrides = $_POST['idrides'];
    mysqli_query($conn, "DELETE FROM runs WHERE id='$idrides'");
    pesan("Ride Terhapus");
}
if ($action == "gantitgl") {
    $idrides = $_POST['idrides'];
    $tglganti = $_POST['tglganti'];
    $waktunya = $_POST['wkt'];
    $gantinya = $tglganti . " " . $waktunya;
    mysqli_query($conn, "UPDATE runs SET input_time='$gantinya' WHERE id='$idrides'");
    pesan("Tanggal Diganti");
}

if ($action == "isipesan") {
    $idrides = $_POST['idrides'];
    $pesanbaru = $_POST['pesanbaru'];
    mysqli_query($conn, "UPDATE runs SET pesan='$pesanbaru' WHERE id='$idrides'");
    //pesan("Pesan Ditambahkan");
}

$date = @$_GET['date'];
$today = date("Y-m-d");
if (!isset($date)) $date = $today;
?>

<body>
    <br>
    <?php
    if (empty($admin)) {
    ?>
        <br>
        <form action="login.php" method="post">
            <table border="0" cellpadding="5" cellspacing="3" align="center" width="100%">
                <tr>
                    <td align="center">
                        <input type="password" name="pass" size="12" style="border:2px solid #000;" class="w3-xxlarge" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" name="action" value="logadmin" class="button2 w3-xlarge" style="font-family:Futura">Login Admin</button>
                    </td>
                </tr>
            </table>
        </form>
    <?php
    } else {
    ?>
        <table border="0" cellpadding="5" cellspacing="3" align="center" width="100%">
            <tr>
                <form action="adminn.php" method="post">
                    <td align="center">
                        <input type="text" name="namaorg" size="8" placeholder="nama">
                        <input type="text" name="profile" size="8" placeholder="profile">
                        <button type="submit" name="action" value="orgbaru" class="button2 w3-medium">
                            +
                        </button>
                    </td>
                </form>
                <form action="logout.php" method="post">
                    <td align="center">
                        <button type="submit" name="action" value="logusher">Logout</button>
                    </td>
                </form>
            </tr>
            <tr>
                <form action="adminn.php" method="get">
                    <td align="center">
                        <input type="date" name="date" value="<?= $date ?>" size="10" onchange="this.form.submit();">
                    </td>
                </form>
                <form action="adminn.php" method="get">
                    <td align="center">
                        <button type="submit" class="button2 w3-large">Refresh</button>
                    </td>
                </form>
            </tr>
        </table>
        <br>
        <?php
        $count = 0;
        $q = mysqli_query($conn, "SELECT * FROM runs WHERE input_time LIKE '$date%' ORDER BY id DESC");
        while ($qq = mysqli_fetch_array($q)) {
            $count++;
            $idrides = $qq['id'];
            $idorang = $qq['orang_id'];
            $pesan = $qq['pesan'];
            $w = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM runner WHERE id='$idorang'"));
            $e = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(distance) as tot FROM runs WHERE orang_id='$idorang' AND id<'$idrides'"));
        ?>
            <table style="border:1px solid #333; font-family:Futura" class="w3-small" width="95%" rules="all" align="center">
                <tr align="center">
                    <td colspan="2">
                        <table width="100%" style="font-family:Futura" class="w3-small">
                            <tr>
                                <?php
                                $waktunya = date("H:i:s", strtotime($qq['input_time'] . " +1 hours"));
                                ?>
                                <form action="adminn.php" method="post" onSubmit="return confirm('Ubah?');">
                                    <input type="hidden" name="idrides" value="<?php echo $idrides; ?>">
                                    <input type="hidden" name="action" value="gantitgl">
                                    <input type="hidden" name="wkt" value="<?php echo $waktunya; ?>">
                                    <td align="left">
                                        <?php
                                        echo $idrides . " - " .
                                            $w['name'] . " - " .
                                            number_format($e['tot'], 1, ".", ",") . " - " .
                                            $waktunya;
                                        ?>
                                        <input type="date" name="tglganti" value="<?php echo date('Y-m-d', strtotime($qq['input_time'])); ?>" onchange="this.form.submit();" style="width:auto;">
                                    </td>
                                </form>
                                <form action="adminn.php" method="post" onSubmit="return confirm('Hapus?');">
                                    <input type="hidden" name="idrides" value="<?php echo $idrides; ?>">
                                    <td align="right"><button class="w3-tiny" type="submit" name="action" value="hapusrides">X</button></td>
                                </form>
                            </tr>
                        </table>
                    </td>
                    <form action="adminn.php?date=<?= $date ?>" method="post">
                        <input type="hidden" name="idrides" value="<?php echo $idrides; ?>">
                        <input type="hidden" name="idorg" value="<?php echo $idorang; ?>">
                        <input type="hidden" name="wktin" value="<?php echo $qq['input_time']; ?>">
                        <input type="hidden" name="action" value="editdistance">
                        <td rowspan="2" width="15%" <?php if ($qq['distance'] == 0) echo "style='background:yellow;'"; ?>>
                            <input type="tel" name="distancebaru" size="3" value="<?php echo $qq['distance']; ?>" id="inputSelect">
                        </td>
                    </form>
                </tr>
                <tr>
                    <td align="left" class="w3-tiny">
                        <?php
                        $linknya = $qq['link'];
                        $linknya = "<a href='$linknya' target='_blank'>" . $linknya . "</a>";
                        echo $linknya;
                        ?>
                    </td>
                    <form action="adminn.php?date=<?= $date ?>" method="post" onSubmit="return confirm('Isi Pesan?');">
                        <input type="hidden" name="idrides" value="<?php echo $idrides; ?>">
                        <input type="hidden" name="action" value="isipesan">
                        <td align="right">
                            <input type="text" name="pesanbaru" value="<?php echo $pesan; ?>" size="5" class="w3-tiny">
                        </td>
                    </form>
                </tr>
            </table>
    <?php
        }
    }
    ?>
</body>

<script>
    const inputElement = document.getElementById("inputSelect");

    inputElement.addEventListener("click", function() {
        this.select();
    });
</script>

<script src="ajaxform.js"></script>
