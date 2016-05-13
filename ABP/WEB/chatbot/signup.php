<?php
include "header.php";

$username=""; $email=""; $firstname="";$lastname="";$botname="";$password="";
if($CBSDUM->logged_in) {
    header("Location: profile.php?id=" . $CBSDUM->current_userid);
    exit;
}
if(isset($_POST["email"])) {
    $firstname = trim($_POST['first_name']);
    $username = trim($_POST['Username']);
    $lastname = trim($_POST['last_name']);
    $botname = trim($_POST['Botname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $userid=$CBSDUM->createUser($username, $email, $firstname, $lastname, $botname, $password);
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    if(!$bpsa->isAvailable())
    {
        header("Location: error.php?error=Platform offline&message=The Arsslensoft Bot platform seems to be offline");
        exit;
    }
    $resp = $bpsa->addBot($userid);


    if($resp == null)
        die("Error ");
    header("Location: login.php");
    exit;

}


if($loggedin)
    include "header.loggedin.php";
else
    include "header.offline.php";
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


    <section class="section swatch-beige-black top" id="services">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>

        <div class="container">
            <header class="section-header ">
                <h1 class="headline super hairline">Sign Up</h1>

            </header>
            <div class="row centered-form">
                <div>
                    <div >
                        <div class="panel-body">
                            <form role="form" action="signup.php" method="post">
                                <div class="form-group">
                                    <input type="text" name="Username" id="Username" class="form-control input-sm" placeholder="UserName" required>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="Botname" id="Botname" class="form-control input-sm" placeholder="ChatBot Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address" required>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-21 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" required>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" value="Register" class="btn btn-lg  btn-block ">

                            </form>
                        </div>
                    </div>
                </div>
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
