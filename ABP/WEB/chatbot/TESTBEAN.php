<?php
require "/classes/su.inc.php";
DataMappingManager::initializeMapper();
$user =User::retrieveByPK(1);
var_dump($user);
?>