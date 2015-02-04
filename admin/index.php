<?php

	session_start();
	
/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/
	
	if (isset($_GET["page"]) && !ctype_digit($_GET["page"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	$query = "SELECT id_vehicle, make, model, version FROM vehicles ORDER BY id_vehicle DESC";
	
	$page = isset($_GET["page"]) ? $_GET["page"] : 0;
	
	$l_query = "{$query} LIMIT " .($page * MAX_ENTRIES). ", " . MAX_ENTRIES;
	
	$vehicles_data = mysql_query($l_query) or exit(mysql_error());
	
	
	ob_start();
	
	require_once("header.inc.php");
	
	echo "<div id=\"links\">\n";
	echo "\t<ul>\n";
	echo "\t\t<li><span>&#x25AA;</span> <a href=\"addvehicle.php\">Adicionar Veículo</a></li>\n";
	echo "\t\t<li><span>&#x25AA;</span> <a href=\"logout.php\">Logout</a></li>\n";
	echo "\t</ul>\n";
	echo "</div>\n\n";
	
	if (mysql_num_rows($vehicles_data))
	{
		echo "<form id=\"highlight\" action=\"edithighlight.php\" method=\"post\">\n";
		echo "\t<fieldset>\n";
		echo "\t\t<legend>Destaque ID</legend>\n\n";
		
		$fp = @fopen("highlight", "r") or ob_end_clean() && exit(1);
		$highlight_id = fgets($fp);
		fclose($fp);
		
		echo "\t\t<input type=\"text\" name=\"id\" size=\"8\" value=\"{$highlight_id}\" />\n";
		echo "\t\t<input type=\"submit\" value=\"Actualizar\" />\n";
		echo "\t</fieldset>\n";
		echo "</form>\n\n";
		
	
		echo "<div id=\"vehicles\">\n";
		echo "\t<table>\n";
		echo "\t\t<thead>\n";
		echo "\t\t\t<tr>\n";
		echo "\t\t\t\t<th>ID</th>\n";
		echo "\t\t\t\t<th>Marca / Modelo / Versão</th>\n";
		echo "\t\t\t\t<th>Imagem</th>\n";
		echo "\t\t\t\t<th>Remover</th>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t</thead>\n";
		echo "\t\t<tbody>\n";
		
		while (list($id_vehicle, $make, $model, $version) = mysql_fetch_row($vehicles_data))
		{
			echo "\t\t\t<tr>\n";
			echo "\t\t\t\t<td><a href=\"editvehicle.php?id={$id_vehicle}\">{$id_vehicle}</a></td>\n";
			echo "\t\t\t\t<td>{$make} {$model} {$version}</td>\n";
		
			$image_data = mysql_query("SELECT id_image FROM images WHERE id_vehicle={$id_vehicle} 
						ORDER BY primary_image DESC LIMIT 1") or ob_end_clean() && exit(mysql_error());			
			
			echo "\t\t\t\t<td>";
			echo mysql_num_rows($image_data) 
					? "<img alt=\"\" src=\"thumbnail.php?id=" .mysql_result($image_data, 0). "\" />" 
					: "n/a";
			echo "</td>\n";
			
			echo "\t\t\t\t<td><a href=\"#\" onclick=\"return vehicleremoval('{$id_vehicle}');\">x</a></td>\n";
			echo "\t\t\t</tr>\n";
		}
		
		echo "\t\t</tbody>\n";
		echo "\t</table>\n\n";
		

		$q_result = mysql_query($query) or ob_end_clean() && exit(mysql_error());
		
		$num_rows = mysql_num_rows($q_result); 
		
		
		$num_pages = intval($num_rows / MAX_ENTRIES) + 1;
		
		!($num_rows % MAX_ENTRIES) && $num_pages--;		
		
		
		echo "\t<div id=\"pagination\">\n";
		echo "\t\t<ul>\n";
		
		for ($i=0; $i < $num_pages; $i++)
		{ echo "\t\t\t<li>", ($i != $page) ? "<a href=\"index.php?page={$i}\">" .($i+1). "</a>" : $i+1, "</li>\n"; }
		
		echo "\t\t</ul>\n";
		echo "\t</div>\n";		
		echo "</div>\n\n";
	}
	
	require_once("footer.inc.php");
	
?>
