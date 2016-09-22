<?php

session_start();

function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
/*

function get_visitors_country($ip){
    $visitors_data = json_decode(file_get_contents("https://freegeoip.net/json/$ip"),true);
    return $visitors_data;
}
function get_visitors_language($c_code){
    $visitors_data = json_decode(file_get_contents("https://restcountries.eu/rest/v1/alpha/VE"),true);
    return $visitors_data;
}

$visitors_country = get_visitors_country('190.72.53.235');
$visitors_language= get_visitors_language($visitors_country['country_code']);
echo 'Country: '.$visitors_country['country_name'].'<br>';
echo  'Language: '.$visitors_language['languages'][0];*/
    
// This Function is to be uploaded to the server

function get_visitors_country($ip){
    $ch = curl_init();
    $url = "https://freegeoip.net/json/$ip";
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);    
    return json_decode($data,true);
}

function get_visitors_language($c_code){
    $ch = curl_init();
    $url = "https://restcountries.eu/rest/v1/alpha/$c_code";
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);    
    return json_decode($data,true);
}

$ip = get_client_ip_server();
$visitors_country=get_visitors_country($ip);
$visitors_language= get_visitors_language($visitors_country['country_code']);

//echo 'Country: '.$visitors_country['country_name'].'<br>';
//echo  'Language: '.$visitors_language['languages'][0];
/*
if(!isset($_SESSION['lang']) && empty($_SESSION['lang']))
    $_SESSION['lang']=$visitors_language;

if($_SESSION['lang']=='es'){
    header('Location: es');
}
elseif($_SESSION['lang']=='pt')
    header('Location: pt');
else
    header('Location: home');*/

?>