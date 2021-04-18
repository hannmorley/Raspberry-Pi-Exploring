<?php

session_start();

$server_ip = '10.100.0.1'; 
$server_port = 6001;  
$InputSelector = $_POST["InputSelector"]; 
$deviceid = $_SESSION["deviceID"];
$index = $deviceid - 1;
$device_code = array("\x81", "\x82", "\x83", "x\84", "\x85", "\x86");

if ($InputSelector == 'Prev')
{
  $inputid = "\x2b";
}
elseif ($InputSelector == 'Next')
{
  $inputid = "\x2c"; 
}

$message  = "\x00\x12\x00" . $device_code[$index] . "\x00\x0b\x61\x06" . $inputid . "\x00\xff";

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, $_SESSION["LocalIP"], 6001);
socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);


echo "<meta http-equiv = \"refresh\" content = \"0; URL=http://" . $_SESSION["LocalIP"] . "/controller.php\">";


?>
