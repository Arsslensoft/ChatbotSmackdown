<?php
/**
 * Created by PhpStorm.
 * User: Arsslen
 * Date: 08/05/2016
 * Time: 09:05
 */
require_once(dirname(__FILE__)."/classes/su.inc.php");
session_start();
if(!isset( $_SESSION['CBSDUserManagement']))
     $_SESSION['CBSDUserManagement']['user'] = "Unknown";

$bot_answer = "";
	
$username = $_SESSION['CBSDUserManagement']['user'];
$id = "";
$botname="";
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    $bot_info = $bpsa->getBotInfo($id);
    if($bot_info == null)
        die("Bot is unavailable");

$botname = $bot_info->name;
}
else die("Bot id must be defined");

if(isset($_GET["message"]))
{
    $id = $_GET["id"];
    $msg = $_GET["message"];
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    $resp = $bpsa->talkWithBot($id, $username,$msg);

    if($resp == null)
        die("Bot is unavailable");
    else die($resp->message);


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <!--
    	The codes are free, but we require linking to our web site.
    	Why to Link?
    	A true story: one girl didn't set a link and had no decent date for two years, and another guy set a link and got a top ranking in Google!
    	Where to Put the Link?
    	home, about, credits... or in a good page that you want
    	THANK YOU MY FRIEND!
    -->
    <title>TEST CHAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/chatbot.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <script src="js/jquery-1.12.3.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/chatbot.js"></script>
</head>
<body>

        <div class="chat" style="overflow: hidden; outline: none;" tabindex="5001" id="chatholder">
            <div class="col-inside-lg decor-default">
                <div class="chat-body" id="chatbox">
                    <h6>Chat with <?php echo $botname; ?></h6>
                    <div class="answer-add" id="sendbox">
                        <input placeholder="Write a message" id="messagebox"  onkeydown = "if (event.keyCode == 13) sendMessage(<?php echo $id; ?>, '<?php echo $botname; ?>', '<?php echo $username; ?>')"  >
                        <span class="answer-btn answer-btn-2" onclick="sendMessage(<?php echo $id; ?>, '<?php echo $botname; ?>', '<?php echo $username; ?>')"></span>
                    </div>
                </div>
            </div>
        </div>




</body>
</html>
