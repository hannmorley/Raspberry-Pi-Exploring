<?php

session_start();

$server_ip = '10.100.0.1'; 
$server_port = 6001;  
$InputSelector = $_POST["InputSelector"]; 
$zone = $_SESSION["Zone"];
$navigation = $_SESSION["navigation"]; 

// print ("input = " . $InputSelector . "<br>" . "Zone = " . $zone . "<br>"); 

if ($zone == 'Living Room') 
{ 
  $zoneid = "\x21";
}
elseif ($zone == 'Kitchen')
{
  $zoneid = "\x22";
}
elseif ($zone == 'Zone 3')
{
  $zoneid = "\x23"; 
}
elseif ($zone == 'Patio')
{
  $zoneid = "\x24"; 
}
elseif ($zone == 'M Bath')
{
  $zoneid = "\x25"; 
}
elseif ($zone == 'Basement')
{
  $zoneid = "\x26"; 
}
else 
{
print "No Zone Match <br>";
}

if ($InputSelector == 'AM_FM') 
{
  $inputid = "\x01";
}
elseif ($InputSelector == 'Wanpen')
{
  $inputid = "\x02";
}
elseif ($InputSelector == 'TV')
{
  $inputid = "\x03"; 
}
elseif ($InputSelector == 'Echo')
{
  $inputid = "\x04"; 
}
elseif ($InputSelector == 'Glen')
{
  $inputid = "\x05"; 
}
elseif ($InputSelector == 'John')
{
  $inputid = "\x06"; 
}
elseif ($InputSelector == 'Vol+')
{
  $inputid = "\x0c"; 
}
elseif ($InputSelector == 'Vol-')
{
  $inputid = "\x0d";
}
elseif ($InputSelector == 'Prev')
{
  $inputid = "\x2b";
}
elseif ($InputSelector == 'Next')
{
  $inputid = "\x2c"; 
}
elseif ($InputSelector == 'Off')
{
  $inputid = "\x0a"; 
}
else {
print "No Input Match <br>";
}

$message = "\x00\x12\x00" . $zoneid . "\x00\x0b\x61\x06" . $inputid . "\x00\xff";

//            \x00\x0e\x00     \x23       \x00\x0b\x61\x06     \x03     \x00\xff

if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
    socket_bind($socket, $_SESSION["LocalIP"], 6001);
    socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
}
else {
  print("can't create socket\n");
}

if ($InputSelector == 'Vol*'){
    for ($x=1; $x<=5; $x++){
         socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
    }
}

echo "<meta http-equiv = \"refresh\" content = \"1; URL=http://" . $_SESSION["LocalIP"] . "/controller.php\">";

