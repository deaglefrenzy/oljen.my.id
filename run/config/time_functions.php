<?php

$bulan = [
    1 => "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember"
];

$bulanPendek = [
    1 => "Jan",
    "Feb",
    "Mar",
    "Apr",
    "Mei",
    "Jun",
    "Jul",
    "Agu",
    "Sep",
    "Okt",
    "Nov",
    "Des"
];

$hari = [
    1 => "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu",
    "Minggu"
];

/**
 * Format tanggal Indonesia
 *
 * @param string $date
 * @param array $options
 *
 * Options:
 * - with_day      => true/false
 * - short_month   => true/false
 * - with_time     => true/false
 * - relative      => true/false
 */
function formatTanggal($date, $options = [])
{
    global $bulan, $bulanPendek, $hari;

    $default = [
        'with_day' => false,
        'short_month' => false,
        'with_time' => false,
        'relative' => false,
    ];

    $opt = array_merge($default, $options);

    $timestamp = strtotime($date);

    // Relative time
    if ($opt['relative']) {
        return waktuLalu($timestamp);
    }

    $namaHari = $hari[date('N', $timestamp)];
    $tanggal = date('d', $timestamp);

    $namaBulan = $opt['short_month']
        ? $bulanPendek[date('n', $timestamp)]
        : $bulan[date('n', $timestamp)];

    $tahun = date('Y', $timestamp);

    $hasil = "$tanggal $namaBulan $tahun";

    // Tambah hari
    if ($opt['with_day']) {
        $hasil = "$namaHari, $hasil";
    }

    // Tambah jam
    if ($opt['with_time']) {
        $jam = date('H:i', $timestamp);
        $hasil .= " $jam";
    }

    return $hasil;
}

/**
 * Relative time Indonesia
 */
function waktuLalu($timestamp)
{
    if (!is_numeric($timestamp)) {
        $timestamp = strtotime($timestamp);
    }
    $selisih = time() - $timestamp;

    if ($selisih < 60)
        return "baru saja";

    if ($selisih < 3600)
        return floor($selisih / 60) . " menit lalu";

    if ($selisih < 86400)
        return floor($selisih / 3600) . " jam lalu";

    if ($selisih < 604800)
        return floor($selisih / 86400) . " hari lalu";

    if ($selisih < 2592000)
        return floor($selisih / 604800) . " minggu lalu";

    if ($selisih < 31536000)
        return floor($selisih / 2592000) . " bulan lalu";

    return floor($selisih / 31536000) . " tahun lalu";
}

function tgl($date)
{
    return formatTanggal($date);
}

function tglJam($date)
{
    return formatTanggal($date, ['with_time' => true]);
}

function tglHari($date)
{
    return formatTanggal($date, [
        'with_day' => true,
    ]);
}

function tglHariJam($date)
{
    return formatTanggal($date, [
        'with_day' => true,
        'with_time' => true
    ]);
}

function tglRelatif($date)
{
    return formatTanggal($date, ['relative' => true]);
}
