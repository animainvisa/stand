<?php

	session_start();

/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_GET["setpid"]) || !ctype_digit($_GET["setpid"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	($result = mysql_query("SELECT id_vehicle FROM images WHERE id_image={$_GET["setpid"]}")) 
	&& mysql_num_rows($result) 
	or exit(mysql_error());
	
/*******************************************************************************************************************/
	
	mysql_query("UPDATE images SET primary_image=" .time(). " WHERE id_image={$_GET["setpid"]}") or exit(mysql_error());
	
	header("Location: editvehicle.php?id=" . mysql_result($result, 0));

?>
