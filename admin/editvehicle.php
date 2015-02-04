<?php

	session_start();
	
/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");
	
	if (!empty($_POST))
	{
		if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())
		{ foreach ($_POST as $key => $value) { $_POST[$key] = stripslashes($value); } }
		
		if (isset($_POST["section"])) { $_POST["section"] = !($_POST["section"] & 1) ? 1 : 2; }
		
		$col_expr = null;
		
		foreach ($_POST as $name => $value)
		{ $col_expr .= mysql_real_escape_string($name) . "='" .mysql_real_escape_string($value). "', "; }
		
		$col_expr = substr($col_expr, 0, -2);
		
		mysql_query("UPDATE vehicles SET {$col_expr} WHERE id_vehicle={$_GET["id"]}") or exit(mysql_error());
		
		js_data_updater();
		
		header("Location: editvehicle.php?id={$_GET["id"]}");
		exit;
	}
	
/*******************************************************************************************************************/
	
	($d_result = mysql_query("SELECT * FROM vehicles WHERE id_vehicle={$_GET["id"]}")) 
	&& mysql_num_rows($d_result) 
	or exit(mysql_error());
	
	$i_result = mysql_query("SELECT id_image FROM images WHERE id_vehicle={$_GET["id"]} ORDER BY primary_image DESC") 
	or exit(mysql_error());

/*******************************************************************************************************************/
	
	file_exists("../vf.xml") or exit("Ficheiro crucial em falta!");
	
	require_once("header.inc.php");
	
	$vf = simplexml_load_file("../vf.xml");
	
	echo "<form action=\"editvehicle.php?id={$_GET["id"]}\" method=\"post\">\n";
	echo "\t<fieldset>\n";
	echo "\t\t<legend>Dados</legend>\n\n";
	
	$d_row = mysql_fetch_row($d_result);
	
	$offset = 1; /* skip the first column value */
	
	foreach ($vf->characteristic as $characteristic)
	{
		echo "\t\t<label for=\"l_{$characteristic->codname}\">", utf8_decode($characteristic->name), "</label>\n";
		echo "\t\t\t<input type=\"text\" name=\"{$characteristic->codname}\" id=\"l_{$characteristic->codname}\" ";
		echo "value=\"", htmlentities($d_row[$offset++]), "\" />\n";
	}
	
	$s_value = $d_row[$offset++];
	
	echo "\t\t<label for=\"l_nv\" class=\"radio\">Novo</label>\n";
	echo "\t\t\t<input type=\"radio\" name=\"section\" value=\"0\" id=\"l_nv\" ";
	echo !strcmp($s_value, "Novos") ? "checked=\"checked\" " : "", "/>\n";
	
	echo "\t\t<label for=\"l_uv\" class=\"radio\">Usado</label>\n";
	echo "\t\t\t<input type=\"radio\" name=\"section\" value=\"1\" id=\"l_uv\" ";
	echo !strcmp($s_value, "Usados") ? "checked=\"checked\" " : "", "/>\n";
	
	echo "\t\t<label for=\"l_features\">Equipamento</label>\n";
	echo "\t\t\t<textarea cols=\"40\" rows=\"5\" name=\"features\" id=\"l_features\">";
	echo htmlentities($d_row[$offset]), "</textarea>\n\n";
	
	echo "\t\t<input type=\"submit\" value=\"Actualizar\" />\n";
	echo "\t</fieldset>\n";
	echo "</form>\n\n";
	
	echo "<form enctype=\"multipart/form-data\" action=\"addimage.php\" method=\"post\">\n";
	echo "\t<fieldset>\n";
	echo "\t\t<legend>Imagens</legend>\n\n";
	echo "\t\t<input type=\"hidden\" name=\"vid\" value=\"{$_GET["id"]}\" />\n";
	echo "\t\t<input type=\"file\" name=\"userfile\" />\n";
	echo "\t\t<input type=\"submit\" value=\"Upload\" />\n";
	
	
	if (mysql_num_rows($i_result))
	{
		echo "\n\t\t<div id=\"images\">\n";
		
		for ($row_number = 0; list($id_image) = mysql_fetch_row($i_result); $row_number++)
		{
			echo "\t\t\t<div class=\"image\">\n";
			echo "\t\t\t\t<img alt=\"\" src=\"thumbnail.php?id={$id_image}\" />\n";
			
			if ($row_number)
			{ 
				echo "\t\t\t\t<a href=\"#\" onclick=\"pidsetup('{$id_image}');\">Tornar principal</a>\n";
				echo "\t\t\t\t<span>&#x25AA;</span>\n";
			}
			
			echo "\t\t\t\t<a href=\"#\" onclick=\"return imageremoval('{$id_image}');\">Remover</a>\n";			
			echo "\t\t\t</div>\n";
		}
		
		echo "\t\t</div>\n";
	}
	
	echo "\t</fieldset>\n";
	echo "</form>\n\n";
	
	echo "<p id=\"back\"><span>&#x25AA;</span> <a href=\"index.php\">Terminar</a></p>\n\n";
	
	require_once("footer.inc.php");

?>
