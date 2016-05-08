<?php

	/**
	* Make sure you started your'e sessions!
	* You need to include su.inc.php to make CBSDUserManagement Work
	* After that, create an instance of CBSDUserManagement and your'e all set!
	*/

	session_start();
	require_once(dirname(__FILE__)."/classes/su.inc.php");

	$CBSDUM = new CBSDUserManagement();

	// This is a simple way of validating if a user is logged in or not.
	// If the user is logged in, the value is (bool)true - otherwise (bool)false.
	if( !$CBSDUM->logged_in )
	{
		header("Location: login.php");
		exit;
	}

	// If the user is logged in, we can safely proceed.
	$userId = $_GET["userId"];

	//Delete the user (plain and simple)
	$CBSDUM->deleteUser($userId);
	header("Location: users.php");

?>