<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>ChatBot SmackDown</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/theme.min.css">
    <link rel="stylesheet" href="assets/css/color-defaults.min.css">
    <link rel="stylesheet" href="assets/css/swatch-beige-black.min.css">
    <link rel="stylesheet" href="assets/css/swatch-black-beige.min.css">
    <link rel="stylesheet" href="assets/css/style.css" media="screen">


    <link href="assets/css/chatbot.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.12.3.min.js" type="text/javascript"></script>
  
    <script src="js/moment.js"></script>
    <script src="js/chatbot.js"></script>
</head>

<body>
<?php
session_start();
require_once(dirname(__FILE__)."/classes/su.inc.php");

$CBSDUM = new CBSDUserManagement();

$loggedin = $CBSDUM->logged_in;
?>