<?php

session_start();
require_once(dirname(__FILE__)."/classes/su.inc.php");
$CBSDUM = new CBSDUserManagement();
$ccm = new CBSDCompetitionManagement;
$loggedin = $CBSDUM->logged_in;
$type = $_GET["m"];
$id = intval($_GET["id"]);
if($type=="gstat")
{
$game =$ccm->getGame($id);
    echo $game->Status;
}
else
{
    $compet =$ccm->getCompetition($id);
    echo $compet->Status;
}
/*

$bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
$resp="";

if($type=="gstat")
    $resp = $bpsa->getGameStatus($id);
else  $resp = $bpsa->getCompetitionStatus($id);

echo $resp;
*/
?>
