<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Rome');
session_start();

include "class.lib.php";

$casi = new CovidDB();
$db   = new Database();
$db->connect();

// fonte:  https://github.com/pcm-dpc/COVID-19
$oggi = $date = date('Y-m-d', strtotime("-1 day"));
$oggi .= " 18:00:00";

$link1 = 'https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-andamento-nazionale.json';
$nazionale = '';
$nazionale = json_decode(chiamata($link1), TRUE);      //file_get_contents($link);
foreach($nazionale as $row)
{
    if ($row['data'] > $oggi) $casi->write_nazionale($row);
}






function chiamata($link)
{
    $curlSES=curl_init();
    curl_setopt($curlSES,CURLOPT_URL,$link);
    curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curlSES,CURLOPT_HEADER, false);
    $result=curl_exec($curlSES);
    curl_close($curlSES);
    return $result;
}


?>
