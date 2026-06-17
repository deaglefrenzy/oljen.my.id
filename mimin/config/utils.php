<?php
include "time_functions.php";
function pergi($tujuan)
{
    ?>
    <meta http-equiv="refresh" content="0; url='<?php echo $tujuan; ?>'">
    <?php
}

function pesan($isi, $redirect = null)
{
    ?>
    <div class="popup-overlay">
        <div class="popup-box">
            <p><?= $isi ?></p>
            <button onclick="
                <?php if ($redirect): ?>
                    window.location.href='<?= $redirect ?>'
                <?php else: ?>
                    this.closest('.popup-overlay').remove()
                <?php endif; ?>
            ">
                OK
            </button>
        </div>
    </div>
    <style>
        .popup-overlay {
            position: fixed;
            inset: 0;

            background: rgba(0, 0, 0, 0.45);

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;

            z-index: 99999;
        }

        .popup-box {
            background: #fff;

            width: 100%;
            max-width: 380px;

            border-radius: 18px;

            padding: 24px 20px;

            text-align: center;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);

            animation: popupFade 0.2s ease;
        }

        .popup-box p {
            margin: 0 0 20px;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        .popup-box button {
            border: none;

            background: #4CAF50;
            color: #fff;

            padding: 10px 24px;

            border-radius: 12px;

            font-size: 15px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .popup-box button:hover {
            background: #43a047;
        }

        @keyframes popupFade {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
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

function desimal($nilai, $angka = 2)
{
    $hasil = number_format($nilai, $angka, ",", ".");
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

function shortNominal($n)
{
    if (!$n) {
        return '-';
    }

    if ($n >= 1000000) {
        $v = number_format($n / 1000000, 2, ',', '.');
        return rtrim(rtrim($v, '0'), ',') . '<span class="w3-opacity" style="font-size: 0.8em;">jt</span>';
    }

    if ($n >= 1000) {
        $v = number_format($n / 1000, 2, ',', '.');
        return rtrim(rtrim($v, '0'), ',') . '<span class="w3-opacity" style="font-size: 0.8em;">rb</span>';
    }

    return number_format($n, 0, ',', '.');
}
