<?php

	session_start();
	
/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!empty($_POST))
	{
		require_once("setstartup.inc.php");
		
		if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())
		{ foreach ($_POST as $key => $value) { $_POST[$key] = stripslashes($value); } }
		
		if (isset($_POST["section"])) { $_POST["section"] = !($_POST["section"] & 1) ? 1 : 2; }
		
		$columns = $data = null;
		
		foreach ($_POST as $name => $value)
		{
			$columns .= mysql_real_escape_string($name) . ", ";
			$data .= "'" .mysql_real_escape_string($value). "', ";
		}
		
		$columns = substr($columns, 0, -2);
		$data = substr($data, 0, -2);
		
		mysql_query("INSERT INTO vehicles ({$columns}) VALUES ({$data})") or exit(mysql_error());
	
		js_data_updater();
	
		$id = mysql_result(mysql_query("SELECT LAST_INSERT_ID()"), 0);		
		
		header("Location: editvehicle.php?id={$id}");
		exit;
	}	
	
	file_exists("../vf.xml") or exit("Ficheiro crucial em falta!");
	
	require_once("header.inc.php");
	
	$vf = simplexml_load_file("../vf.xml");
	
	echo "<form action=\"addvehicle.php\" method=\"post\">\n";
	echo "\t<fieldset>\n";
	echo "\t\t<legend>Dados</legend>\n\n";
	
	foreach ($vf->characteristic as $characteristic)
	{
		echo "\t\t<label for=\"l_{$characteristic->codname}\">", utf8_decode($characteristic->name), "</label>\n";
		echo "\t\t\t<input type=\"text\" name=\"{$characteristic->codname}\" id=\"l_{$characteristic->codname}\" />\n";
	}
	
	echo "\t\t<label for=\"l_nv\" class=\"radio\">Novo</label>\n";
	echo "\t\t\t<input type=\"radio\" name=\"section\" value=\"0\" id=\"l_nv\" checked=\"checked\" />\n";
	echo "\t\t<label for=\"l_uv\" class=\"radio\">Usado</label>\n";
	echo "\t\t\t<input type=\"radio\" name=\"section\" value=\"1\" id=\"l_uv\" />\n";
	
	echo "\t\t<label for=\"l_features\">Equipamento</label>\n";
	echo "\t\t\t<textarea cols=\"40\" rows=\"5\" name=\"features\" id=\"l_features\"></textarea>\n\n";
	
	echo "\t\t<input type=\"submit\" value=\"Inserir\" />\n";
	echo "\t</fieldset>\n";
	echo "</form>\n\n";
	
	echo "<p id=\"back\"><span>&#x25AA;</span> <a href=\"index.php\">Voltar</a></p>\n\n";
	
	require_once("footer.inc.php");

?>
