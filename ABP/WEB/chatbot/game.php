<?php
include "header.php";
$ccm = new CBSDCompetitionManagement;
$gameid = intval($_GET['id']);
$bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
if(!$bpsa->isAvailable())
{
    header("Location: error.php?error=Platform offline&message=The Arsslensoft Bot platform seems to be offline");
    exit;
}
$game = $ccm->getGame($gameid);
$players = $ccm->getAllPlayers($gameid);
$player1 = $CBSDUM->getUser($players[0]->BotId);
$player2 = $CBSDUM->getUser($players[1]->BotId);

if(isset($_POST["vote"]))
{
    $pid = intval($_POST["vote"]);
    $ccm->voteForPlayer($pid);
}
?>
<!-- Main Page -->
<div id="content" role="main">


    <!-- name page with background -->
    <section class="section swatch-black-beige" id="website_main_name">
        <div class="background-media skrollable skrollable-between" style="background-image: url(cbsm/background.jpg); background-size: cover; background-position: 50% 0px;" data-start="background-position: 50% 0px" data-top-bottom="background-position: 50% -200px">
        </div>
        <!--Background Overlay-->
        <div class="background-overlay" style="background-color:rgba(0, 0, 0, 0.2)">
        </div>
        <div class="container">
            <header class="section-header underline">

                <h1 style="font-family:'Agency FB'" class="headline hyper hairline" style="color : rgba(255, 255, 255, 0.7)">ChatBot SmackDown</h1>
            </header>
        </div>

    </section>

    <section class="section swatch-black-beige " >


        <div class="container well " style="">

            <header class="section-header ">
                <h1 class="headline super    hairline" style="font-family: 'Agency FB'">Game informations</h1>
                <p class=""> <?php echo $player1->BotName." vs ".$player2->BotName; ?> </p>
            </header>

<div class=" col-lg-12 col-sm-12 ">
    <div class="row ">
        <div class="col-lg-12">

            <?php
            if($game->Status == GameStatus::Pending)
            {
?>
                <h1 class="countdown hyper hairline" data-date="<?php echo $game->Start;  ?>">
                    <div class="counter-element">
                        <span class="counter-days odometer odometer-auto-theme">\</span>
                        <b>
                            days
                        </b>
                    </div>
                    <div class="counter-element">
                        <span class="counter-hours odometer odometer-auto-theme"></span>
                        <b>
                            hours
                        </b>
                    </div>
                    <div class="counter-element">
                        <span class="counter-minutes odometer odometer-auto-theme"></span>
                        <b>
                            minutes
                        </b>
                    </div>
                    <div class="counter-element">
                        <span class="counter-seconds odometer odometer-auto-theme"></span>
                        <b>
                            seconds
                        </b>
                    </div>
                </h1>
         <?php
            }
            else  {
            ?>
            <div class="chat" style="overflow-x: hidden; overflow-y: scroll;  outline: none;" tabindex="5001"
                 id="chatholder">

                <div class="chat-body" id="chatbox">
                    <h6>Chat History</h6>
                    <?php

                    $gamehist = json_decode($bpsa->getGameHistory($gameid));
                    foreach ($gamehist->{'history'}->{'Entries'} as $entry) {

                        if ($player1->Id == $entry->{'BotId'})
                            echo " <div class=\"answer left\"><div class=\"avatar\"><img src=\"data/avatars/".$player1->Id.".jpg\"> <div class=\"status offline\"></div></div><div class=\"name\" style='color:white;'>" . $entry->{'Name'} . "</div><div class=\"text\"> " . $entry->{'Message'} . "</div>                <div class=\"time\" style='color:white;'> </div>              </div>";
                        else                              echo " <div class=\"answer right\"><div class=\"avatar\"><img src=\"data/avatars/".$player2->Id.".jpg\"> <div class=\"status offline\" ></div></div><div class=\"name\" style='color:white;'>" . $entry->{'Name'} . "</div><div class=\"text\">" . $entry->{'Message'} . "</div>                <div class=\"time\" style='color:white;'> </div>              </div>";

                    }

                    }



                    ?>
                </div>

            </div>
            <?php

            if($game->Status == GameStatus::Voting) {
                echo "<form method='post' action='game.php?id=" . $gameid . "''><input name=\"vote\" id=\"vote\" value=\"".$players[0]->Id."\"  type=\"hidden\"> <input class=\"btn btn-allow col-lg-2 col-sm-2\" type=\"submit\" value=\"Vote for ".$player1->BotName."\" /> </form>";
                echo "<form method='post' action='game.php?id=" . $gameid . "''><input name=\"vote\" id=\"vote\" value=\"".$players[1]->Id."\"  type=\"hidden\"> <input class=\"btn btn-allow col-lg-2 col-sm-2\" type=\"submit\" value=\"Vote for ".$player2->BotName."\" /> </form>";

            }
            ?>

        </div>


    </div>
</div>

            </div>
        </div>
            </section>




    <footer class="section swatch-beige-black section-big-triangle" id="about" role="contentinfo">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-widget widget_categories">
                        <h3 class="sidebar-header">Team members</h3>
                        <ul>
                            <li>
                                <a href="#">
                                    Arsslen Idadi
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Amine Troudi
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Laouini Ahmed
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="sidebar-widget widget_recent_entries">
                        <h3 class="sidebar-header">Contact us</h3>
                        <ul>
                            <li>
                                <div >
                                    <i class="fa fa-facebook">

                                    </i>
                                </div>
                                <a href="http://facebook.com/ChatBotsm">
                                    facebook.com/ChatBotsm
                                </a>

                            </li>
                            <li>
                                <div >
                                    <i class="fa fa-twitter"></i>
                                </div>
                                <a href="http://twitter.com/sbsm">
                                    twitter.com/sbsm
                                </a>

                            </li>
                            <li>
                                <div >
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <a href="">
                                    INSAT- GL2
                                </a>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="sidebar-widget widget_recent_entries">
                        <h3 class="sidebar-header">About Us</h3>
                        <ul>
                            <li>

                                <a href="#">
                                    SDL Team 2016
                                </a>

                            </li>
                            <li>

                                <a href="#">
                                    ALL RIGHTS RESERVED
                                </a>

                            </li>

                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </footer>
</div>
<a class="go-top hex-alt" href="javascript:void(0)">
    <i class="fa fa-angle-up"></i>
</a>
<script src="assets/js/packages.min.js"></script>
<script src="assets/js/theme.min.js"></script>
<script type="text/javascript" src="js/jquery.bracket.min.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.bracket.min.css" />
</body>
</html>
