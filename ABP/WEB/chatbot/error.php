<?php
include "header.php";
$error_title="";
$error_message="";
if(isset($_GET["error"])) {
    $error_title = $_GET["error"];
    $error_message = $_GET["message"];
}else{
    header("Location: index.php");
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
        <div class="container">
            <header class="section-header no-underline">
                <h1 class="headline hyper hairline"><?php echo $error_title; ?></h1>
            </header>
            <div class="text-center">
                <img src="assets/images/404.png">
            </div>
        </div>

    </section>


    <!-- login Section -->
    <section class="section swatch-beige-black has-top" id="login">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 100 L50 0 L100 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="container">
            <header class="section-header underline text-center">
                <h1 class="headline super hairline">Informations</h1>
                <p class=""><?php echo $error_message; ?></p>
            </header>
            <div class="text-center">
                <a class="btn btn-primary btn-lg btn-icon-right pull-center" href="index.php">
                    take me home
                    <div class="hex-alt hex-alt-big">
                        <i class="fa fa-home" data-animation="tada"></i>
                    </div>
                </a>
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

