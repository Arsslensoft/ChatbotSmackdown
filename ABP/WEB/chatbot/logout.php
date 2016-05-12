<?php
include "header.php";
$CBSDUM->logoutUser();
header("Location: login.php");
exit;
?>