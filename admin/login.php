<?php

	session_start();
	
/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (is_loggedin()) { header("Location: index.php"); exit; }

/*******************************************************************************************************************/

	if (isset($_POST["passwd"]))
	{
		$fp = @fopen("sleep", "r") or exit(1);
		$sleep = fgets($fp);
		fclose($fp);
		
		require_once("setstartup.inc.php");
		
		if ($sleep < time() && !strcmp(md5($_POST["passwd"]), ADMIN_PASSWD))
		{		
			session_regenerate_id();
			
			$_SESSION["fingerprint"] = md5(generate_fingerprint());
			
			header("Location: index.php");
			exit;
		}
		
		$fp = @fopen("sleep", "w") or exit(1);
		fwrite($fp, time() + DELAY);
		fclose($fp);
	}	
	
	require_once("header.inc.php");

	echo "<form action=\"login.php\" method=\"post\">\n";
	echo "\t<fieldset>\n";
	echo "\t\t<legend>Admin Login</legend>\n\n";
	
	echo "\t\t<input type=\"password\" name=\"passwd\" />\n";
	echo "\t\t<input type=\"submit\" value=\"Login\" />\n";
	echo "\t</fieldset>\n";
	echo "</form>\n\n";
	
	require_once("footer.inc.php");

?>
