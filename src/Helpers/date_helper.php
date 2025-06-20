<?php

function adhoc_to_unix($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg   = substr($datestr, 0, 2);
    $mm   = substr($datestr, 3, 2);
    $yyyy = substr($datestr, 6, 4);

    if (strlen($datestr) > 10) {
        $hh = substr($datestr, -8, 2);
        $ii = substr($datestr, -5, 2);
        $ss = substr($datestr, -2, 2);
    } else {
        $hh = "00";
        $ii = "00";
        $ss = "00";
    }

    return mktime($hh, $ii, $ss, $mm, $gg, $yyyy);
}

function adhoc_to_mysql($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg   = substr($datestr, 0, 2);
    $mm   = substr($datestr, 3, 2);
    $yyyy = substr($datestr, 6, 4);
    $hh   = "00";
    $ii   = "00";
    $ss   = "00";
    //                    if (strlen($datestr) > 10)
    //                        {
    //                            $hh = substr($datestr,-8,2);
    //                            $ii = substr($datestr,-5,2);
    //                            $ss = substr($datestr,-2,2);                        
    //                        }
    //                        else
    //                            {
    //                                $hh = "00";
    //                                $ii = "00";
    //                                $ss = "00";                            
    //                            }

    $mysql = "$yyyy-$mm-$gg $hh:$ii:$ss";

    return $mysql;
}

function mysql_to_human1($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg    = substr($datestr, 8, 2); //   2016-08-31 00:00:00
    $mm    = substr($datestr, 5, 2);
    $yyyy  = substr($datestr, 0, 4);
    $hh    = substr($datestr, -8, 2);
    $ii    = substr($datestr, -5, 2);
    $ss    = substr($datestr, -2, 2);
    $uman1 = "$gg/$mm/$yyyy";

    return $uman1;
}

function mysql_to_human2($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg    = substr($datestr, 8, 2); //   2016-08-31 00:00:00
    $mm    = substr($datestr, 5, 2);
    $yyyy  = substr($datestr, 0, 4);
    $hh    = substr($datestr, -8, 2);
    $ii    = substr($datestr, -5, 2);
    $ss    = substr($datestr, -2, 2);
    $uman2 = "$gg/$mm/$yyyy $hh:$ii";

    return $uman2;
}

function mysql_to_human3($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg    = substr($datestr, 8, 2); //   2016-08-31 00:00:00
    $mm    = substr($datestr, 5, 2);
    $yyyy  = substr($datestr, 0, 4);
    $hh    = substr($datestr, -8, 2);
    $ii    = substr($datestr, -5, 2);
    $ss    = substr($datestr, -2, 2);
    $uman3 = "$hh:$ii:$ss";

    return $uman3;
}

function datediff($tipo, $partenza, $fine)
{
    switch ($tipo) {
        case "A":
            $tipo = 365;
            break;
        case "M":
            $tipo = (365 / 12);
            break;
        case "S":
            $tipo = (365 / 52);
            break;
        case "G":
            $tipo = 1;
            break;
    }

    $date_diff = mysql_to_unix($fine) - mysql_to_unix($partenza);
    $date_diff = floor(($date_diff / 60 / 60 / 24) / $tipo);
    return $date_diff;
}
function mysql_to_unix($datestr = '')
{
    if ($datestr === '') {
        return FALSE;
    }

    $gg = substr($datestr, 8, 2); //   2016-08-31 00:00:00
    $mm = substr($datestr, 5, 2);
    $yyyy = substr($datestr, 0, 4);
    $hh = substr($datestr, -8, 2);
    $ii = substr($datestr, -5, 2);
    $ss = substr($datestr, -2, 2);
    $unix = mktime($hh, $ii, $ss, $mm, $gg, $yyyy);

    return $unix;
}
function now_to_datetime()
{
    $now = date("Y-m-d H:i:s");

    return $now;
}

function data_maintrack($datestr)    //YYYY-MM-DD HH:MM:SS
{
    $gg    = substr($datestr, 8, 2); //   2016-08-31 00:00:00
    $mm    = substr($datestr, 5, 2);
    $yyyy  = substr($datestr, 0, 4);
    $hh    = substr($datestr, -8, 2);
    $ii    = substr($datestr, -5, 2);
    $ss    = substr($datestr, -2, 2);
    $uman2 = "$yyyy$mm$gg$hh$ii$ss";

    return $uman2;
}
function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us')
{
    $r = date('Y', $time) . '-' . date('m', $time) . '-' . date('d', $time) . ' ';

    if ($fmt === 'us') {
        $r .= date('h', $time) . ':' . date('i', $time);
    } else {
        $r .= date('H', $time) . ':' . date('i', $time);
    }

    if ($seconds) {
        $r .= ':' . date('s', $time);
    }

    if ($fmt === 'us') {
        return $r . ' ' . date('A', $time);
    }

    return $r;
}
function unix_to_mysql($time = '')
{
    $r = date('Y', $time) . '-' . date('m', $time) . '-' . date('d', $time) . ' ' . date('H', $time) . ':' . date('i', $time) . ':' . date('s', $time);


    return $r;
}
function nice_date($bad_date = '', $format = FALSE)
{
    if (empty($bad_date)) {
        return 'Unknown';
    } elseif (empty($format)) {
        $format = 'U';
    }

    // Date like: YYYYMM
    if (preg_match('/^\d{6}$/i', $bad_date)) {
        if (in_array(substr($bad_date, 0, 2), array('19', '20'))) {
            $year  = substr($bad_date, 0, 4);
            $month = substr($bad_date, 4, 2);
        } else {
            $month  = substr($bad_date, 0, 2);
            $year   = substr($bad_date, 2, 4);
        }

        return date($format, strtotime($year . '-' . $month . '-01'));
    }

    // Date Like: YYYYMMDD
    if (preg_match('/^\d{8}$/i', $bad_date, $matches)) {
        return DateTime::createFromFormat('Ymd', $bad_date)->format($format);
    }

    // Date Like: MM-DD-YYYY __or__ M-D-YYYY (or anything in between)
    if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/i', $bad_date, $matches)) {
        return date($format, strtotime($matches[3] . '-' . $matches[1] . '-' . $matches[2]));
    }

    // Any other kind of string, when converted into UNIX time,
    // produces "0 seconds after epoc..." is probably bad...
    // return "Invalid Date".
    if (date('U', strtotime($bad_date)) === '0') {
        return 'Invalid Date';
    }

    // It's probably a valid-ish date format already
    return date($format, strtotime($bad_date));
}
function dtp_ita_to_mysqldatetime($datestr = '')    //dal datetimepicker italiano 12/03/1956 12:30:00
{
    $datestr = trim($datestr);
    $lung = strlen($datestr);
    if ($datestr === '' or $lung < 10) {
        return FALSE;
    }
    $gg    = substr($datestr, 0, 2);
    $mm    = substr($datestr, 3, 2);
    $yyyy  = substr($datestr, 6, 4);
    switch ($lung) {
        case 10: // 12/03/1956
            $mysql = "$yyyy-$mm-$gg";
            return $mysql;
            break;
        case 16: // 12/03/1956 12:30
            $hh    = substr($datestr, 11, 2);
            $ii    = substr($datestr, 14, 2);
            $ss    = '00';
            break;
        case 19: // 12/03/1956 12:30:00
            $hh    = substr($datestr, 11, 2);
            $ii    = substr($datestr, 14, 2);
            $ss    = substr($datestr, 17, 2);
            break;
        default:
            $hh    = '00';
            $ii    = '00';
            $ss    = '00';
            break;
    }
    $mysql = "$yyyy-$mm-$gg $hh:$ii:$ss";

    return $mysql;
}