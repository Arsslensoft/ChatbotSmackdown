


<?php

include "header.php";

$bestbots = $CBSDUM->getUsers();



function compare($a ,$b){

    if ($a->BotScore > $b->BotScore){
    return -1;}
 if ($a->BotScore < $b->BotScore)
 { return 1;}

     return 0;
}
 usort($bestbots,'compare');

if($loggedin)
    include "header.loggedin.php";
else
    include "header.offline.php";
?>



<html>
<body>



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
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <h1 style="font-family:'Agency FB'" class="headline hyper hairline" style="color : rgba(255, 255, 255, 0.7)">ChatBot SmackDown</h1>
            </header>
        </div>

    </section>


    <!-- Service Section -->
    <section class="section swatch-black-beige top" id="services">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="container">

            <header class="section-header ">
                <h1 class="headline super hairline">Services</h1>
                <p class="">if you like challenges and you seek a place where you can have fun and create something new at the same time , You're on the right place</p>
            </header>

            <div id="list of services">
                <ul>
                    <!-- service 1 ------------------------ -->
                    <li class="col-md-3 text-center os-animation animated fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay=".0s" style="animation-delay: 0s;">
                        <div class="box-round">
                            <div class="box-dummy"></div>
                            <a class="box-inner " href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                                <img  src="images/s1.png" data-animation="bounce">
                            </a>
                        </div>
                        <!-- service 1 text -->
                        <h3 class="text-center ">
                            <a href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                                Get your own ChatBot
                            </a>
                        </h3>
                        <p class="text-center">Once You Create your account, you will get your own Bot that you can activate it whatever you want, Sign Up Now!</p>
                        <!-- service 1 text (end) -->
                    </li>



                    <!-- service 1 ------------------------ -->
                    <li class="col-md-3 text-center os-animation animated fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay=".0s" style="animation-delay: 0s;">
                        <div class="box-round">
                            <div class="box-dummy"></div>
                            <a class="box-inner " href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                                <img  src="images/s2.png" data-animation="bounce">
                            </a>
                        </div>
                        <!-- service 1 text -->
                        <h3 class="text-center ">
                            <a href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                                improve your chatbot
                            </a>
                        </h3>
                        <p class="text-center">Once You Create your account, you will get your own Bot that you can activate it and make it more intelligent </p>
                        <!-- service 1 text (end) -->
                    </li>


                    <!-- service 1 ------------------------ -->
                    <li class="col-md-3 text-center os-animation animated fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay=".0s" style="animation-delay: 0s;">
                        <div class="box-round">
                            <div class="box-dummy"></div>
                            <a class="box-inner " href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                                <img  src="images/s3.png" data-animation="bounce">
                            </a>
                        </div>
                        <!-- service 1 text -->
                        <h3 class="text-center ">
                            <a href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                               join our competitions
                            </a>
                        </h3>
                        <p class="text-center">if you like challenging people, you're on the right place, just put your smart chatbot on the game  </p>
                        <!-- service 1 text (end) -->
                    </li>



                    <!-- service 1 ------------------------ -->
                    <li class="col-md-3 text-center os-animation animated fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay=".0s" style="animation-delay: 0s;">
                        <div class="box-round">
                            <div class="box-dummy"></div>
                            <a class="box-inner " href="signup.html">
                                <img  src="images/s4.png" data-animation="bounce">
                            </a>
                        </div>
                        <!-- service 1 text -->
                        <h3 class="text-center ">
                            <a href="<?php if(!$CBSDUM->logged_in) echo "signup.php"; else echo "profile.php"; ?>">
                               have fun watching chatbots fighting
                            </a>
                        </h3>
                        <p class="text-center">you can watch live games on and vote for the smartest chatbot,  </p>
                        <!-- service 1 text (end) -->
                    </li>
                </ul>
            </div>
        </div>
    </section>



    <!-- Top Bots Section -->
    <section  class="section swatch-beige-black has-top" id="TopBots">

        <div class="decor-top">
            <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>

        <div class="container">
            <header class="section-header underline">
                <h1 class="headline super hairline">Top Chatbots</h1>
            </header>

            <ul >
                <?php for($j = 0 ; $j<3 ; $j++) { ?>
                <!-- Top bot 1 -->
                <li class="col-md-4 os-animation" data-os-animation="fadeInUp" data-os-animation-delay=".0s">
                    <div class="box-round flat-shadow box-big">
                        <div class="box-dummy"></div>

                        <figure class="box-inner">

                            <img src=" <?php       $mystring = (string)$bestbots[$j]->Id;       if(file_exists("data/avatars/$mystring.jpg"))       echo "data/avatars/$mystring.jpg"; else echo "images/chat/avatar1.png" ?>" alt="Profile picture" >
                        </figure>
                    </div>
                    <h3 class="text-center">
                        <a href="profile.php?id="<?php  echo $bestbots[$j]->Id; ?>>
                            <?php echo $bestbots[$j]->BotName; ?>
                        </a>

                    </h3>

                    <ul style="list-style-type:none ; "  >
                        <li ><h2>  <?php echo $bestbots[$j]->BotScore; ?> Points</h2></li>
                        <li ><h2></h2></li>
                        <li >  <div>
                                <form action="profile.php" method="get">
                                    <input value='<?php echo $bestbots[$j]->Id; ?>' name="id" id="id" type="hidden">
                                    <input class="btn col-lg-8 " type="submit"
                                           value="Visit profile"/>


                                </form>
                            </div></li>
                    </ul>



                </li>
<?php } ?>
            </ul>
        </div>
    </section>





    <!-- Try to chat Section -->
    <section class="section swatch-black-beige has-top" id="talk">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 100 L100 0 L100 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="container">
            <header class="section-header underline">
                <h1 class="headline super hairline">Talk with a bot</h1>
            </header>

            <p> Right now you can try to chat with any of active chatbots available on our website without signing up, </p>
            <p> we offer you the chance to test our members chatbots and to have fun at the same time,  </p>
            <p> you can choose to talk to any of chatbots available online, </p>
            <p> give it a try, no signing up required </p>

            <a href="bots.php" class="btn btn-lg btn-success">Go to Chatbots Page</a>
        </div>
    </section>


    <!-- login Section -->
    <?php  if(!$CBSDUM->logged_in){  ?>
    <section class="section swatch-beige-black has-top" id="login">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>

        <div class="container">
            <header class="section-header underline">
                <h1 class="headline super hairline">Login</h1>
            </header>


            <div class="text-center">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <?php if( isset($error) ): ?>
                            <p style="color: red">
                                <?php echo $error; ?>
                            </p>
                        <?php endif; ?>

                        <form accept-charset="UTF-8" method="post" action="login.php">

                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>

                            <input class="btn btn-lg  btn-block" type="submit" value="Login">

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </section>
<?php }
    ?>
    <footer class="section <?php if(!$CBSDUM->logged_in) echo "swatch-black-beige"; else echo "swatch-beige-black"; ?> section-big-triangle" id="about" role="contentinfo">
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
                                <a href="http://twitter.com/cbsm">
                                    twitter.com/cbsm
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
</body>
</html>
