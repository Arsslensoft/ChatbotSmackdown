<?php

include "header.php";
$ccm = new CBSDCompetitionManagement;
$canjoin = false;
if($CBSDUM->logged_in )
{
    $cuuser = $CBSDUM->getUser($CBSDUM->current_userid);
    $cid = intval($_POST["join"]);
    $parts = $ccm->getParticipations($cid, $cuuser->Id);
    if(count($parts) == 0)
        $canjoin=true;
    

if(isset($_POST["join"]))
{

}
}

if(isset($_POST["ppw"]))
{
    $name = $_POST["name"];
    $pn = intval($_POST["pn"]);
    $ppw = intval($_POST["ppw"]);
    $prize =intval($_POST["prize"]);
    $desc = $_POST["desc"];
    $start = $_POST["start"];
    $ccm->createCompetition($start, $name,$desc,$ppw,$prize,$pn);

}

$competitions = $ccm->getAllCompetitions();

function parseStatut($statut) {
   if($statut == 0) {return "ready";}
    if($statut == 1) {return "started " ;}
    if($statut == 2) {return "completed"; }

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


    <!-- Service Section -->
    <section class="section swatch-beige-black top" id="services">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="container">

            <header class="section-header ">
                <h1 class="headline super hairline">Competitions</h1>
            </header>
            <div class="row-fluid">

                <?php
if($CBSDUM->logged_in ){
    $cuuser = $CBSDUM->getUser($CBSDUM->current_userid);
    if($cuuser->Role == UserRole::Administrator){
                ?>
                <div class="span12">
                    <form id="addcompet" method="post" action="competitions.php">
                        <div class="form-group form-icon-group">
                            <input class="form-control" id="name" name="name" placeholder="Competition name" type="text" required="">
                        </div>
                        <div class="form-group form-icon-group">
                            <input class="form-control" id="ppw" name="ppw" placeholder="Points per win" type="number" required="">
                        </div>
                        <div class="form-group form-icon-group">
                            <input class="form-control" id="pn" name="pn" placeholder="Participants numbers" type="number" required="">
                        </div>
                        <div class="form-group form-icon-group">
                            <input class="form-control" id="start" name="start" placeholder="Start date" type="date" required="">
                        </div>
                        <div class="form-group form-icon-group">
                            <input class="form-control" id="prize" name="prize" placeholder="Prize" type="number" required="">
                        </div>
                        <div class="form-group form-icon-group">
                            <textarea class="form-control" id="desc" name="desc" placeholder="Description" rows="10" required=""></textarea>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-icon btn-icon-right" type="submit">                                Add competition                          </button>
                        </div>
                    </form>
               </div>
                <?php }} ?>
                <div class="span12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Competition name</th>
                            <th>start Date</th>
                            <th>statut</th>
                            <th>winner Bot name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php
foreach ($competitions as $Competition) {
                            ?>
                            <tr>
                            <td><?php echo $Competition->Id ?></td>
                            <td><?php echo $Competition->Name ?></td>
                            <td><?php echo $Competition->Start ?></td>
                            <td><?php echo parseStatut($Competition->Status) ?></td>
                            <td> <?php $rankingc = $ccm->getAllRankings($Competition->Id) ;
                                foreach($rankingc as $rank){
                                    if($rank->Rank == 1 ){
                                      $botn = $ccm->getBot($rank->BotId)  ;
                                echo $botn->BotName ;}
                                }

                                ?> </td>
                            <td><div class="col-lg-12 col-sm-12">
                                    <?php $tmp = $Competition->Id  ?>
                                    <form action="onecompetition.php?id=<?php echo $tmp ?>" method="post" > <input  class="btn btn-success col-lg-8 " type="submit" value=" visit competition page" />


                                    </form>
                                    <div>
                                        <form action ="join.php">
                                            <input class="btn btn-danger col-lg-3 " type="submit" value="Join" />


                                        </form></div>
                                </div>

                            </td>
                            </tr>
                            <?php }      ?>




                        </tbody>
                    </table>
                </div>
            </div>
    </section>




    <footer class="section swatch-black-beige section-big-triangle" id="about" role="contentinfo">
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

