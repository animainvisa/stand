<?php

	session_start();

/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	$_SESSION = array();
	
	if (isset($_COOKIE[session_name()])) { setcookie(session_name(), session_id(), 1, "/"); }
		
	session_destroy();
	
	header("Location: login.php");

?>
