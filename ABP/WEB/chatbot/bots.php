<?php
include "header.php";
$aul = $CBSDUM->getUsers();

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
                        <h1 class="headline super hairline">Chat Bots</h1>
                        <p class="">Under construction</p>
                    </header>
                 <div class="row-fluid">
                        <div class="span12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BotName</th>

                                        <th>score</th>
                                     
                                         <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                            <?php  foreach ($aul as $cuser){
                                if($cuser->BotActive == true) {

                                    ?>


                                    <tr>
                                        <td><?php echo "$cuser->Id" ?></td>
                                        <td><?php echo "$cuser->BotName" ?></td>
                                        <td><?php echo "$cuser->BotScore" ?></td>

                                        <td>
                                            <div class="col-lg-12 col-sm-12">

                                                <div>
                                                    <form action="profile.php" method="get">
                                                       <input value='<?php echo "$cuser->Id"; ?>' name="id" id="id" type="hidden">
                                                        <input class="btn btn-danger col-lg-8 " type="submit"
                                                               value="visit profile"/>


                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php                }} ?>
                                </tbody>
                            </table>
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

    </body>
</html>
