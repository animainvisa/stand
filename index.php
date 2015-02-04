<?php
	
	$fp = @fopen("admin/highlight", "r") or exit(1);
	$highlight_id = fgets($fp);
	fclose($fp);
	
	require_once("header.inc.php");
	
	echo "\t\t<div id=\"search\">\n";
	echo "\t\t\t<h3>Pesquisa</h3>\n\n";
			
	echo "\t\t\t<form action=\"vehicles.php\" method=\"get\">\n";
	echo "\t\t\t\t<fieldset>\n";	
	echo "\t\t\t\t\t<label for=\"l_make\">Marca</label>\n";
	echo "\t\t\t\t\t\t<select name=\"make\" id=\"l_make\" onchange=\"getmodels(this.value);\">\n";
	echo "\t\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n";
	echo "\t\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t\t<label for=\"l_model\">Modelo</label>\n";
	echo "\t\t\t\t\t\t<select name=\"model\" id=\"l_model\">\n"; 
	echo "\t\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n"; 
	echo "\t\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t\t<label for=\"l_section\">Secção</label>\n";
	echo "\t\t\t\t\t\t<select name=\"section\" id=\"l_section\">\n";
	echo "\t\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n";
	echo "\t\t\t\t\t\t\t<option value=\"Novos\">Novos</option>\n";
	echo "\t\t\t\t\t\t\t<option value=\"Usados\">Usados</option>\n";
	echo "\t\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t\t<label for=\"l_yf\">Ano</label>\n";
	echo "\t\t\t\t\t\t<input type=\"text\" name=\"yearf\" size=\"4\" id=\"l_yf\" />\n";
	echo "\t\t\t\t\t\t<label for=\"l_yt\" class=\"to\">a</label>\n";
	echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"yeart\" size=\"4\" id=\"l_yt\" />\n\n";
	
	echo "\t\t\t\t\t<label for=\"l_pf\">Preço</label>\n";
	echo "\t\t\t\t\t\t<input type=\"text\" name=\"pricef\" size=\"8\" id=\"l_pf\" />\n";
	echo "\t\t\t\t\t\t<label for=\"l_pt\" class=\"to\">até</label>\n";
	echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"pricet\" size=\"8\" id=\"l_pt\" />\n\n";
	
	echo "\t\t\t\t\t<input type=\"submit\" value=\"Pesquisar\" />\n";
	echo "\t\t\t\t</fieldset>\n";
	echo "\t\t\t</form>\n";
	echo "\t\t</div>\n";
		
	if (strlen($highlight_id))
	{
		($vehicle_data = mysql_query("SELECT make, model, version, price FROM vehicles WHERE 
							id_vehicle={$highlight_id}")) && 
		($image_data = mysql_query("SELECT id_image FROM images WHERE id_vehicle={$highlight_id} ORDER BY 
							primary_image DESC LIMIT 1")) or 
		ob_end_clean() && 
		exit(mysql_error());
		
		if (mysql_num_rows($image_data))
		{
			echo "\n\t\t<div id=\"highlight\">\n";
			echo "\t\t\t<h3>Destaque</h3>\n\n";
			
			echo "\t\t\t<a href=\"vehicle.php?id={$highlight_id}\"><img alt=\"\" src=\"thumbnail.php?id=";
			echo mysql_result($image_data, 0), "&amp;primary\" /></a>\n\n";
			
			list($make, $model, $version, $price) = mysql_fetch_row($vehicle_data);
			
			echo "\t\t\t<p>{$make} {$model} {$version} &#x25AA; {$price}</p>\n";
			echo "\t\t</div>\n";
		}		
	}	
	
	require_once("footer.inc.php");

?>
