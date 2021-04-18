<?php

session_start();

$server_ip = '10.100.0.1'; 
$server_port = 6001;  
$InputSelector = $_POST["InputSelector"]; 
$zoneid = $_SESSION["ZoneID"]; 
$index = $zoneid - 1;
$zone_code = array("\x21", "\x22", "\x23", "\x24", "\x25", "\x26");

if ($InputSelector == 'Vol+')
{
  $inputid = "\x0c"; 
}
elseif ($InputSelector == 'Vol-')
{
  $inputid = "\x0d";
}

$message = "\x00\x12\x00" . $zone_code[$index] . "\x00\x0b\x61\x06" . $inputid . "\x00\xff";

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, $_SESSION["LocalIP"], 6001);
for ($x=1; $x<=5; $x++){
    socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
}


echo "<meta http-equiv = \"refresh\" content = \"0; URL=http://" . $_SESSION["LocalIP"] . "/controller.php\">";

?>
