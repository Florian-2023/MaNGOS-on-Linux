<?php


// For account creation we have to use SOAP now
// To lock Account Creation, set to "0"
$unlocked = "1";
//$unlocked = "0";

// To make an account with SOAP, you need a level 4 (6?) GM account:
$soapusername = 'admin';
// password of GM-level 6 
$soappassword = 'admin';


// SOAP IP (default = 127.0.0.1) (check mangosd.conf!)
 $soaphost = "127.0.0.1";
// SOAP-port // (default = 7878)
$soapport = 7878;


// To access the database
// Database-Username (default = "mangos")
$user = "mangos";
// Database-Password (default = "mangos")
$pass = "mangos";


// Database IP :and port (default = "127.0.0.1:3306" )
$ip = "127.0.0.1:3306";
// Realm database (default = "realmd")
$r_db = "realmd";
// Character database (default = "characters")
$c_db = "characters";
// mangos database (default = "mangos")
$m_db = "mangos";

// Images directory.
$img_base = "images/";

// Autorefresh serverinfo-page after e.g. 60 seconds, or off
$autorefresh = 60;

?>

