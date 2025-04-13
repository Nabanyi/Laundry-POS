<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Generate Tokens
function GetToken($length)
{
    $random_hash = substr(bin2hex(openssl_random_pseudo_bytes($length)), 0, 24);
    return $random_hash;
}

// Output Response
function response($status = true, $msg, $result = null)
{
    die(json_encode(array("status" => $status, "message" => $msg, "result" => $result)));
}

//convert time to time ago
function get_time_ago($time)
{
    $time_difference = time() - $time;

    if ($time_difference < 1) {return '1 sec ago';}
    $condition = array(12 * 30 * 24 * 60 * 60 => 'yr',
        30 * 24 * 60 * 60                         => 'mth',
        24 * 60 * 60                              => 'day',
        60 * 60                                   => 'hr',
        60                                        => 'min',
        1                                         => 'sec',
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}

//calculate number of days from a future date
function days_left_from_today($future_date)
{
    $today_date = date('Y-m-d H:i:s');
    $datediff   = strtotime($future_date) - strtotime($today_date);
    return round($datediff / (60 * 60 * 24));
}

function ageToDays($age)
{
    $current_date = date_create(date('Y-m-d'));
    date_sub($current_date, date_interval_create_from_date_string($age));
    $dob = date_format($current_date, "Y-m-d");

    $today_date = date('Y-m-d H:i:s');
    $datediff   = strtotime($today_date) - strtotime($dob);
    return round($datediff / (60 * 60 * 24));
}
//echo ageToDays("0 years 1 day");

function convert_number_to_words($amt, $currency = null)
{
    if ($currency == "" or $currency == 'cedis') {
        $main  = " Ghana Cedis ";
        $small = " Pesewas ";
    } elseif ($currency == "dollars") {
        $main  = " Dollars ";
        $small = " Cents ";
    }
    $amt  = @number_format($amt, 2, '.', '');
    $thea = explode(".", $amt);

    $words = convert_number($thea[0]) . $main;

    if ($thea[1] > 0) {
        $words .= convert_number($thea[1]) . $small;
    }

    return $words;
}

function convert_number($number)
{
    if (($number < 0) || ($number > 999999999)) {
        return "$number";
    }

    $Gn         = floor($number / 1000000); /* Millions (giga) */
    $number    -= $Gn * 1000000;
    $kn         = floor($number / 1000); /* Thousands (kilo) */
    $number    -= $kn * 1000;
    $Hn         = floor($number / 100); /* Hundreds (hecto) */
    $number    -= $Hn * 100;
    $Dn         = floor($number / 10); /* Tens (deca) */
    $n          = $number % 10; /* Ones */

    $res = "";

    if ($Gn) {
        $res .= convert_number($Gn) . " Million";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
        convert_number($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
        convert_number($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}

function days_from_today($trans_date)
{
    $today_date = date('Y-m-d');
    $datediff = strtotime($today_date) - strtotime($trans_date);
    return round($datediff / (60 * 60 * 24));
}
