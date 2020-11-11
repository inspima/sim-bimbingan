<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    

function todb($tanggal) {
    $exp = explode('/', $tanggal);
    $day    = $exp[0];
    $month  = $exp[1];
    $year   = $exp[2];
    $exp_date = $year.'-'.$month.'-'.$day;
    return($exp_date);
}

function todb_null($tanggal) {
    if($tanggal == '')
    {
        $exp_date = '0000-00-00';
        return($exp_date);
    }
    else
    {
        $exp = explode('/', $tanggal);
        $day    = $exp[0];
        $month  = $exp[1];
        $year   = $exp[2];
        $exp_date = $year.'-'.$month.'-'.$day;
        return($exp_date);
    }
}

function wtime_todb($tanggal) {
	date_default_timezone_set('Asia/Jakarta');
    $exp = explode('/', $tanggal);
    $day    = $exp[0];
    $month  = $exp[1];
    $year   = $exp[2];
    $exp_date = $year.'-'.$month.'-'.$day.' '.date("H:i:s");
    return($exp_date);
}

function toindo($tanggal) {
    $exp = explode('-', date("Y-m-d", strtotime($tanggal)));
    $day    = $exp[2];
    $month  = $exp[1];
    $year   = $exp[0];
    $exp_date = $day.'/'.$month.'/'.$year;
    return($exp_date);
}

function wtime_toindo($tanggal) {
	date_default_timezone_set('Asia/Jakarta');
    $exp = explode('/', $tanggal);
    $day    = $exp[2];
    $month  = $exp[1];
    $year   = $exp[0];
    $exp_date = $day.'-'.$month.'-'.$year.' '.date("H:i:s");
    return($exp_date);
}

function wday_toindo($tanggal) {
    $exp = explode('-', date("Y-m-d", strtotime($tanggal)));
    $day    = $exp[2];
    $month  = $exp[1];
    $year   = $exp[0];

    $hari = date('D', strtotime($tanggal));
    $bulan = date('M', strtotime($tanggal));
    $harilist = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );

    $monList = array(
        'Jan' => 'Januari',
        'Feb' => 'Februari',
        'Mar' => 'Maret',
        'Apr' => 'April',
        'May' => 'Mei',
        'Jun' => 'Juni',
        'Jul' => 'Juli',
        'Aug' => 'Agustus',
        'Sep' => 'September',
        'Oct' => 'Oktober',
        'Nov' => 'November',
        'Dec' => 'Desember'
    );

    $exp_date = $harilist[$hari].', '.$day.' '.$monList[$bulan].' '.$year;
    return($exp_date);
}

function woday_toindo($tanggal) {
    $exp = explode('-', date("Y-m-d", strtotime($tanggal)));
    $day    = $exp[2];
    $month  = $exp[1];
    $year   = $exp[0];

    $hari = date('D', strtotime($tanggal));
    $bulan = date('M', strtotime($tanggal));

    $monList = array(
        'Jan' => 'Januari',
        'Feb' => 'Februari',
        'Mar' => 'Maret',
        'Apr' => 'April',
        'May' => 'Mei',
        'Jun' => 'Juni',
        'Jul' => 'Juli',
        'Aug' => 'Agustus',
        'Sep' => 'September',
        'Oct' => 'Oktober',
        'Nov' => 'November',
        'Dec' => 'Desember'
    );

    $exp_date = $day.' '.$monList[$bulan].' '.$year;
    return($exp_date);
}

function hari($tanggal)
{
    $day = date('D', strtotime($tanggal));
    
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    return $dayList[$day];
}

function bulan($tanggal)
{
    $month = date('M', strtotime($tanggal));

    $monList = array(
        'Jan' => 'Januari',
        'Feb' => 'Februari',
        'Mar' => 'Maret',
        'Apr' => 'April',
        'May' => 'Mei',
        'Jun' => 'Juni',
        'Jul' => 'Juli',
        'Aug' => 'Agustus',
        'Sep' => 'September',
        'Oct' => 'Oktober',
        'Nov' => 'November',
        'Dec' => 'Desember'
    );
    return $monList[$month];
}

function bulan_angka($angka)
{
    $month = $angka;

    $monList = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );
    return $monList[$month];
}

function woday_toindo_short($tanggal) {
    $exp = explode('-', date("Y-m-d", strtotime($tanggal)));
    $day    = $exp[2];
    $month  = $exp[1];
    $year   = $exp[0];

    $hari = date('D', strtotime($tanggal));
    $bulan = date('M', strtotime($tanggal));

    $monList = array(
        'Jan' => 'Jan',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'Apr' => 'Apr',
        'May' => 'Mei',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Ags',
        'Sep' => 'Sep',
        'Oct' => 'Okt',
        'Nov' => 'Nov',
        'Dec' => 'Des'
    );

    $exp_date = $day.' '.$monList[$bulan].' '.$year;
    return($exp_date);
}

?>