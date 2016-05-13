<?php
require_once(dirname(__FILE__)."/classes/su.inc.php");
$gid = intval($_GET["id"]);
$fid = intval($_GET["fid"]);
$sid = intval($_GET["sid"]);
$bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
$resp = $bpsa->getGameHistory($gid);
$gamehist = json_decode($resp);

foreach ($gamehist->{'history'}->{'Entries'} as $entry) {
    if ($fid == $entry->{'BotId'})
        echo " <div class=\"answer left\"><div class=\"avatar\"><img src=\"data/avatars/".$fid.".jpg\"> <div class=\"status offline\"></div></div><div class=\"name\" style='color:white;'>" . $entry->{'Name'} . "</div><div class=\"text\"> " . $entry->{'Message'} . "</div>                <div class=\"time\" style='color:white;'> </div>              </div>";
    else  echo " <div class=\"answer right\"><div class=\"avatar\"><img src=\"data/avatars/".$sid.".jpg\"> <div class=\"status offline\" ></div></div><div class=\"name\" style='color:white;'>" . $entry->{'Name'} . "</div><div class=\"text\">" . $entry->{'Message'} . "</div>                <div class=\"time\" style='color:white;'> </div>              </div>";
}

?>
