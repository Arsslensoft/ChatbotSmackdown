<?php
/**
 * Created by PhpStorm.
 * User: Arsslen
 * Date: 08/05/2016
 * Time: 09:05
 */
require_once(dirname(__FILE__)."/classes/su.inc.php");
session_start();
if(!isset($_SESSION['user']))
    $_SESSION['user'] = "Unknown";

$bot_answer = "";
$username = $_SESSION['user'];
$id = "";
$botname="";
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    $bot_info = $bpsa->getBotInfo($id);
    if($bot_info == null)
        die("Bot is unavailable");

$botname = $bot_info->name;
}
else die("Bot id must be defined");

if(isset($_GET["message"]))
{
    $id = $_GET["id"];
    $msg = $_GET["message"];
    $bpsa = new SDLBotPlatformServiceAPI("http://localhost:880/","A");
    $resp = $bpsa->talkWithBot($id, $username,$msg);

    if($resp == null)
        die("Bot is unavailable");
    else die($resp->message);


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <!--
    	The codes are free, but we require linking to our web site.
    	Why to Link?
    	A true story: one girl didn't set a link and had no decent date for two years, and another guy set a link and got a top ranking in Google!
    	Where to Put the Link?
    	home, about, credits... or in a good page that you want
    	THANK YOU MY FRIEND!
    -->
    <title>TEST CHAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body{
            margin-top:20px;
            background:#eee;
        }
        .row.row-broken {
            padding-bottom: 0;
        }
        .col-inside-lg {
            padding: 20px;
        }
        .chat {
            height: calc(100vh - 180px);
        }
        .decor-default {
            background-color: #ffffff;
        }
        .chat-users h6 {
            font-size: 20px;
            margin: 0 0 20px;
        }
        .chat-users .user {
            position: relative;
            padding: 0 0 0 50px;
            display: block;
            cursor: pointer;
            margin: 0 0 20px;
        }
        .chat-users .user .avatar {
            top: 0;
            left: 0;
        }
        .chat .avatar {
            width: 40px;
            height: 40px;
            position: absolute;
        }
        .chat .avatar img {
            display: block;
            border-radius: 20px;
            height: 100%;
        }
        .chat .avatar .status.off {
            border: 1px solid #5a5a5a;
            background: #ffffff;
        }
        .chat .avatar .status.online {
            background: #4caf50;
        }
        .chat .avatar .status.busy {
            background: #ffc107;
        }
        .chat .avatar .status.offline {
            background: #ed4e6e;
        }
        .chat-users .user .status {
            bottom: 0;
            left: 28px;
        }
        .chat .avatar .status {
            width: 10px;
            height: 10px;
            border-radius: 5px;
            position: absolute;
        }
        .chat-users .user .name {
            font-size: 14px;
            font-weight: bold;
            line-height: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chat-users .user .mood {
            font: 200 14px/20px "Raleway", sans-serif;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /*****************CHAT BODY *******************/
        .chat-body h6 {
            font-size: 20px;
            margin: 0 0 20px;
        }
        .chat-body .answer.left {
            padding: 0 0 0 58px;
            text-align: left;
            float: left;
        }
        .chat-body .answer {
            position: relative;
            max-width: 600px;
            overflow: hidden;
            clear: both;
        }
        .chat-body .answer.left .avatar {
            left: 0;
        }
        .chat-body .answer .avatar {
            bottom: 36px;
        }
        .chat .avatar {
            width: 40px;
            height: 40px;
            position: absolute;
        }
        .chat .avatar img {
            display: block;
            border-radius: 20px;
            height: 100%;
        }
        .chat-body .answer .name {
            font-size: 14px;
            line-height: 36px;
        }
        .chat-body .answer.left .avatar .status {
            right: 4px;
        }
        .chat-body .answer .avatar .status {
            bottom: 0;
        }
        .chat-body .answer.left .text {
            background: #ebebeb;
            color: #333333;
            border-radius: 8px 8px 8px 0;
        }
        .chat-body .answer .text {
            padding: 12px;
            font-size: 16px;
            line-height: 26px;
            position: relative;
        }
        .chat-body .answer.left .text:before {
            left: -30px;
            border-right-color: #ebebeb;
            border-right-width: 12px;
        }
        .chat-body .answer .text:before {
            content: '';
            display: block;
            position: absolute;
            bottom: 0;
            border: 18px solid transparent;
            border-bottom-width: 0;
        }
        .chat-body .answer.left .time {
            padding-left: 12px;
            color: #333333;
        }
        .chat-body .answer .time {
            font-size: 16px;
            line-height: 36px;
            position: relative;
            padding-bottom: 1px;
        }
        /*RIGHT*/
        .chat-body .answer.right {
            padding: 0 58px 0 0;
            text-align: right;
            float: right;
        }

        .chat-body .answer.right .avatar {
            right: 0;
        }
        .chat-body .answer.right .avatar .status {
            left: 4px;
        }
        .chat-body .answer.right .text {
            background: #7266ba;
            color: #ffffff;
            border-radius: 8px 8px 0 8px;
        }
        .chat-body .answer.right .text:before {
            right: -30px;
            border-left-color: #7266ba;
            border-left-width: 12px;
        }
        .chat-body .answer.right .time {
            padding-right: 12px;
            color: #333333;
        }

        /**************ADD FORM ***************/
        .chat-body .answer-add {
            clear: both;
            position: relative;
            margin: 20px -20px -20px;
            padding: 20px;
            background: #46be8a;
        }
        .chat-body .answer-add input {
            border: none;
            background: none;
            display: block;
            width: 100%;
            font-size: 16px;
            line-height: 20px;
            padding: 0;
            color: #ffffff;
        }
        .chat input {
            -webkit-appearance: none;
            border-radius: 0;
        }
        .chat-body .answer-add .answer-btn-1 {
            background: url("http://91.234.35.26/iwiki-admin/v1.0.0/admin/img/icon-40.png") 50% 50% no-repeat;
            right: 56px;
        }
        .chat-body .answer-add .answer-btn {
            display: block;
            cursor: pointer;
            width: 36px;
            height: 36px;
            position: absolute;
            top: 50%;
            margin-top: -18px;
        }
        .chat-body .answer-add .answer-btn-2 {
            background: url("http://91.234.35.26/iwiki-admin/v1.0.0/admin/img/icon-41.png") 50% 50% no-repeat;
            right: 20px;
        }
        .chat input::-webkit-input-placeholder {
            color: #fff;
        }

        .chat input:-moz-placeholder { /* Firefox 18- */
            color: #fff;
        }

        .chat input::-moz-placeholder {  /* Firefox 19+ */
            color: #fff;
        }

        .chat input:-ms-input-placeholder {
            color: #fff;
        }
        .chat input {
            -webkit-appearance: none;
            border-radius: 0;
        }
    </style>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="content container-fluid bootstrap snippets">
    <div class="row row-broken">
        <div class="col-sm-3 col-xs-12">
            <div class="col-inside-lg decor-default chat" style="overflow: hidden; outline: none;" tabindex="5000">
                <div class="chat-users">
                    <h6>Online</h6>
                    <div class="user">
                        <div class="avatar">
                            <img src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
                            <div class="status off"></div>
                        </div>
                        <div class="name">User name</div>
                        <div class="mood">User mood</div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-9 col-xs-12 chat" style="overflow: hidden; outline: none;" tabindex="5001" id="chatholder">
            <div class="col-inside-lg decor-default">
                <div class="chat-body" id="chatbox">
                    <h6>Chat with <?php echo $botname; ?></h6>
                    <div class="answer-add" id="sendbox">
                        <input placeholder="Write a message" id="messagebox"  onkeydown = "if (event.keyCode == 13) sendMessage()"  >
                            <span class="answer-btn answer-btn-2" onclick="sendMessage()"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-1.12.3.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/moment.js"></script>

<script type="text/javascript">
    $(function(){
        $("#chatholder").niceScroll();
    })
    jQuery(document).ready(function() {
        setInterval('updateMessagesTime()', 1000);
    });
    function updateMessagesTime()
    {
        $("time.time").each(function( ){
            var m = moment($(this).attr('datetime'), "DD/MM/YYYY hh:mm:ss").fromNow();
            $(this).text(m);
        });

    }
    function decodeMessage(encodedString) {
        var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
        var decodedString = Base64.decode(encodedString);
      //  console.log(decodedString);
        return decodedString;
    }
    function encodeMessage(string) {
           var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


        var encodedString = Base64.encode(string);
       // console.log(encodedString);
        return encodedString;

    }
    function sendMessage()
    {
        var now = moment().format('DD/MM/YYYY hh:mm:ss');
        var message = $("input[id='messagebox']").val();
        var el = " <div class=\"answer left\"><div class=\"avatar\"><img src=\"images/chat/avatar1.png\" alt=\"<?php echo $username; ?>\"> <div class=\"status online\"></div> </div><div class=\"name\"><?php echo $username; ?></div> <div class=\"text\"> "+message+"</div>   <time class=\"time\" datetime=\""+now +"\">now</time> </div>";
        $(el).insertBefore("#sendbox");
        $("#chatholder").getNiceScroll().resize();
        $("#chatholder").scrollTop($("#chatholder")[0].scrollHeight);

        $.get("test_chat.php",
            {
                id: <?php echo $id; ?>,
                message: encodeMessage(message)
            },  function(data){
        var rnow = moment().format('DD/MM/YYYY hh:mm:ss');
        var el = " <div class=\"answer right\"><div class=\"avatar\"><img src=\"images/chat/avatar1.png\" alt=\"<?php echo $botname; ?>\"> <div class=\"status online\"></div> </div><div class=\"name\"><?php echo $botname; ?></div> <div class=\"text\"> "+decodeMessage(data)+"</div>   <time class=\"time\" datetime=\""+rnow +"\">now</time> </div>";
        $(el).insertBefore("#sendbox");
        $("#chatholder").getNiceScroll().resize();
                $("#chatholder").scrollTop($("#chatholder")[0].scrollHeight);
    });



    }
</script>
</body>
</html>
