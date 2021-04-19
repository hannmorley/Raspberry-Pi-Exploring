<?php

session_start();

//  This program builds and then sends a control string to the Niles GXR2 based on inputs received from controller.php

$server_ip = '10.100.0.1'; 
$server_port = 6001;  
$InputSelector = $_POST["InputSelector"]; 
$zone = $_SESSION["Zone"];
$navigation = $_SESSION["navigation"]; 

// Choose zone ID

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

// Choose input ID

if ($InputSelector == 'Input1') 
{
  $inputid = "\x01";
}
elseif ($InputSelector == 'Input2')
{
  $inputid = "\x02";
}
elseif ($InputSelector == 'Input3')
{
  $inputid = "\x03"; 
}
elseif ($InputSelector == 'Input4')
{
  $inputid = "\x04"; 
}
elseif ($InputSelector == 'Input5')
{
  $inputid = "\x05"; 
}
elseif ($InputSelector == 'Input6')
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

// Build control string and store it in $message

$message = "\x00\x12\x00" . $zoneid . "\x00\x0b\x61\x06" . $inputid . "\x00\xff";

//  Open a UDP socket

if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
    socket_bind($socket, $_SESSION["LocalIP"], 6001);
  
//  Send the message
  
socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
}
else {
  print("can't create socket\n");
}


// If the control string is for vol+ or vol-, send it five times because volume changes for individual messages are
// very small

if ($InputSelector == 'Vol*'){
    for ($x=1; $x<=5; $x++){
         socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
    }
}

echo "<meta http-equiv = \"refresh\" content = \"1; URL=http://" . $_SESSION["LocalIP"] . "/controller.php\">";

