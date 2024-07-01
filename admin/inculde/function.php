<?php
$conn = mysqli_connect('localhost', 'root', '', 'sweatshop');
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);


function pr($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    die;
}



function numrows($exe)
{
$no=mysqli_num_rows($exe);
return $no;
}


function fetcharray($res)
{
    $fetch=mysqli_fetch_array($res);
    return $fetch;
}



function redirect($url)

{
    header('Location:'.$url);
    exit();
}


// .......................................... Query_with_log....................................start
function basePath()
{
    return '';
}
function getIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function query_with_log($conn, $getquery, $extra = null)
{
    $ip = getIPAddress();
    date_default_timezone_set('Asia/Kolkata');
    $time = date("d-m-y-H-i-s");
    $result = mysqli_query($conn, $getquery);
    $passpath = "query_logs/pass/";
    $failpath = "query_logs/fail/";
    $passfile = "query_logs.txt";
    $failfile = "query_logs.txt";
    if (!file_exists($failpath)) {
        mkdir($failpath, 0777, true);
    }
    if (!file_exists($passpath)) {
        mkdir($passpath, 0777, true);
    }
    if ($result) {
        $fp = fopen($passpath . $passfile, 'a');
        fwrite($fp, "\n" . ($getquery) . ", Extra:" . $extra . ", IP:" . $ip . ", TIME:" . $time . "\n");
        fclose($fp);
        return $result;
    } else {
        $fp = fopen($failpath . $failfile, 'a');
        fwrite($fp, "\n" . ($getquery) . ", Extra:" . $extra . ", IP:" . $ip . ", TIME:" . $time . "\n");
        fclose($fp);
        return $result;
    }
}

function query_with_log_admin($conn, $getquery, $extra = null)
{
    $ip = getIPAddress();
    date_default_timezone_set('Asia/Kolkata');
    $time = date("d-m-y-H-i-s");
    $result = mysqli_query($conn, $getquery);
    $passpath = "query_logs_admin/pass/";
    $failpath = "query_logs_admin/fail/";
    $passfile = "query_logs.txt";
    $failfile = "query_logs.txt";
    if (!file_exists($failpath)) {
        mkdir($failpath, 0777, true);
    }
    if (!file_exists($passpath)) {
        mkdir($passpath, 0777, true);
    }
    if ($result) {
        $fp = fopen($passpath . $passfile, 'a');
        fwrite($fp, "\n" . ($getquery) . ", Extra:" . $extra . ", IP:" . $ip . ", TIME:" . $time . "\n");
        fclose($fp);
        return $result;
    } else {
        $fp = fopen($failpath . $failfile, 'a');
        fwrite($fp, "\n" . ($getquery) . ", Extra:" . $extra . ", IP:" . $ip . ", TIME:" . $time . "\n");
        fclose($fp);
        return $result;
    }
}
// .......................................... Query_with_log....................................End
