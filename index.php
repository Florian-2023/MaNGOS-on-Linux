<?php

// Account creation must now be done with SOAP!

// Configuration.
include("websiteconfig.php");
// End config.


// Check if Account creation is availlable
if (!$unlocked)
  {
  $soappassword = '';
  }

$user_chars = "#[^a-zA-Z0-9_\-]#";
$email_chars = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

$result = "";
$realm = "";


 
// Check connection
$con = @mysqli_connect($ip, $user, $pass, $r_db);
if (mysqli_connect_errno())
  {
	$result = "> Unable to connect to database: " . mysqli_connect_error();
}
else
{

// Find address for realmlist in DB
$sql = "SELECT address FROM  realmlist WHERE id= 1";
	$qry = @mysqli_query($con, $sql );
    if ($qry)
    {
        while ($row = mysqli_fetch_assoc($qry))
        {
            $realm = $row['address'];
        }
    }
    

//Check data to create the new account
    if (!empty($_POST)) {
        if ((empty($_POST["username"]))||(empty($_POST["password"]))||(empty($_POST["email"])))
        {
            $result = "> You did not enter all the required information.";
        }
        else
        {
            $username = strtoupper($_POST["username"]);
            $password = strtoupper($_POST["password"]);
            $password2 = strtoupper($_POST["password2"]);
            $email = strtoupper($_POST["email"]);
            if (strlen($username) < 4) {
                $result = "> Username too short.";
            };
            if (strlen($username) > 14) {
                $result = "> Username too long.";
            };
            if (strlen($password) < 3) {
                $result = "> Password too short.";
            };
            if (strlen($password) > 12) {
                $result = "> Password too long.";
            };
            if ($password!=$password2) {
                $result = "> Passwords do not match.";
            };
            if (strlen($email) < 10) {
                $result = "> Email was too short.";
            };
            if (strlen($email) > 50) {
                $result = "> Email was too long.";
            };
            if (preg_match($user_chars,$username)) {
                    $result = "> Username contained illegal characters.";
            };
            if (preg_match($user_chars,$password)) {
                    $result = "> Password contained illegal characters.";
            };
            if (!preg_match($email_chars,$email)) {
                    $result = "> Email was in an incorrect format.";
            };
            if (strlen($result) < 1)
            {
                $command = "account create ";
                $client = new SoapClient(NULL,
                array(
                    "location" => "http://$soaphost:$soapport/",
                    "uri" => "urn:MaNGOS",
                    "style" => SOAP_RPC,
                    'login' => $soapusername,
                    'password' => $soappassword
                ));
                $command = $command . $username . " " . $password . " " . $password2;
                try {
                    $result = $client->executeCommand(new SoapParam($command, "command"));
                }
                catch (Exception $e)
                {
                    $result = $e->getMessage();
 // Check if Account creation is availlable
                if (!$unlocked)
                {
                $result = "Account can not be created";
                }
                }
            };
        };
    };
};
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Account Creation - brotalnia's repack</title>
<style>
hr,img
{
border:0
}
hr
{
box-sizing:content-box;height:0;margin-top:10px;margin-bottom:10px;border-top:1px solid #eee
}
.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6
{
font-family:inherit;font-weight:500;line-height:1.1;color:inherit
}
.h1,.h2,.h3,h1,h2,h3
{
margin-top:20px;margin-bottom:10px
}
.h4,.h5,.h6,h4,h5,h6
{
margin-top:10px;margin-bottom:10px
}
.h1,h1
{
font-size:36px
}
.content,.wrapper .main
{
width:100%;margin:0 auto
}


img
{
vertical-align:middle
}
button,input,optgroup,select,textarea
{
color:inherit;font:inherit;margin:0
}
button,html input[type=button],input[type=reset],input[type=submit]
{
-webkit-appearance:button;cursor:pointer
}
button[disabled],html input[disabled]
{
cursor:default
}
button::-moz-focus-inner,input::-moz-focus-inner
{
border:0;padding:0
}
*,:after,:before
{
-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box
}
html
{
font-size:10px;-webkit-tap-highlight-color:transparent
}
a:focus,a:hover
{
color:#5a5a5a;text-decoration:underline
}
p
{
margin:0 0 10px
}
dl,ol,ul
{
margin-top:0
}
address,dl
{
margin-bottom:20px
}
code,kbd
{
padding:2px 4px;font-size:90%
}
code
{
color:#c7254e;background-color:#f9f2f4;border-radius:4px
}
.my-btn,.start-btn
{
text-transform:uppercase
}
a,body
{
color:#fff
}
.red
{
color:red
}
.content
{
position:relative;padding:0 50px;max-width:960px;top:50%;transform:translate(0,-50%);transition:all .2s ease-out;z-index:1
}
.content-big
{
max-width:1170px
}
.arrow-btn:hover,.form .mana-button:hover,.start-btn:active,.start-btn:focus,.start-btn:hover
{
box-shadow:0 0 10px 1px red,0 0 10px 1px red inset
}
.form
{
margin:20px 0 0
}
.form input
{
display:block;padding:0 15px;font:300 1.5em Roboto,sans-serif;margin-bottom:10px;border:1px solid #fff
}
.form .mana-button
{
color:red;font:500 1.5em Roboto,sans-serif;border:1px solid red
}
.form .mana-button:hover
{
border-color:red
}
button
{
transition:all ease .5s
}
button:focus
{
outline:0
}
.cols
{
margin-left:-15px;margin-right:-15px
}
.cols:after
{
display:table
}
[class*=cols-col-]
{
position:relative;float:left;width:100%;padding-left:15px;padding-right:15px
}
.cols-col-50
{
width:50%
}
.news-list-tr-sm
{
opacity:.8
}
.link
{
display:inline-block;text-decoration:underline;font-size:14px
}
.link:focus,.link:hover,.my-btn,.nav li a,a.btn
{
text-decoration:none
}
.my-btn
{
display:block;border:1px solid #fff;text-align:center;padding:4px;margin-bottom:5px
}
.my-btn:focus,.my-btn:hover
{
background:#fff;color:#101010;text-decoration:none
}
.dark-background
{
background:rgba(16,16,16,.9)!important;background-blend-mode:multiply;overflow:hidden
}
body,html
{
overflow:visible;font-family:Proxima Nova,sans-serif
}

.manas h4
{
line-height:40px;font:600 2em RobotoB,sans-serif!important;font-size:24px;border-bottom:2px solid #000;padding:5px 20px 14px
}
.manas h4 span
{
color:#999
}
.manas .mana-input
{
min-height:40px;background:#080808!important;margin-left:20px;width:85%;padding:10px 15px;outline:0;border:0;text-transform:none
}
.manas .mana-button
{
height:40px;background:#101010;width:auto;margin-left:20px!important;margin-bottom:30px!important;padding:10px 15px;outline:0;border:1px solid #000;color:#b9b9b9;text-transform:uppercase;letter-spacing:1.5px;font:300 1em Roboto,sans-serif;text-decoration:none
}
.manas .mana-button:hover
{
color:#fff
}
.mana-label
{
line-height:30px;padding-left:20px;padding-right:20px;float:left;display:inline-block;font-size:16px
}

#wrapper {
     position: relative;
     height: 100%;
     width: 100%;
   }
#header {
    -webkit-box-sizing:content-box;
    -moz-box-sizing:content-box;
    box-sizing:content-box;
    background-color:rgb(3, 34, 76);
    color:white;
    text-align:center;
    padding:5px;
}
#nav {
    -webkit-box-sizing:content-box;
    -moz-box-sizing:content-box;
    box-sizing:content-box;
    position: absolute;
    line-height:30px;
    background-color: #033553;
    height: calc(100vh - 38px);
    height: -o-calc(100vh - 38px); /* opera */
    height: -webkit-calc(100vh - 38px); /* google, safari */
    height: -moz-calc(100vh - 38px); /* firefox */
    width:150px;
    float:left;
    padding:5px;
    color:rgb(255, 165, 0);
    font-weight: bold;
    font-size: 15px;

}
#nav a:link { color: rgb(255, 165, 0); }
#nav a:visited { color: rgb(255, 165, 0); }
#nav a:hover { color: #7FFF00; }
#nav a:active { color: rgb(255, 165, 0); }
#section {
    -webkit-box-sizing:content-box;
    -moz-box-sizing:content-box;
    box-sizing:content-box;
    background-image: url('images/sylvanas.jpg');
    background-size:100%;
    width: calc(100% - 175px);
    width: -o-calc(100% - 175px); /* opera */
    width: -webkit-calc(100% - 175px); /* google, safari */
    width: -moz-calc(100% - 175px); /* firefox */
    height: calc(100vh - 30px);
    height: -o-calc(100vh - 30px); /* opera */
    height: -webkit-calc(100vh - 30px); /* google, safari */
    height: -moz-calc(100vh - 30px); /* firefox */
    float:left;
    padding-left:175px;		 
}
#footer {
    background-color:rgb(3, 34, 76);
    color:white;
    clear:both;
    text-align:center;
    padding:5px;
    font-size: 16px;
}
#regresult {
    font-size: 16px;
    font-weight: bold;
    padding-left:20px;	
}
body {
    margin:0;
    height: 100%;
    width: 99%;
    background-color:#000000;
}
</style>
</head>
<body>

<div id="header">
<h1>Vanilla Repack</h1>
</div>
<div id="wrapper">
<div id="nav">
<a href="http://www.youtube.com/brotalnia" style="text-decoration:none"><img src="images/youtube.png" alt="[1]" width="16" height="16"> My Channel</a><br>
<hr>
<a href="index.php" style="text-decoration:none"><img src="images/mangos.png" alt="[2]" width="16" height="16"> Registration</a><br>
<a href="info.php" style="text-decoration:none"><img src="images/lfg.png" alt="[3]" width="16" height="16"> Information</a><br>
<hr>
<div align="center">
<a href="http://www.ownedcore.com/forums/world-of-warcraft/world-of-warcraft-emulator-servers/wow-emu-general-releases/613280-elysium-core-1-12-repack-including-mmaps-optional-vendors.html" style="text-decoration:none"><img src="images/ocbanner.png" alt="OwnedCore" width="88" height="31"></a><br>
</div>
</div>
<div id="section">
<div class="content content-big">
<div class="manas">
<div class="cols">
<div class="row dark-background">
<div class="cols-col-50">
<?php if ($unlocked): ?>
<h4>Account Creation</h4>
<?php else: ?>
<h4>Account Creation  is locked!</h4>
<?php endif ?>
<div class="mana-label">
<p>
Note: This is a simple account creation page for people who wish to make their server public. Additionally, you may view basic information and statistics about your server, such as accounts created, online player count, and uptime.<br>
<strong>Make sure that MySQL is running before trying to create an account. Accounts created through the web page are normal ones and do not have gm privileges.</strong><br>
<span class="red">Use completely new Username and Password!</span>
</p>
</div>
<form name="form" class="form" method="post" action="index.php">
<br>
<input id="form_username" name="username" required="required" class="mana-input" placeholder="Username" type="text">
<input id="form_password_first" name="password" required="required" class="mana-input" placeholder="Password" type="password">
<input id="form_password_second" name="password2" required="required" class="mana-input" placeholder="Repeat password" type="password">
<input id="form_email" name="email" required="required" class="mana-input" placeholder="Email" type="email">
<div>
<br>
<p class="red" id="regresult"><?php if(isset($result)){ echo $result; } ?></p>
<button type="submit" id="form_save" name="form[save]" class="mana-button">Register</button>
</div>
<input id="form__token" name="form[_token]" value="7XaIY8g-l6N51oQuzMtr8Ph3RJk6C9DEAjs-BpJUAbA" type="hidden"></form>
</div>
<div class="cols-col-50">
<h4>Repack instructions</h4>
<div class="mana-label">
<a href="https://www.youtube.com/watch?v=dDQs1t5fZWo" class="my-btn">
How to compile the Nostalrius Core on Windows
</a>
<ol>
<li>Start the MySQL database</li>
<li>
Change the realm IP to make it public:<br>
Screenshots: <a href="tutorial.html" target="_blank">HeidiSQL</a> | <a href="images/tutorial/batch.png" target="_blank">Batch File</a> (Optional)<br>
</li>
<li>Start the login server (realmd.exe)</li>
<li>Start the world server (mangosd.exe)</li>
<li>Edit the content of the file <code>realmlist.wtf</code> to:<br><code>set realmlist <?php if(isset($realm)){ echo $realm; } else { echo "127.0.0.1";} ?></code></li>
<li>Play!</li>
</ol>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<div id="footer">
Subscribe to my channel on <a href="http://www.youtube.com/brotalnia" style="color:#FF0000">Youtube</a>
</div>
</div>
</body>
</html>