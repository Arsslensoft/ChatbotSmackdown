<?php
/**
 * Created by PhpStorm.
 * User: Arsslen
 * Date: 09/05/2016
 * Time: 10:11
 */
require "/classes/su.inc.php";
DataMappingManager::initializeMapper();
$ccm = new CBSDCompetitionManagement;
$cid = 2;
$cpt = $ccm->getCompetition($cid);

function getRankName($rank)
{
    if($rank == 1)
        return "1st";
    else if($rank == 2)
        return "2nd";
    else if($rank == 3)
        return "3rd";
    else return "4th";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.bracket.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery.bracket.min.css" />

</head>
<body>
<div class="demo">
    <div class="jQBracket lr" style="height: 168px; width: 320px;">


        <div class="bracket" style="height: 128px;">

            <?php
            $teamid = 0;

                $rounds = $ccm->getAllRounds($cid);

                foreach($rounds as $key)
                {
                    $gpair = 0;
                    $games =  $ccm->getAllGames($key->Id);

                    // finals
                    if(count($games) == 1)
                    {

                        echo "    <div class=\"finals\">";
                        echo "<div class=\"round\">";

                        foreach ($games as $game) {

                            echo "    <div class=\"match\" style=\"height: 64px;\">";
                            echo "    <div class=\"teamContainer\" style=\"position: absolute; bottom: -22.5px;\">";
                            $players = $ccm->getAllPlayers($game->Id);
                            foreach ($players as $player) {
                                $teamid = $player->BotId;
                                $rank = $ccm->getRanking($cid,$player->BotId);
                                if ($game->Status != GameStatus::Completed) {

                                    echo " <div class=\"team\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";
                                    $bot = $ccm->getBot($player->BotId);
                                    echo "    <div class=\"label editable\">" . $bot->BotName . "</div>";
                                    echo "<div class=\"score editable\" data-resultid=\"result-0\">" . $player->Score . "</div>";
                                    echo "  </div>";
                                } else {
                                    if ($player->BotId == $game->WinnerId)
                                        echo " <div class=\"team win highlightWinner\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";
                                    else echo "   <div class=\"team lose highlightLooser\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";
                                    $bot = $ccm->getBot($player->BotId);
                                    echo "    <div class=\"label editable\">" . $bot->BotName . "</div>";
                                    echo "<div class=\"score editable\" data-resultid=\"result-0\">" . $player->Score . "</div>";
                                    echo "   <div class=\"bubble\">".getRankName($rank[0]->Rank)."</div>";
                                    echo "  </div>";


                                }
                            }
                            echo "  </div>        </div>";

                        }


                        echo "  </div>        </div>";
                    }
                    else {
                        echo "<div class=\"round\">";
                        foreach ($games as $game) {
                            $gpair++;
                            echo "    <div class=\"match\" style=\"height: 64px;\">";
                            echo "    <div class=\"teamContainer\" style=\"top: 9.5px;\">";
                            $players = $ccm->getAllPlayers($game->Id);
                            foreach ($players as $player) {


                                $teamid = $player->BotId;
                                if ($game->Status != GameStatus::Completed) {
                                    echo " <div class=\"team\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";
                                    $bot = $ccm->getBot($player->BotId);
                                    echo "    <div class=\"label editable\">" . $bot->BotName . "</div>";
                                    echo "<div class=\"score editable\" data-resultid=\"result-0\">" . $player->Score . "</div>";
                                    echo "  </div>";
                                } else {
                                    if ($player->BotId == $game->WinnerId)
                                        echo " <div class=\"team win\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";
                                    else echo "   <div class=\"team lose\" data-resultid=\"team-$teamid\" data-teamid=\"$teamid\">";

                                    $bot = $ccm->getBot($player->BotId);
                                    echo "    <div class=\"label editable\">" . $bot->BotName . "</div>";
                                    echo "<div class=\"score editable\" data-resultid=\"result-0\">" . $player->Score . "</div>";
                                    echo "  </div>";
                                }
                            }
                            if($gpair % 2 != 0)
                            echo "        <div class=\"connector\" style=\"height: 32px; width: 20px; right: -22px; top: 11.25px; border-bottom-style: none;\">                            <div class=\"connector\" style=\"width: 20px; right: -20px; bottom: 0px;\"></div>                        </div>";
                            else echo "<div class=\"connector\" style=\"height: 32px; width: 20px; right: -22px; bottom: 11.25px; border-top-style: none;\"><div class=\"connector\" style=\"width: 20px; right: -20px; top: 0px;\"></div></div>";
                            echo "  </div>        </div>";

                        }
                        echo "</div>";
                    }


                }

            ?>





        </div>
    </div>
</div>
</body>
</html>
