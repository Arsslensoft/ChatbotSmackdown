<?php
include "header.php";
$uid = 0;
if(!isset($_GET["id"]))
{
    header("Location: profile.php?id=".$CBSDUM->current_userid);
    exit;
}
// update user infos
if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["botname"]) && isset($_POST["botdesc"]))
{
$CBSDUM->updateUser($CBSDUM->current_userid,$_POST["username"],$_POST["email"],$_POST["firstname"], $_POST["lastname"],$_POST["botname"], $_POST["botdesc"],$_POST["password"] );
    $update_message= "Your profile was successfully updated";
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    if(!$bpsa->isAvailable())
    {
        header("Location: error.php?error=Platform offline&message=The Arsslensoft Bot platform seems to be offline");
        exit;
    }
    $bpsa->synchronize();
}

if(isset($_GET["id"]))
    $uid = intval($_GET["id"]);
else
    $uid = intval($CBSDUM->current_userid);

if($uid == 0)
{
    header("Location: login.php");
    exit;
}
$user = $CBSDUM->getUser($uid);

function getRoleString($role)
{
    if($role == 0)
        return "User";
    else return "Administrator";
}
$bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
if(!$bpsa->isAvailable())
{
    header("Location: error.php?error=Platform offline&message=The Arsslensoft Bot platform seems to be offline");
    exit;
}
    $bot_available = 0;
    if(!isset( $_SESSION['CBSDUserManagement']))
        $_SESSION['CBSDUserManagement']['user'] = "Unknown";

    $bot_answer = "";

    $username = $_SESSION['CBSDUserManagement']['user'];
    $id = "";
    $botname="";



    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];

        $bot_info = $bpsa->getBotInfo($id);
        if($bot_info != null)
        {
            $bot_available=1;
            $botname = $bot_info->name;

        }
        else         $botname = "Unknown";



    }


    if(isset($_GET["message"]))
    {
        $id = $_GET["id"];
        $msg = $_GET["message"];

        $resp = $bpsa->talkWithBot($id, $username,$msg);

        if($resp == null)
            die("Bot is unavailable");
        else die($resp->message);


    }


if(isset($_POST["botstate"]))
{
    $bot_state = false;
    $bot_available=0;
    if($_POST["botstate"] == "ON") {
        $bot_state = true;
        $bot_available=1;
    }


    // die("$uid   $bot_state");
    $CBSDUM->setBotState($uid, $bot_state);
    $bpsa->reloadBot($uid);
    $user = $CBSDUM->getUser($uid);
}

if(isset($_POST["reset"])) {
    $bpsa->reloadBot($uid);
}
$ccm = new CBSDCompetitionManagement;

$competitions = $ccm->getAllCompetitions();
function parseStatut($statut) {
    if($statut == 0) {return "Ready";}
    if($statut == 1) {return "Started " ;}
    if($statut == 2) {return "Completed"; }

}

?>
<!-- Main Page -->

<div id="content" role="main">
    <section class="section swatch-black-beige" id="website_main_name">
        <div class="background-media skrollable skrollable-between" style="background-image: url(cbsm/background.jpg); background-size: cover; background-position: 50% 0px;" data-start="background-position: 50% 0px" data-top-bottom="background-position: 50% -200px">
        </div>
        <!--Background Overlay-->
        <div class="background-overlay" style="background-color:rgba(0, 0, 0, 0.2)">
        </div>
        <div class="container">
            <header class="section-header underline">
                <br />



                <h1 style="font-family:'Agency FB'" class="headline hyper hairline" style="color : rgba(255, 255, 255, 0.7)">ChatBot SmackDown</h1>
            </header>
        </div>

    </section>
    <section class="section swatch-black-beige">
        <div class="decor-top">
            <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
            </svg>
        </div>
        <div class="col-lg-12">
            <h3 class=" super"><i class="fa fa-user-md"></i> Profile</h3>

        </div>

        <div class="row">
            <!-- profile-widget -->
            <div class="col-lg-12">
                <div class="profile-widget well swatch-black-beige">
                    <div class="panel-body">

                        <div class="col-lg-3 col-sm-3">
                            <div class="follow-ava " >

                                <img src=" <?php              if(file_exists("data/avatars/$uid.jpg"))       echo "data/avatars/$uid.jpg"; else echo "images/chat/avatar1.png" ?>" alt="Profile picture" >
                                <?php
                                if($user->BotActive == true) {
                                    if($bot_available == 1)
                                        echo "<div style=\" border: 1px solid #5a5a5a;    background: #4caf50;     width: 10px;    height: 10px;    border-radius: 5px;    position: absolute;    bottom: 10px;\"></div>";
                                    else   echo "<div style=\" border: 1px solid #5a5a5a;    background: #ffc107;     width: 10px;    height: 10px;    border-radius: 5px;    position: absolute;    bottom: 10px;\"></div>";


                                }
else echo "                                <div style=\" border: 1px solid #5a5a5a;    background: #ed4e6e;     width: 10px;    height: 10px;    border-radius: 5px;    position: absolute;    bottom: 10px;\"></div>";

                                ?>
                            </div>


                        </div>
                        <!-- this will create a blank space -->
                        <div class="col-lg-1 col-sm-3"> </div>


                        <!-- start button panel -->
                        <?php

                        if($uid == $CBSDUM->current_userid) {

                            if($user->BotActive == false)
                                echo "<form method='post' action='profile.php?id=".$CBSDUM->current_userid."''> <input  class=\"btn btn-success col-lg-2 col-sm-2\" type=\"submit\" name=\"botstate\" id=\"botstate\" value=\"ON\" ></form>";
                            else   echo "<form method='post' action='profile.php?id=".$CBSDUM->current_userid."''> <input  class=\"btn btn-danger col-lg-2 col-sm-2\" type=\"submit\" name=\"botstate\" id=\"botstate\" value=\"OFF\" ></form>";

                        }
                        ?>

                        <?php
                        if($uid == $CBSDUM->current_userid)
                                echo "<form method='post' action='profile.php?id=".$CBSDUM->current_userid."''><input name=\"reset\" id=\"reset\" value=\"OK\"  type=\"hidden\"> <input class=\"btn btn-danger col-lg-2 col-sm-2\" type=\"submit\" value=\"Reset\" /> </form>";
                        ?>


                    </div>
                    <!-- page start-->
                    <div class="col-lg-12">
                        <header class=" tab-bg-info ">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a data-toggle="tab" href="#profile">
                                        Profile
                                    </a>
                                </li>
                                <li >
                                    <a data-toggle="tab" href="#chat-bot">

                                        Chat With me
                                    </a>
                                </li>
                                <?php
                                if($uid == $CBSDUM->current_userid)
                                    echo "   <li > <a data-toggle=\"tab\" href=\"#improve-bot\">Improve Chat Bot    </a>            </li><li ><a data-toggle=\"tab\" href=\"#edit-profile\">Edit Profile</a>   </li>" ;

                                ?>
                                <li >
                                    <a data-toggle="tab" href="#games">

                                        Participations
                                    </a>
                                </li>
                            </ul>
                        </header>
                        <div class="well swatch-black-beige">
                            <div class="tab-content">
                                <!-- profile -->
                                <div id="profile" class="tab-pane active">

                                    <div class="well swatch-black-beige">
                                        <p> <?php  echo $user->BotDescription; ?></p>
                                    </div>
                                    <div class="panel-body bio-graph-info">
                                        <h1>General informations</h1>
                                        <div class="row">
                                            <div class="bio-row">
                                                <p><span>First Name </span>: <?php  echo $user->FirstName; ?> </p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Last Name </span>: <?php  echo $user->LastName; ?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Bot Name</span>: <?php  echo $user->BotName; ?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Bot Score </span>: <?php  echo $user->BotScore; ?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Role </span>: <?php  echo getRoleString($user->Role); ?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Email </span>: <?php  echo $user->Email; ?></p>
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <!-- edit-profile -->
                                <div id="edit-profile" class="tab-pane">

                                    <div class="panel-body bio-graph-info">
                                        <h1> Profile Info</h1>
                                        <?php if( isset($update_message) ): ?>
                                            <p style="color: green">
                                                <?php echo $update_message; ?>
                                            </p>
                                        <?php endif; ?>
                                        <form action="data/upload_avatar.php" method="post"  enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Avatar</label>
                                                <div >
                                                    <input type="hidden" name="id" value="<?php echo $uid; ?>" >
                                                    <input type="file" name="avatar" accept="image/jpg" id="avatar">

                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                        <form class="form-horizontal" role="form" method="post" action="profile.php">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">First Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder=" " value="<?php echo $user->FirstName; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Last Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control"  id="lastname" name="lastname" placeholder=" " value="<?php echo $user->LastName; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Username</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder=" " value="<?php echo $user->Username; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder=" " value="<?php echo $user->Email; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Bot Description</label>
                                                <div class="col-lg-10">
                                                    <textarea name="botdesc" id="botdesc" class="form-control" cols="30" rows="5" ><?php echo $user->BotDescription; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Bot Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="botname" name="botname" placeholder=" " value="<?php echo $user->BotName; ?>">
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <!-- games -->
                                <div id="games" class="tab-pane">

                                    <div class="panel-body bio-graph-info">

                                        <h1> Chat with me</h1>

                                    </div>

                                    <div class="row-fluid">
                                        <div class="span12">

                                            <table class="table table-hover ">
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




                                                <?php foreach ($competitions as $Competition) {
                                                    $parti = $ccm->getAllParticipations($Competition->Id);
                                                    foreach ($parti as $part ) {
                                                        if($part->BotId == $uid){

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
                                                                <td>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <?php $tmp = $Competition->Id  ?>
                                                                        <form action="onecompetition.php?id=<?php echo $tmp ?>" method="post" > <input  class="btn btn-success col-lg-8 " type="submit" value=" visit competition page" />


                                                                        </form>

                                                                    </div>

                                                                </td></tr>
                                                        <?php  }} }    ?>




                                                </tbody>
                                            </table>

                                        </div>
                                    </div></div>
                                <!-- chat-with -Bot -->
                                <div id="chat-bot" class="tab-pane">

                                    <div class="panel-body" >

                                        <div class="row">
                                            <div class="col-lg-12">
                                        <div class="chat" style="overflow-x: hidden; overflow-y: scroll;  outline: none;" tabindex="5001"  id="chatholder">

                                            <div class="chat-body" id="chatbox" >
                                                <h6>Chat with <?php echo $botname; ?></h6>
                                                <div class="answer-add" id="sendbox">
                                                    <input placeholder="Write a message" id="messagebox"  onkeydown = "if (event.keyCode == 13) sendMessage(<?php echo $id; ?>, '<?php echo $botname; ?>', '<?php echo $username; ?>')"  >
                                                    <span class="answer-btn answer-btn-2" onclick="sendMessage(<?php echo $id; ?>, '<?php echo $botname; ?>', '<?php echo $username; ?>')"></span>
                                                </div>
                                            </div>

                                            </div>
                                        </div>


                                             </div>
                                        </div>
                                    
                               


                                </div>
                                <!-- chat-with -Bot -->
                                <div id="improve-bot" class="tab-pane">

                                    <div class="panel-body bio-graph-info">
                                        <h1> Chat with me</h1>

                                    </div>
                                    <div class="panel-body bio-graph-info">
                                        <form action="upload_settings.php"  enctype="multipart/form-data"  method="post">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Settings files</label>
                                                <div >
                                                    <input type="hidden" name="id" id="id" value="<?= $uid;?>" >
                                                    <input type="file" name="setting" id="settings" >
                                                    <input class="btn-default"  type="submit" value="Upload">
                                                </div>
                                            </div>



                                    </div>
                                    </form>
                                            <form action="upload_aiml.php"  enctype="multipart/form-data"  method="post">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Aiml's files</label>
                                                <div >
                                                    <input type="hidden" name="id" id="id" value="<?= $uid;?>" >
                                                    <input type="file" name="aiml" id="aiml" >
                                                    <input class="btn-default"  type="submit" value="Upload">
                                                </div>
                                            </div>



                                            </div>

                                        </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page end-->
    </section>
</div>
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

<a class="go-top hex-alt" href="javascript:void(0)">
    <i class="fa fa-angle-up"></i>
</a>
<script src="assets/js/packages.min.js"></script>
<script src="assets/js/theme.min.js"></script>
</body>
</html>
