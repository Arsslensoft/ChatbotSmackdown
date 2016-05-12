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
        die("Qm90IGlzIHVuYXZhaWxhYmxl");

$botname = $bot_info->name;
}
else die("Qm90IGlkIG11c3QgYmUgZGVmaW5lZA==");

if(isset($_GET["message"]))
{
    $id = $_GET["id"];
    $msg = $_GET["message"];
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    
    $resp = $bpsa->talkWithBot($id, $username,$msg);

    if($resp == null)
        die("Qm90IGlzIHVuYXZhaWxhYmxl");
    else die($resp->message);


}
?>
