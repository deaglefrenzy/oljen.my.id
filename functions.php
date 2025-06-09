<?php

include_once "connections.php";

$bulan3char = array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
$bulanfullchar = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$harifullchar = array("", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");

function tulistgl($t, $bulan3char)
{
    $tg = substr($t, 8, 2);
    $bl = substr($t, 5, 2);
    $th = substr($t, 0, 4);
    if (substr($bl, 0, 1) == "0")
        $bl = substr($bl, 1, 1);
    $bln = $bulan3char[$bl];
    return "$tg $bln $th";
}

function tulistglhari($tgl, $bulanfullchar, $harifullchar)
{
    $ha = $harifullchar[date("N", strtotime($tgl))];
    $tg = date("d", strtotime($tgl));
    $bl = $bulanfullchar[date("n", strtotime($tgl))];
    $th = date("Y", strtotime($tgl));
    $tanggal = "$ha, $tg $bl $th";
    return $tanggal;
}

function pergi($tujuan)
{
?>
    <meta http-equiv="refresh" content="0; url='<?php echo $tujuan; ?>'">
<?php
}

function pesan($isi)
{
?>
    <dialog open>
        <p><?= $isi ?></p>
        <center>
            <form method="dialog">
                <button class="cool-button">OK</button>
            </form>
        </center>
    </dialog>
<?php
}

function mundur()
{
    echo "<script>window.history.back();</script>";
    exit();
}

function dd($vars)
{
    echo "<pre style='font-family: monospace; font-size: 14px; white-space: pre-wrap;'>";

    foreach ($vars as $var) {
        var_dump($var);
    }

    echo "</pre>";
    die();
}

function permission($stat)
{
    if (!empty($_COOKIE['idlogin'])) {
        if ($_COOKIE['priv'] <= $stat) {
            return true;
        } else {
            pesan("Anda tidak mempunyai akses ke halaman ini!");
            mundur();
            return false;
        }
    } else {
        pesan("Anda tidak mempunyai akses ke halaman ini!");
        pergi("index.php");
        return false;
    }
}

function rupiah($nilai)
{
    $hasil = "Rp " . number_format($nilai, 0, ",", ".");
    return $hasil;
}

function ribuan($nilai)
{
    $hasil = number_format($nilai, 0, ",", ".");
    return $hasil;
}

function ganti($n)
{
    $hasil = str_replace('.', '', $n);
    return $hasil;
}

function terbilang($satuan)
{
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($satuan < 12)
        return " " . $huruf[$satuan];
    elseif ($satuan < 20)
        return terbilang($satuan - 10) . " belas";
    elseif ($satuan < 100)
        return terbilang($satuan / 10) . " puluh" . terbilang($satuan % 10);
    elseif ($satuan < 200)
        return " seratus" . terbilang($satuan - 100);
    elseif ($satuan < 1000)
        return terbilang($satuan / 100) . " ratus" . terbilang($satuan % 100);
    elseif ($satuan < 2000)
        return " seribu" . terbilang($satuan - 1000);
    elseif ($satuan < 1000000)
        return terbilang($satuan / 1000) . " ribu" . terbilang($satuan % 1000);
    elseif ($satuan < 1000000000)
        return terbilang($satuan / 1000000) . " juta" . terbilang($satuan % 1000000);
    elseif ($satuan < 1000000000000)
        return terbilang($satuan / 1000000000) . " milyar" . terbilang($satuan % 1000000000);
}

function hidden($name, $value)
{
    $var = "<input type='hidden' name='" . $name . "' value='" . $value . "'>";
    return $var;
}
