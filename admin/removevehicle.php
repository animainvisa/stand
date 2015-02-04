<?php

	session_start();

/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	mysql_query("DELETE FROM vehicles WHERE id_vehicle={$_GET["id"]}") 
	&& mysql_affected_rows() 
	or exit(mysql_error());

/*******************************************************************************************************************/
	
	js_data_updater();
	
	header("Location: index.php");

?>
