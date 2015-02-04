<?php

	session_start();

/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_POST["id"])) { exit; }
	
/*******************************************************************************************************************/

	$valid_id = 0;
	
	if (ctype_digit($_POST["id"]))
	{
		require_once("setstartup.inc.php");
	
		$result = mysql_query("SELECT * FROM vehicles WHERE id_vehicle={$_POST["id"]}") or exit(mysql_error());
		
		mysql_num_rows($result) && ($valid_id = 1);
	}
	else { !strlen($_POST["id"]) && ($valid_id = 1); }
	
	if ($valid_id)
	{
		$fp = @fopen("highlight", "w") or exit(1);
		fwrite($fp, $_POST["id"]);
		fclose($fp);
	}
	
	header("Location: index.php");

?>
