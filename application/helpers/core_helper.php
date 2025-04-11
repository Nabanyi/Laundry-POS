<?php

function success($message)
{
    die(json_encode(array('status' => 'success', 'message' => $message)));
}

function fail($message)
{
    die(json_encode(array('status' => 'fail', 'message' => $message)));
}

function report($state, $error, $message)
{
    die(json_encode(array('status' => $state, 'errors' => $error, 'message' => $message)));
}

function budget_alert($item_code, $item_description, $type)
{
    die(json_encode(array('status' => 'budget', 'code' => $item_code, 'account' => $item_description, 'type' => $type)));
}

function fail_log($message)
{
    die(json_encode(array('status' => 'log_report', 'message' => $message)));
}

function containsDecimal($value)
{
    if (strpos($value, ".") !== false) {
        return true;
    }
    return false;
}

function extract_date_year($date)
{
    $date_arr = explode('-', $date);
    return $date_arr[0];
}

function extract_date_month($date)
{
    $date_arr = explode('-', $date);
    return $date_arr[1];
}

function filter_extension($extension)
{
    $ext_arr = explode('.', $extension);

    return $ext_arr[(sizeof($ext_arr) - 1)];
}

function array_to_str_query($arr)
{
    $str      = "(";
    $arr_size = sizeof($arr);

    for ($i = 0; $i < $arr_size; $i++) {
        $j = $i + 1;
        $str .= "'" . $arr[$i] . "'";
        if ($arr_size > 1 && $j < $arr_size) {
            $str .= ",";
        }

    }

    return $str . ')';
}

function valid_date($dateStr, $format)
{
    date_default_timezone_set('UTC');
    $date = DateTime::createFromFormat($format, $dateStr);
    return $date && ($date->format($format) === $dateStr);
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function convert_time($time)
{
    $time = strtotime($time);
    return $time;
}

function format_date($date)
{
    //$this_date = date_create($date);
    $this_date   = convert_time($date);
    $date_format = date_convert($this_date);
    return $date_format;
}
function format_date_short($date)
{
    $this_date = convert_time($date);
    //$date_format = date_convert($this_date);
    $date_format = date('d M, y', $this_date);
    return $date_format;

}

function date_convert($time)
{

    $cur_time = date('d M, Y', $time); // F will bring the entire date..
    return $cur_time;
}

function format_datetime($date)
{
    $this_date   = convert_time($date);
    $data_format = date('d, M Y', $this_date);

}

//get the current number of Journal to be displayed.. after we've successfully added a journal, then the form is cleared.. for a new entry..
function journal_count()
{
    $this->load->model('transaction_model');

    $journal_count = $this->transaction_model->count_transaction('Journal Entry');
    //add 1 to it
    $journal_count += 1;

    echo json_encode(array('total' => $journal_count));
}

function getDaysDate($date, $days)
{

    $date = strtotime("+" . $days . " days", strtotime($date));
    return date("Y-m-d", $date);

}

function convert_number2($number)
{
    if (($number < 0) || ($number > 999999999)) {
        return "$number";
    }

    $Gn = floor($number / 1000000); /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000); /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100); /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10); /* Tens (deca) */
    $n  = $number % 10; /* Ones */

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

    //$thea=explode(".",$res);

}

function convert_number_to_words2($amt, $currency = null)
{
    //$amt = "190120.09" ;
    if ($currency == "" or $currency == 'cedis') {
        $main  = " Ghana Cedis ";
        $small = " Pesewas ";
    } elseif ($currency == "dollars") {
        $main  = " Dollars ";
        $small = " Cents ";

    }
    $amt  = @number_format($amt, 2, '.', '');
    $thea = explode(".", $amt);

    //echo $thea[0];

    $words = convert_number($thea[0]) . $main;
    if ($thea[1] > 0) {$words .= convert_number($thea[1]) . $small;}

    return $words;

}

function Numeric($length)
{
    $chars = "1234567890";
    $clen  = strlen($chars) - 1;
    $id    = '';

    for ($i = 0; $i < $length; $i++) {
        $id .= $chars[mt_rand(0, $clen)];
    }
    return ($id);
}

function print_page($url, $title = null)
{

    echo "<button title='" . $title . "' onclick='window.open(\"" . $url . "\", \"popupWindow\", \"width=1250, height=842, scrollbars=yes\")'class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-print'></span></button>";

}

function print_page2($url, $title = null)
{

    return "<span class='glyphicon glyphicon-print print-print text-primary' title='" . $title . "' onclick='window.open(\"" . $url . "\", \"popupWindow\", \"width=1250, height=842, scrollbars=yes\")'> </span>";
}