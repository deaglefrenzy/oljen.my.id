<?php
include "time_functions.php";
function pergi($tujuan)
{
    ?>
    <meta http-equiv="refresh" content="0; url='<?php echo $tujuan; ?>'">
    <?php
}

function pesan($isi)
{
    ?>
    <div class="popup-overlay">
        <div class="popup-box">
            <p><?= htmlspecialchars($isi) ?></p>
            <button onclick="this.closest('.popup-overlay').remove()">OK</button>
        </div>
    </div>
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

function desimal($nilai, $angka = 0)
{
    $hasil = number_format($nilai, $angka, ",", ".");
    return $hasil;
}

function ganti($n)
{
    $hasil = str_replace('.', '', $n);
    return $hasil;
}

function unit($unit, $size = "tiny")
{
    return "<span class='w3-" . $size . " w3-opacity' style='margin-left:1px;'>$unit</span>";
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
