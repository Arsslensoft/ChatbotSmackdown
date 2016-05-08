<?php

	/**
	* Make sure you started your'e sessions!
	* You need to include su.inc.php to make CBSDUserManagement Work
	* After that, create an instance of CBSDUserManagement and your'e all set!
	*/

	session_start();
	require_once(dirname(__FILE__)."/classes/su.inc.php");

	$CBSDUM = new CBSDUserManagement();

	// This simply logs out the current user
	$CBSDUM->logoutUser();
	header("Location: index.php");

?>