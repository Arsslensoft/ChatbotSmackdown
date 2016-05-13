<?php
require_once(dirname(__FILE__)."/classes/su.inc.php");
$type = $_GET["m"];
$id = intval($_GET["id"]);
$bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
$resp="";

if($type=="gstat")
    $resp = $bpsa->getGameStatus($id);
else  $resp = $bpsa->getCompetitionStatus($id);

echo $resp;

?>
