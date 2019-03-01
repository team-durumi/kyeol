<?php
/**
 * Created by PhpStorm.
 * User: js
 * Date: 2019-03-01
 * Time: 23:08
 */

$bitbucket_ip = array('104.192.142.0|104.192.142.255');
$webhook_ip = array();

function ip_check($webhook_ip, $visit_ip) {
    $long_ip = ip2long($visit_ip);
    if($long_ip != -1) {
        foreach($webhook_ip as $pri_addr) {
            list($start, $end) = explode('|', $pri_addr);
            if($long_ip >= ip2long($start) && $long_ip <= ip2long($end)) {
                return true;
            }
        }
    }
    return false;
}

function get_client_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if(ip_check($bitbucket_ip, get_client_ip()) == true || $_SERVER['HTTP_USER_AGENT'] == 'Bitbucket-Webhooks/2.0') {
    echo shell_exec( "cd /home/ubuntu/public_html/webzine && /usr/bin/git pull 2>&1" );
} else {
    echo 'Reject Access!';
    echo get_client_ip();
}
